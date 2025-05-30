<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;
use App\Models\WorkHour;
use Carbon\Carbon;

class JobController extends Controller
{
    /*
     * Controlador encargado de gestionar los trabajos.
     * Permite crear, editar, asignar y consultar trabajos realizados,
     * así como asociar materiales, trabajadores y horas.
     */
    public function updateHour(Request $request, Job $job, WorkHour $hour)
    {
        // Verificar que la hora pertenece al trabajo dado
        if ($hour->job_id !== $job->id) {
            abort(403, 'No autorizado.');
        }

        // Validar que las horas sean válidas
        $request->validate([
            'hours' => 'required|numeric|min:0.1|max:24',
        ]);

        $hour->hours = $request->hours;
        $hour->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Horas actualizadas correctamente.');
    }
    public function updateMaterial(Request $request, Job $job, StockMovement $movement)
    {
        // Verificar que el movimiento pertenece al trabajo
        if ($movement->job_id !== $job->id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'quantity' => 'required|numeric|min:0.1'
        ]);

        $newQuantity = $request->input('quantity');
        $oldQuantity = $movement->quantity;
        $difference = $newQuantity - $oldQuantity;

        $material = $movement->material;

        if ($difference > 0) {

            if ($material->quantity < $difference) {
                return back()->withErrors(['quantity' => 'No hay suficiente cantidad disponible del material.']);
            }
            // Descontar del stock global
            $material->quantity -= $difference;
        } elseif ($difference < 0) {

            $material->quantity += abs($difference);
        }


        $material->save();
        $movement->quantity = $newQuantity;
        $movement->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Cantidad actualizada correctamente y stock ajustado.');
    }
    public function addHours(Request $request, Job $job)
    {
        $request->validate([
            'hours' => 'required|numeric|min:0.1|max:24',
        ]);

        WorkHour::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
            'hours' => $request->hours,
        ]);

        return back()->with('success', 'Horas registradas correctamente.');
    }
    public function addMaterial(Request $request, $id)
    {

        $job = Job::findOrFail($id);

        // Validar que el material existe y que la cantidad es válida
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|integer|min:1',
        ]);


        $material = Material::findOrFail($request->material_id);

        // Comprobar que hay suficiente material disponible
        if ($material->quantity < $request->quantity) {
            return back()->with('error', 'No hay suficiente material disponible.');
        }


        StockMovement::create([
            'material_id' => $material->id,
            'job_id' => $job->id,
            'quantity' => $request->quantity,
            'movement_type' => 'assigned', // O cualquier tipo que se adapte a tu caso
            'date' => now(),
            'user_id' => auth()->id(),
        ]);


        $material->quantity -= $request->quantity;
        $material->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Material añadido al trabajo y stock actualizado.');
    }
    public function index()
    {
        // Obtener trabajos con estado "finalizado"
        $jobs = Job::all();
        // Filtrar trabajos "finalizados" por más de 2 días
        $jobs = $jobs->map(function($job) {
            if ($job->status == 'finalizado') { // Si el trabajo está finalizado y su fecha de finalización es más de 2 días atrás
                $endDate = Carbon::parse($job->end_date);
                if ($endDate->diffInDays(Carbon::now()) > 2) {
                    $job->is_old = true; // Marcamos los trabajos como viejos
                } else {
                    $job->is_old = false;
                }
            }
            return $job;
        });

        return view('jobs.index', compact('jobs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->status = $request->status;
        if ($request->status === 'finalizado' && !$job->end_date) {
            $job->end_date = now();
        }
        $job->save();

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $users = User::all();
        $categories = \App\Models\Category::all();
        return view('jobs.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Job::create([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'sin_empezar',
            'user_id' => $request->user_id, // Asignamos el usuario al trabajo
        ]);

        return redirect()->route('jobs.index')->with('success', 'Trabajo creado correctamente.');
    }


    public function show(Job $job)
    {
        // Cargar todos los movimientos de stock relacionados con este trabajo
        $stockMovements = StockMovement::where('job_id', $job->id)->with('material')->get();

        // Cargar todos los materiales disponibles
        $materials = Material::all();

        $job->load('workHours.user'); // cargar también las horas con su usuario


        return view('jobs.show', compact('job', 'stockMovements', 'materials'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

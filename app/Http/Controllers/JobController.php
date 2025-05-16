<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function addMaterial(Request $request, $id)
    {
        // Buscar el trabajo
        $job = Job::findOrFail($id);

        // Validar que el material existe y que la cantidad es válida
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Buscar el material
        $material = Material::findOrFail($request->material_id);

        // Comprobar que hay suficiente material disponible
        if ($material->quantity < $request->quantity) {
            return back()->with('error', 'No hay suficiente material disponible.');
        }

        // Registrar el movimiento de stock (asignado a un trabajo)
        StockMovement::create([
            'material_id' => $material->id,
            'job_id' => $job->id,
            'quantity' => $request->quantity,
            'movement_type' => 'assigned', // O cualquier tipo que se adapte a tu caso
            'date' => now(),
            'user_id' => auth()->id(),
        ]);

        // Actualizar la cantidad de material en la base de datos
        $material->quantity -= $request->quantity;
        $material->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Material añadido al trabajo y stock actualizado.');
    }
    public function index()
    {
        $jobs = Job::all(); // Obtener todos los trabajos
        return view('jobs.index', compact('jobs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);  // Asegúrate de que se maneje correctamente si no se encuentra el trabajo
        $job->status = $request->status;  // Actualiza el estado del trabajo
        if ($request->status === 'finalizado' && !$job->end_date) {
            $job->end_date = now();
        }
        $job->save();  // Guarda el cambio

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('jobs.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Job::create([
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'sin_empezar',
            'user_id' => $request->user_id, // Asignamos el usuario al trabajo
        ]);

        return redirect()->route('jobs.index')->with('success', 'Trabajo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Cargar todos los movimientos de stock relacionados con este trabajo
        $stockMovements = StockMovement::where('job_id', $job->id)->with('material')->get();

        // Cargar todos los materiales disponibles
        $materials = Material::all();  // Esto carga todos los materiales

        // Pasamos tanto el trabajo como los materiales a la vista
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

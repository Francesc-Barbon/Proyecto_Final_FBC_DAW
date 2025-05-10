<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all(); // Obtener todos los trabajos
        return view('jobs.index', compact('jobs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);  // Asegúrate de que se maneje correctamente si no se encuentra el trabajo
        $job->status = $request->status;  // Actualiza el estado del trabajo
        $job->save();  // Guarda el cambio

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Job::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'sin_empezar',
        ]);

        return redirect()->route('jobs.index')->with('success', 'Trabajo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {

        $stockMovements = StockMovement::where('job_id', $job->id)->with('material')->get();

        return view('jobs.show', compact('job', 'stockMovements'));
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

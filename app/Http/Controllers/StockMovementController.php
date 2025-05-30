<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovementView;

class StockMovementController extends Controller
{
    /**
     * Controlador que gestiona los movimientos de stock (entradas y salidas).
     * Asocia materiales a trabajos, registra usos y reposiciones.
     */


    public function index()
    {

    }

    public function viewLog()
    {
        $movements = StockMovementView::orderByDesc('date')->get();
        return view('stock_movements.index', compact('movements'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

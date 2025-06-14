<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Controlador encargado de gestionar los materiales disponibles en stock.
     * Permite registrar nuevos materiales, editar su información y controlar su inventario.
     */
    public function index()
    {
        $materials = Material::paginate(10); // 10 materiales por página
        return view('materials.index', compact('materials'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'material_code' => 'required|string|max:50|unique:materials,material_code',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $material = Material::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'material_code' => $request->material_code,
            'unit_price' => $request->unit_price,
        ]);

        // Crear un movimiento de stock cuando se añade un material
        StockMovement::create([
            'material_id' => $material->id,
            'quantity' => $material->quantity,
            'movement_type' => 'added', // Tipo de movimiento: añadido
            'date' => now(),
            'user_id' => auth()->id(),
            'job_id' => null, // Si no se asocia a un trabajo, puede ser nulo
        ]);

        return redirect()->route('materials.index')->with('success', 'Material añadido con éxito.');
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
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'movement_type' => 'required|in:added,removed',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->quantity;
        $movementType = $request->movement_type;

        if ($movementType === 'removed' && $quantity > $material->quantity) {
            return back()->with('error', 'No puedes retirar más material del disponible.');
        }


        if ($movementType === 'added') {
            $material->quantity += $quantity;
        } else {
            $material->quantity -= $quantity;
        }

        $material->save();


        StockMovement::create([
            'material_id' => $material->id,
            'quantity' => $quantity,
            'movement_type' => $movementType,
            'date' => now(),
            'user_id' => auth()->id(),
            'job_id' => null,
        ]);

        return redirect()->route('materials.index')->with('success', 'Cantidad actualizada y movimiento registrado.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $material = Material::findOrFail($id);

        // Registrar un movimiento de stock con el tipo 'deleted'
        StockMovement::create([
            'material_id' => $material->id,
            'quantity' => $material->quantity,
            'movement_type' => 'deleted', // Tipo de movimiento: eliminado
            'date' => now(),
            'user_id' => auth()->id(),
            'job_id' => null,
        ]);


        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material eliminado correctamente y movimiento de stock registrado.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Puestos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('puestos/Puestos', [
            'puestos' => Puestos::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return Inertia::render('puestos/Puestos', [
            'puestos' => Puestos::paginate(10),
            'puesto'=> new Puestos(),
            'modo'=> 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        Puestos::create($request->all());

        return redirect()->route('puestos.index')->with('success', 'Puesto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Puestos $puestos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return Inertia::render('puestos/Puestos', [
            'puestos' => Puestos::paginate(10),
            'puesto'=> Puestos::find($id),
            'modo'=> 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $puestos)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);
        $puesto= Puestos::find($puestos);
        $puesto->update($request->all());

        return redirect()->route('puestos.index')->with('success', 'Puesto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Puestos $puestos)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Proveedor;


class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'contacto_nombre' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        \App\Models\Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado con éxito.');
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
        $proveedor = \App\Models\Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'contacto_nombre' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
        ]);

        $proveedor = \App\Models\Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
                        ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

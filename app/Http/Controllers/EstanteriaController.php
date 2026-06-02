<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Estanteria;

class EstanteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Obtener los datos 
            $estanterias = Estanteria::all(); 

            // 2. Pasar la variable a la vista
            return view('estanterias.index', compact('estanterias'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
        {
            // Buscamos todas las estanterías actuales para dibujarlas en el svg
            $estanterias_existentes = Estanteria::all(); 

            return view('estanterias.create', compact('estanterias_existentes'));
        }
        
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'ancho' => 'required|integer',
            'alto' => 'required|integer',
        ]);

        // --- LÓGICA DE COLISIÓN ---
        $nuevaX1 = $request->x;
        $nuevaX2 = $request->x + $request->ancho;
        $nuevaY1 = $request->y;
        $nuevaY2 = $request->y + $request->alto;

        $estanterias = \App\Models\Estanteria::all();

        foreach ($estanterias as $existente) {
            $exX1 = $existente->x;
            $exX2 = $existente->x + $existente->ancho;
            $exY1 = $existente->y;
            $exY2 = $existente->y + $existente->alto;

            // Comprobar si hay intersección
            $solapaX = $nuevaX1 < $exX2 && $nuevaX2 > $exX1;
            $solapaY = $nuevaY1 < $exY2 && $nuevaY2 > $exY1;

            if ($solapaX && $solapaY) {
                return back()->withErrors(['colision' => "La posición solapa con la estantería: {$existente->nombre}"])->withInput();
            }
        }
        

        \App\Models\Estanteria::create($request->all());
        return redirect()->route('estanterias.index')->with('success', 'Estantería creada.');
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

    // Formulario con los datos actuales
    public function edit(Estanteria $estanteria)
    {
        // Buscar todas menos la que estamos editando (para que no se solape consigo misma)
        $estanterias_existentes = Estanteria::where('id', '!=', $estanteria->id)->get();

        return view('estanterias.edit', compact('estanteria', 'estanterias_existentes'));
    }

    
    public function update(Request $request, Estanteria $estanteria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'ancho' => 'required|integer',
            'alto' => 'required|integer',
        ]);

        $estanteria->update($request->all());

        return redirect()->route('estanterias.index')
                        ->with('success', 'La estantería se ha movido/actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // Buscar la estantería por ID en la base de datos
    $estanteria = \App\Models\Estanteria::findOrFail($id);

    $estanteria->delete();

    return redirect()->route('estanterias.index')->with('success', 'Estantería eliminada correctamente del mapa.');
    }
}

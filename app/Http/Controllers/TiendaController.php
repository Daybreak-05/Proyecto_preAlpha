<?php

namespace App\Http\Controllers;

use App\Models\Estanteria;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index()
    {
        
    $estanterias = Estanteria::all();
    $estanterias = \App\Models\Estanteria::all();

    // Pasamos a la vista usando compact()
    return view('mapa', compact('estanterias'));
    }

    public function filtrarPorEstanteria($id)
    {
    // Carga los productos y también la relación estantería para que el JS no falle
    $productos = \App\Models\Producto::with('estanteria')
                ->where('estanteria_id', $id)
                ->where('stock_actual', '>', 0)
                ->get();

    return response()->json($productos);
    }
    
}

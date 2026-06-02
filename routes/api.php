<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Estanteria; // Asegúrate de que esta línea esté aquí

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/estanteria/{id}/productos', function ($id) {
    $estanteria = Estanteria::find($id);
    
    if (!$estanteria) {
        return response()->json(['error' => 'Estantería no encontrada'], 404);
    }

    return response()->json($estanteria->productos);
});
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Creamos un proveedor
        $prov = \App\Models\Proveedor::create([
            'nombre_empresa' => 'Suministros Paco',
            'contacto_nombre' => 'Paco G.',
            'telefono' => '600123456',
            'email' => 'paco@suministros.com'
        ]);

        // 2. Creamos estanterías con coordenadas para el mapa
        $e1 = \App\Models\Estanteria::create(['nombre' => 'Pasillo Central', 'x' => 50, 'y' => 50, 'ancho' => 200, 'alto' => 100]);
        $e2 = \App\Models\Estanteria::create(['nombre' => 'Zona Fríos', 'x' => 300, 'y' => 50, 'ancho' => 150, 'alto' => 100]);

        // 3. Creamos productos (uno caducado para probar)
        \App\Models\Producto::create([
            'nombre' => 'Leche Entera',
            'codigo_barras' => '123456',
            'stock_actual' => 20,
            'stock_minimo' => 5,
            'fecha_caducidad' => '2026-10-01',
            'precio' => 1.20,
            'estanteria_id' => $e1->id,
            'proveedor_id' => $prov->id
        ]);

        \App\Models\Producto::create([
            'nombre' => 'Yogur Caducado',
            'codigo_barras' => '987654',
            'stock_actual' => 5,
            'stock_minimo' => 2,
            'fecha_caducidad' => '2024-01-01', // Ya caducó
            'precio' => 0.50,
            'estanteria_id' => $e2->id,
            'proveedor_id' => $prov->id
        ]);
    }
}

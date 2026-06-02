<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'codigo_barras', 'stock_actual', 
        'stock_minimo', 'fecha_caducidad', 'precio', 
        'imagen', 'estanteria_id', 'proveedor_id'
    ];

    // Indicar que este campo es una fecha para que Laravel lo trate como objeto Carbon
    protected $casts = [
        'fecha_caducidad' => 'date',
    ];

    // Relación: El producto pertenece a una estantería
    public function estanteria(): BelongsTo
    {
        return $this->belongsTo(Estanteria::class);
    }

    // Relación: El producto pertenece a un proveedor
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    
    // Determina si el producto está próximo a caducar (dentro de 7 días)
    // para aplicar descuento
    
    public function estaProximoACaducar(): bool
    {
        if (!$this->fecha_caducidad) {
            return false;
        }

        $hoy = now()->startOfDay();
        $fechaProducto = $this->fecha_caducidad->startOfDay();
        
        // Si ya está caducado, no aplica descuento
        if ($fechaProducto < $hoy) {
            return false;
        }
        
        // Calcular días hasta caducidad
        $diasHastaVencimiento = $hoy->diffInDays($fechaProducto, false);
        return $diasHastaVencimiento <= 7;
    }

    
    // Calcula el precio con descuento si está próximo a caducar (30% desc)
    
    public function getPrecioConDescuento(): float
    {
        if ($this->estaProximoACaducar()) {
            return $this->precio * 0.7; // 30% descuento
        }
        return $this->precio;
    }

    
    // Retorna información de precio e descuento para la API
    
    public function getInfoPrecio(): array
    {
        $conDescuento = $this->estaProximoACaducar();
        return [
            'precio_original' => $this->precio,
            'precio_final' => $this->getPrecioConDescuento(),
            'descuento_aplicado' => $conDescuento,
            'porcentaje_descuento' => $conDescuento ? 30 : 0,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $table = 'pedido_items';

    protected $fillable = ['pedido_id', 'producto_id', 'nombre', 'cantidad', 'precio_unitario', 'subtotal', 'descuento_aplicado'];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'descuento_aplicado' => 'boolean',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}

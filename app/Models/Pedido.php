<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = ['codigo', 'fecha', 'metodo_pago', 'correo', 'total', 'estado'];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }
}

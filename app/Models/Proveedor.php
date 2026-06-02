<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
        // Con esto Laravel dejará de buscar "proveedors"
        protected $table = 'proveedores'; 

        protected $fillable = ['nombre_empresa', 'contacto_nombre', 'telefono', 'email'];
        
        // ... resto de tu código (relaciones, etc)

    // Relación: Un proveedor tiene muchos productos
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Estanteria extends Model
{
    protected $fillable = ['nombre', 'x', 'y', 'ancho', 'alto'];

    // App\Models\Estanteria.php
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    // Un "Accesor" extra (Bonus para tu nota): 
    // Devuelve true si hay algún producto caducado en esta estantería
    
    // Devuelve true si hay algún producto que caduca en los próximos 7 días
    // (pero que aún NO ha caducado)
    public function getTieneCaducidadProximaAttribute(): bool
    {
        $hoy = Carbon::today();
        $limite = Carbon::today()->addDays(7);
        
        return $this->productos
            ->filter(function ($p) use ($hoy, $limite) {
                if (!$p->fecha_caducidad) return false;
                return $p->fecha_caducidad >= $hoy && $p->fecha_caducidad <= $limite;
            })
            ->count() > 0;
    }

    // En App\Models\Estanteria.php

    public function getEstaVaciaAttribute(): bool
    {
        // Usamos count() sobre la relación cargada para que sea eficiente
        return $this->productos->count() === 0;
    }

    public function getTieneCaducadosAttribute(): bool
    {
        // Comprobamos si existe algún producto con fecha anterior a hoy
        return $this->productos
            ->filter(function ($p) {
                if (!$p->fecha_caducidad) return false;
                return $p->fecha_caducidad < Carbon::today();
            })
            ->count() > 0;
    }
}
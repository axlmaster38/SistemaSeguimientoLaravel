<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    protected $table = 'zonas';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado_registro',
    ];

    public function centros(): HasMany
    {
        return $this->hasMany(Centro::class);
    }

    public function centrosActivos(): HasMany
    {
        return $this->hasMany(Centro::class)->where('estado_registro', 'Activo');
    }
}

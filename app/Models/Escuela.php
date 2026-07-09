<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Escuela extends Model
{
    protected $table = 'escuelas';

    public $timestamps = false;

    protected $fillable = [
        'sigla',
        'nombre',
        'estado_registro',
    ];

    public function programas(): HasMany
    {
        return $this->hasMany(Programa::class);
    }
}

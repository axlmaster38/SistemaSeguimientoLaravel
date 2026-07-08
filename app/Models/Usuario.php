<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'identificacion',
        'usuario',
        'contrasena',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'rol',
        'estado',
        'fecha_registro',
        'fecha_actualiza',
    ];

    public function programasRegistrados(): HasMany
    {
        return $this->hasMany(Programa::class, 'usuario_registra_id');
    }

    public function programasActualizados(): HasMany
    {
        return $this->hasMany(Programa::class, 'usuario_actualiza_id');
    }

    public function estudiantesRegistrados(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'usuario_registra_id');
    }

    public function estudiantesActualizados(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'usuario_actualiza_id');
    }

    public function periodosAcademicosRegistrados(): HasMany
    {
        return $this->hasMany(PeriodoAcademico::class, 'usuario_registra_id');
    }

    public function periodosAcademicosActualizados(): HasMany
    {
        return $this->hasMany(PeriodoAcademico::class, 'usuario_actualiza_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'codigo_estu',
        'nombre',
        'apellido',
        'estado_academico',
        'email_institucional',
        'email_personal',
        'email_alternativo',
        'telefono',
        'direccion',
        'estado_registro',
        'centro_id',
        'programa_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualiza' => 'datetime',
    ];

    public function centro(): BelongsTo
    {
        return $this->belongsTo(Centro::class);
    }

    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    public function usuarioRegistra(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }

    public function denuncias(): HasMany
    {
        return $this->hasMany(Denuncia::class);
    }

    public function historicos(): HasMany
    {
        return $this->hasMany(HistoricoEstudiante::class);
    }

    public function setNombreAttribute(string $value): void
    {
        $this->attributes['nombre'] = Str::title(trim($value));
    }

    public function setApellidoAttribute(string $value): void
    {
        $this->attributes['apellido'] = Str::title(trim($value));
    }
}

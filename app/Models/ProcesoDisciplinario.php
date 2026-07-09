<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcesoDisciplinario extends Model
{
    protected $table = 'procesos_disciplinarios';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'fecha_apertura',
        'estado_proceso',
        'proceso_antiguo',
        'denuncia_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }

    public function usuarioRegistra(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }

    public function tipologiasFalta(): BelongsToMany
    {
        return $this->belongsToMany(
            TipologiaFalta::class,
            'tipologia_falta_proceso',
            'proceso_disciplinario_id',
            'tipologia_falta_id'
        );
    }

    public function articulos(): BelongsToMany
    {
        return $this->belongsToMany(
            Articulo::class,
            'articulo_proceso',
            'proceso_disciplinario_id',
            'articulo_id'
        );
    }

    public function historicos(): HasMany
    {
        return $this->hasMany(HistoricoEstudiante::class);
    }

    public function descargos(): HasMany
    {
        return $this->hasMany(Descargo::class);
    }

    public function pruebas(): HasMany
    {
        return $this->hasMany(Prueba::class);
    }

    public function decisiones(): HasMany
    {
        return $this->hasMany(Decision::class);
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class);
    }

    public function apelaciones(): HasMany
    {
        return $this->hasMany(Apelacion::class);
    }
}

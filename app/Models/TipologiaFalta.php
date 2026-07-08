<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipologiaFalta extends Model
{
    protected $table = 'tipologias_faltas';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'nombre',
        'descripcion',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    public function usuarioRegistra(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }

    public function procesosDisciplinarios(): BelongsToMany
    {
        return $this->belongsToMany(
            ProcesoDisciplinario::class,
            'tipologia_falta_proceso',
            'tipologia_falta_id',
            'proceso_disciplinario_id'
        );
    }
}

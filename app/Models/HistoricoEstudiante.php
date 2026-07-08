<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoEstudiante extends Model
{
    protected $table = 'historico_estudiantes';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = null;

    protected $fillable = [
        'estudiante_id',
        'proceso_disciplinario_id',
        'programa_id',
        'fecha_registro',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function procesoDisciplinario(): BelongsTo
    {
        return $this->belongsTo(ProcesoDisciplinario::class);
    }

    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }
}

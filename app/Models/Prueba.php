<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prueba extends Model
{
    protected $table = 'pruebas';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'nombre',
        'tipo_prueba',
        'descripcion',
        'procedencia',
        'archivo',
        'proceso_disciplinario_id',
        'descargo_id',
        'apelacion_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'datetime',
            'fecha_actualiza' => 'datetime',
        ];
    }

    public function procesoDisciplinario(): BelongsTo
    {
        return $this->belongsTo(ProcesoDisciplinario::class);
    }

    public function descargo(): BelongsTo
    {
        return $this->belongsTo(Descargo::class);
    }

    public function apelacion(): BelongsTo
    {
        return $this->belongsTo(Apelacion::class);
    }

    public function usuarioRegistra(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }
}

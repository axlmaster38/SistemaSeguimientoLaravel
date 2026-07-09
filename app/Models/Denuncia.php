<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Denuncia extends Model
{
    protected $table = 'denuncias';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'fecha_creacion',
        'descripcion',
        'justificacion',
        'estado_denuncia',
        'denuncia_antigua',
        'estado_registro',
        'estudiante_id',
        'usuario_registra_evalua_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'denuncia_antigua' => 'boolean',
        'fecha_registro' => 'datetime',
        'fecha_actualiza' => 'datetime',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function usuarioRegistraEvalua(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_evalua_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }

    public function procesos(): HasMany
    {
        return $this->hasMany(ProcesoDisciplinario::class);
    }
}

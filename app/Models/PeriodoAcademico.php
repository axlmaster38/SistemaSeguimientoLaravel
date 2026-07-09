<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodoAcademico extends Model
{
    protected $table = 'periodos_academicos';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'codigo',
        'periodo',
        'anio',
        'fecha_inicio',
        'fecha_fin',
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

    public function sancionesComoPeriodoInicial(): HasMany
    {
        return $this->hasMany(Sancion::class, 'periodo_inicial_sancion_id');
    }

    public function sancionesComoPeriodoFinal(): HasMany
    {
        return $this->hasMany(Sancion::class, 'periodo_final_sancion_id');
    }
}

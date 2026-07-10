<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sancion extends Model
{
    protected $table = 'sanciones';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'tipo_sancion',
        'descripcion',
        'numero_periodos',
        'periodo_inicial_sancion_id',
        'periodo_final_sancion_id',
        'estado_sancion',
        'estado_registro',
        'decision_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    protected function casts(): array
    {
        return [
            'numero_periodos' => 'integer',
            'fecha_registro' => 'datetime',
            'fecha_actualiza' => 'datetime',
        ];
    }

    public function decision(): BelongsTo
    {
        return $this->belongsTo(Decision::class);
    }

    public function periodoInicialSancion(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_inicial_sancion_id');
    }

    public function periodoFinalSancion(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_final_sancion_id');
    }

    public function usuarioRegistra(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_registra_id');
    }

    public function usuarioActualiza(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_actualiza_id');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class);
    }
}

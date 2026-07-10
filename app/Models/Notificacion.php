<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_notificacion',
        'fecha_2da_notificacion',
        'instancia',
        'archivo',
        'estado_registro',
        'proceso_disciplinario_id',
        'sancion_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    protected function casts(): array
    {
        return [
            'fecha_2da_notificacion' => 'datetime',
            'fecha_registro' => 'datetime',
            'fecha_actualiza' => 'datetime',
        ];
    }

    public function procesoDisciplinario(): BelongsTo
    {
        return $this->belongsTo(ProcesoDisciplinario::class);
    }

    public function sancion(): BelongsTo
    {
        return $this->belongsTo(Sancion::class);
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

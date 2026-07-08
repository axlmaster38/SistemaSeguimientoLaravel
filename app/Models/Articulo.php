<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Articulo extends Model
{
    protected $table = 'articulos';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'no_articulo',
        'descripcion',
        'capitulo',
        'literal',
        'normatividad_id',
        'usuario_registra_id',
        'usuario_actualiza_id',
        'fecha_registro',
        'fecha_actualiza',
    ];

    public function normatividad(): BelongsTo
    {
        return $this->belongsTo(Normatividad::class);
    }

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
            'articulo_proceso',
            'articulo_id',
            'proceso_disciplinario_id'
        );
    }
}

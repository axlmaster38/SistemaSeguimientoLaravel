<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticuloProceso extends Model
{
    protected $table = 'articulo_proceso';

    public $timestamps = false;

    protected $fillable = [
        'articulo_id',
        'proceso_disciplinario_id',
    ];

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class);
    }

    public function procesoDisciplinario(): BelongsTo
    {
        return $this->belongsTo(ProcesoDisciplinario::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipologiaFaltaProceso extends Model
{
    protected $table = 'tipologia_falta_proceso';

    public $timestamps = false;

    protected $fillable = [
        'tipologia_falta_id',
        'proceso_disciplinario_id',
    ];

    public function tipologiaFalta(): BelongsTo
    {
        return $this->belongsTo(TipologiaFalta::class);
    }

    public function procesoDisciplinario(): BelongsTo
    {
        return $this->belongsTo(ProcesoDisciplinario::class);
    }
}

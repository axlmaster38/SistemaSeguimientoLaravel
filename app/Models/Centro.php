<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Centro extends Model
{
    protected $table = 'centros';

    public $timestamps = false;

    protected $fillable = [
        'centro',
        'zona_id',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    protected $table = 'zonas';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function centros(): HasMany
    {
        return $this->hasMany(Centro::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualiza';

    protected $fillable = [
        'identificacion',
        'usuario',
        'contrasena',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'rol',
        'estado',
        'fecha_registro',
        'fecha_actualiza',
    ];

    public function programasRegistrados(): HasMany
    {
        return $this->hasMany(Programa::class, 'usuario_registra_id');
    }

    public function programasActualizados(): HasMany
    {
        return $this->hasMany(Programa::class, 'usuario_actualiza_id');
    }

    public function estudiantesRegistrados(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'usuario_registra_id');
    }

    public function estudiantesActualizados(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'usuario_actualiza_id');
    }

    public function periodosAcademicosRegistrados(): HasMany
    {
        return $this->hasMany(PeriodoAcademico::class, 'usuario_registra_id');
    }

    public function periodosAcademicosActualizados(): HasMany
    {
        return $this->hasMany(PeriodoAcademico::class, 'usuario_actualiza_id');
    }

    public function denunciasRegistradasEvaluadas(): HasMany
    {
        return $this->hasMany(Denuncia::class, 'usuario_registra_evalua_id');
    }

    public function denunciasActualizadas(): HasMany
    {
        return $this->hasMany(Denuncia::class, 'usuario_actualiza_id');
    }

    public function tipologiasFaltasRegistradas(): HasMany
    {
        return $this->hasMany(TipologiaFalta::class, 'usuario_registra_id');
    }

    public function tipologiasFaltasActualizadas(): HasMany
    {
        return $this->hasMany(TipologiaFalta::class, 'usuario_actualiza_id');
    }

    public function normatividadesRegistradas(): HasMany
    {
        return $this->hasMany(Normatividad::class, 'usuario_registra_id');
    }

    public function normatividadesActualizadas(): HasMany
    {
        return $this->hasMany(Normatividad::class, 'usuario_actualiza_id');
    }

    public function articulosRegistrados(): HasMany
    {
        return $this->hasMany(Articulo::class, 'usuario_registra_id');
    }

    public function articulosActualizados(): HasMany
    {
        return $this->hasMany(Articulo::class, 'usuario_actualiza_id');
    }

    public function procesosDisciplinariosRegistrados(): HasMany
    {
        return $this->hasMany(ProcesoDisciplinario::class, 'usuario_registra_id');
    }

    public function procesosDisciplinariosActualizados(): HasMany
    {
        return $this->hasMany(ProcesoDisciplinario::class, 'usuario_actualiza_id');
    }

    public function descargosRegistrados(): HasMany
    {
        return $this->hasMany(Descargo::class, 'usuario_registra_id');
    }

    public function descargosActualizados(): HasMany
    {
        return $this->hasMany(Descargo::class, 'usuario_actualiza_id');
    }

    public function apelacionesRegistradas(): HasMany
    {
        return $this->hasMany(Apelacion::class, 'usuario_registra_id');
    }

    public function apelacionesActualizadas(): HasMany
    {
        return $this->hasMany(Apelacion::class, 'usuario_actualiza_id');
    }

    public function pruebasRegistradas(): HasMany
    {
        return $this->hasMany(Prueba::class, 'usuario_registra_id');
    }

    public function pruebasActualizadas(): HasMany
    {
        return $this->hasMany(Prueba::class, 'usuario_actualiza_id');
    }

    public function decisionesRegistradas(): HasMany
    {
        return $this->hasMany(Decision::class, 'usuario_registra_id');
    }

    public function decisionesActualizadas(): HasMany
    {
        return $this->hasMany(Decision::class, 'usuario_actualiza_id');
    }

    public function sancionesRegistradas(): HasMany
    {
        return $this->hasMany(Sancion::class, 'usuario_registra_id');
    }

    public function sancionesActualizadas(): HasMany
    {
        return $this->hasMany(Sancion::class, 'usuario_actualiza_id');
    }

    public function notificacionesRegistradas(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'usuario_registra_id');
    }

    public function notificacionesActualizadas(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'usuario_actualiza_id');
    }
}

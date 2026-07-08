<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion', 20)->unique();
            $table->string('usuario', 30)->unique();
            $table->string('contrasena', 128);
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->string('email', 254);
            $table->string('telefono', 30);
            $table->string('rol', 30)->index();
            $table->string('estado', 30)->index();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_actualiza')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

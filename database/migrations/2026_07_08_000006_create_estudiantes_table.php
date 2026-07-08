<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_estu', 20)->unique();
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->string('estado_academico', 30)->index();
            $table->string('email_institucional', 254)->index();
            $table->string('email_personal', 254)->index();
            $table->string('email_alternativo', 254)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->foreignId('centro_id')
                ->constrained('centros')
                ->restrictOnDelete();
            $table->foreignId('programa_id')
                ->constrained('programas')
                ->restrictOnDelete();
            $table->foreignId('usuario_registra_id')
                ->nullable()
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->foreignId('usuario_actualiza_id')
                ->nullable()
                ->constrained('usuarios')
                ->restrictOnDelete();
            $table->timestamp('fecha_registro')->nullable();
            $table->timestamp('fecha_actualiza')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};

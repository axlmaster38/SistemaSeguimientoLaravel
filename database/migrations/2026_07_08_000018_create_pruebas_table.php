<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pruebas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('tipo_prueba', 50);
            $table->text('descripcion')->nullable();
            $table->string('procedencia', 50);
            $table->string('archivo', 255);
            $table->foreignId('proceso_disciplinario_id')
                ->nullable()
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();
            $table->foreignId('descargo_id')
                ->nullable()
                ->constrained('descargos')
                ->restrictOnDelete();
            $table->foreignId('apelacion_id')
                ->nullable()
                ->constrained('apelaciones')
                ->restrictOnDelete();
            $table->foreignId('usuario_registra_id')
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
        Schema::dropIfExists('pruebas');
    }
};

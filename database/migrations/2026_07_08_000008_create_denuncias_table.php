<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_creacion')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('justificacion')->nullable();
            $table->string('estado_denuncia', 50)->index();
            $table->boolean('denuncia_antigua')->default(false);
            $table->foreignId('estudiante_id')
                ->constrained('estudiantes')
                ->restrictOnDelete();
            $table->foreignId('usuario_registra_evalua_id')
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
        Schema::dropIfExists('denuncias');
    }
};

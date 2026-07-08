<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_sancion', 40);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('numero_periodos')->default(1);
            $table->foreignId('periodo_inicial_sancion_id')
                ->nullable()
                ->constrained('periodos_academicos')
                ->restrictOnDelete();
            $table->foreignId('periodo_final_sancion_id')
                ->nullable()
                ->constrained('periodos_academicos')
                ->restrictOnDelete();
            $table->string('estado_sancion', 20);
            $table->foreignId('decision_id')
                ->nullable()
                ->constrained('decisiones')
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
        Schema::dropIfExists('sanciones');
    }
};

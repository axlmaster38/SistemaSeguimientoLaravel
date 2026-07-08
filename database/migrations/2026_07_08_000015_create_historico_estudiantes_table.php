<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')
                ->constrained('estudiantes')
                ->restrictOnDelete();
            $table->foreignId('proceso_disciplinario_id')
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();
            $table->foreignId('programa_id')
                ->constrained('programas')
                ->restrictOnDelete();
            $table->timestamp('fecha_registro')->nullable();

            $table->unique(
                ['estudiante_id', 'proceso_disciplinario_id'],
                'he_estudiante_proceso_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_estudiantes');
    }
};

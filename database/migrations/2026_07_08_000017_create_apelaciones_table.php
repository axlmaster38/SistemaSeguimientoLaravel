<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apelaciones', function (Blueprint $table) {
            $table->id();
            $table->text('motivo')->nullable();
            $table->string('tipo_apelacion', 50)->default('null');
            $table->foreignId('proceso_disciplinario_id')
                ->nullable()
                ->constrained('procesos_disciplinarios')
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
        Schema::dropIfExists('apelaciones');
    }
};

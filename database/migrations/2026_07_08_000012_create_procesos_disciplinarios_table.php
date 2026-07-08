<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesos_disciplinarios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_apertura')->nullable();
            $table->string('estado_proceso', 50)->index();
            $table->boolean('proceso_antiguo')->default(false);
            $table->foreignId('denuncia_id')
                ->constrained('denuncias')
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
        Schema::dropIfExists('procesos_disciplinarios');
    }
};

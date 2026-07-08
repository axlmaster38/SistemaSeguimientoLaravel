<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->default('null');
            $table->text('descripcion');
            $table->string('tipo_notificacion', 50);
            $table->timestamp('fecha_2da_notificacion')->nullable();
            $table->string('instancia', 50)->default('Primera Notificación');
            $table->string('archivo', 255);
            $table->foreignId('proceso_disciplinario_id')
                ->nullable()
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();
            $table->foreignId('sancion_id')
                ->nullable()
                ->constrained('sanciones')
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
        Schema::dropIfExists('notificaciones');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('no_articulo', 12)->index();
            $table->text('descripcion')->nullable();
            $table->string('capitulo', 30)->index();
            $table->text('literal')->nullable();
            $table->foreignId('normatividad_id')
                ->constrained('normatividades')
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
        Schema::dropIfExists('articulos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articulo_proceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('articulo_id')
                ->constrained('articulos')
                ->restrictOnDelete();
            $table->foreignId('proceso_disciplinario_id')
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();

            $table->unique(
                ['articulo_id', 'proceso_disciplinario_id'],
                'ap_articulo_proceso_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articulo_proceso');
    }
};

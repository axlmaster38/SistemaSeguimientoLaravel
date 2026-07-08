<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipologia_falta_proceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipologia_falta_id')
                ->constrained('tipologias_faltas')
                ->restrictOnDelete();
            $table->foreignId('proceso_disciplinario_id')
                ->constrained('procesos_disciplinarios')
                ->restrictOnDelete();

            $table->unique(
                ['tipologia_falta_id', 'proceso_disciplinario_id'],
                'tfp_tipologia_proceso_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipologia_falta_proceso');
    }
};

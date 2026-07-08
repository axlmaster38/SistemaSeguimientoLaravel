<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escuelas', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 8)->unique();
            $table->string('nombre', 100)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escuelas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $uniqueIndexes = DB::select("
            SHOW INDEX FROM `programas`
            WHERE `Column_name` = 'nombre'
            AND `Non_unique` = 0
        ");

        foreach ($uniqueIndexes as $index) {
            Schema::table('programas', function (Blueprint $table) use ($index) {
                $table->dropUnique($index->Key_name);
            });
        }

        Schema::table('programas', function (Blueprint $table) {
            $table->string('nombre', 150)->change();
        });
    }

    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->string('nombre', 30)->change();
        });
    }
};

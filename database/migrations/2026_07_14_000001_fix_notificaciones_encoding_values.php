<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('notificaciones')
            ->whereIn('instancia', [
                'Primera NotificaciÃƒÂ³n',
                'Primera NotificaciÃ³n',
            ])
            ->update(['instancia' => 'Primera Notificación']);

        DB::table('notificaciones')
            ->whereIn('instancia', [
                'Segunda NotificaciÃƒÂ³n',
                'Segunda NotificaciÃ³n',
            ])
            ->update(['instancia' => 'Segunda Notificación']);
    }

    public function down(): void
    {
        DB::table('notificaciones')
            ->where('instancia', 'Primera Notificación')
            ->update(['instancia' => 'Primera NotificaciÃ³n']);

        DB::table('notificaciones')
            ->where('instancia', 'Segunda Notificación')
            ->update(['instancia' => 'Segunda NotificaciÃ³n']);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Supprimer les anciennes colonnes
            $table->dropColumn([
                'day_of_week',
                'specific_date'
            ]);

            // Modifier les colonnes existantes
            $table->dateTime('start_time')->change();
            $table->dateTime('end_time')->change();
        });
    }

    public function down()
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Restaurer les colonnes supprimées
            $table->integer('day_of_week')->nullable();
            $table->date('specific_date')->nullable();

            // Restaurer les types de colonnes d'origine
            $table->time('start_time')->change();
            $table->time('end_time')->change();
        });
    }
}; 
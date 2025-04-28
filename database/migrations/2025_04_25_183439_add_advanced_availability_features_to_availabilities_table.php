<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('availabilities', function (Blueprint $table) {
            // Champs pour la récurrence avancée
            $table->string('recurrence_type')->nullable(); // weekly, biweekly, monthly
            $table->json('recurrence_config')->nullable(); // Configuration JSON pour la récurrence
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            
            // Champs pour les modèles de disponibilité
            $table->boolean('is_template')->default(false);
            $table->string('template_name')->nullable();
            
            // Champs pour l'optimisation des créneaux
            $table->integer('preparation_time')->default(0); // Temps en minutes
            $table->integer('slot_duration')->nullable(); // Durée du créneau en minutes
            $table->json('breaks')->nullable(); // Pauses (déjeuner, etc.)
            
            // Champs pour la synchronisation externe
            $table->string('external_calendar_id')->nullable();
            $table->string('external_event_id')->nullable();
            
            // Champs pour la priorisation
            $table->integer('priority')->default(0); // Plus le nombre est élevé, plus la priorité est haute
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropColumn([
                'recurrence_type',
                'recurrence_config',
                'valid_from',
                'valid_until',
                'is_template',
                'template_name',
                'preparation_time',
                'slot_duration',
                'breaks',
                'external_calendar_id',
                'external_event_id',
                'priority'
            ]);
        });
    }
};

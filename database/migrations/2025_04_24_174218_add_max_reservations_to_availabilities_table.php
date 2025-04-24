<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxReservationsToAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('availabilities', 'max_reservations')) {
            Schema::table('availabilities', function (Blueprint $table) {
                $table->integer('max_reservations')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('availabilities', 'max_reservations')) {
            Schema::table('availabilities', function (Blueprint $table) {
                $table->dropColumn('max_reservations');
            });
        }
    }
}

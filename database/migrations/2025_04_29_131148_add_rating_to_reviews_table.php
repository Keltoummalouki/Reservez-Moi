<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('service_id')->after('user_id');
            // Optionally, add a foreign key:               
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
            $table->dropColumn('rating');
            $table->dropColumn('comment');
        });
    }
}

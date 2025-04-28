<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('availability_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->json('config'); // Configuration des disponibilités
            $table->boolean('is_seasonal')->default(false);
            $table->date('season_start')->nullable();
            $table->date('season_end')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_templates');
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registration_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->bigInteger('participant_id')->unsigned();
            $table->enum('status', ['Registered', 'Joined', 'Cancelled'])->default('Registered');
            $table->timestamps();

            $table->unique(['activity_id', 'participant_id']);
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_activities');
    }
};

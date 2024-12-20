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
        Schema::create('complaint_violations', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('violation_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('creator_id')->unsigned();
            $table->text('complaint_description');
            $table->enum('status', ['Pending', 'Accept','Decline'])->default('Pending');
            $table->timestamps();

            $table->foreign('violation_id')->references('id')->on('violations')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_violations');
    }
};

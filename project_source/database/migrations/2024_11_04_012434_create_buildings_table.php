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
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('build_name', 255);
            //            $table->string('name');
            $table->integer('manager_id')->unsigned()->nullable();
            $table->enum('type', ['male', 'female']);
            $table->integer('floor_numbers');
            $table->integer('room_numbers');
            $table->integer('student_count')->default(0);
            $table->timestamps();

            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};

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
        Schema::create('residences', function (Blueprint $table) {
            $table->integer('stu_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('check_out_date')->nullable();
            $table->enum('status', ['Da dang ky', 'Da thanh toan', 'Da nhan phong', 'Da chuyen nhuong', 'Da tra phong'])->default('Da dang ky');
            $table->string('note', 200)->nullable();

            $table->primary(['stu_id', 'room_id', 'start_date']);
            $table->foreign('stu_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};

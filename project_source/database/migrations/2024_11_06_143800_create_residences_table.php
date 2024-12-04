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
            $table->increments('id');
            $table->integer('stu_id')->unsigned();

            $table->string('name', 255);
            $table->integer('room_id')->unsigned();
            $table->dateTime('start_date');
            //Thêm cột thời hạn
            $table->enum('duration', ['3 months', '6 months', '9 months', '12 months'])->default('3 months');
            $table->dateTime('end_date');
            $table->dateTime('check_out_date')->nullable();
            $table->enum('status', ['Registered', 'Paid', 'Checked in', 'Transfered', 'Checked out'])->default('Registered');
            $table->string('note', 200)->nullable();

            $table->unique(['stu_id', 'room_id', 'start_date']);
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

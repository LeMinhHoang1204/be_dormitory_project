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
            $table->bigInteger('stu_user_id')->unsigned();

            $table->integer('room_id')->unsigned();
            $table->dateTime('start_date');
            //Thêm cột thời hạn
            $table->integer('months_duration');
            $table->dateTime('end_date');
            $table->dateTime('check_out_date')->nullable();
            $table->enum('status', ['Registered', 'Paid', 'Checked in', 'Renewed', 'Changed Room', 'Checked out', 'Rejected', 'Refunded', 'Transfered'])->default('Registered');
            $table->string('note')->nullable();

            $table->unique(['stu_user_id', 'room_id', 'start_date']);
            $table->foreign('stu_user_id')->references('id')->on('users')->onDelete('cascade');
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

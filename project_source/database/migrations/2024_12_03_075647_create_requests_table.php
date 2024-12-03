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
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->enum('type', ['Change Room', 'Renewal', 'Check out', 'Fixing', 'Suggestion', 'Complaint']);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->dateTime('send_date');
            $table->dateTime('receive_date')->nullable();
            $table->dateTime('resolve_date')->nullable();
            $table->string('note', 200)->nullable();
            $table->bigInteger('forward_id')->unsigned()->nullable();
            $table->timestamps();

//            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('forward_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
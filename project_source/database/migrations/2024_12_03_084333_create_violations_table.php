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
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('creator_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->enum('type', ['Warning', 'Violation']);
            $table->string('title', 100);
            $table->string('description', 200)->nullable();
            $table->dateTime('occurred_at');
            $table->enum('status', ['Approved', 'Complained'])->default('Approved');
            $table->integer('minus_point');
            $table->string('note', 200)->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};

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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('creator_id')->unsigned();
            $table->string('title', 100);
            $table->string('description', 200)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('register_end_date');
            $table->integer('max_participants');
            $table->integer('registered_participants')->default(0);
            $table->decimal('ticket_price', 10, 2);
            $table->integer('bonus_point')->default(0);
            $table->enum('status', ['Pending', 'Ongoing', 'Done'])->default('Pending');
            $table->string('note', 200)->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

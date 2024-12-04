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
        Schema::create('room_assets', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id')->unsigned();
            $table->integer('asset_id')->unsigned();
            $table->integer('quantity');
            $table->enum('status', ['In use', 'Damaged', 'Fixing'])->default('In use');
            $table->dateTime('issue_date');
            $table->dateTime('return_date')->nullable();
            $table->string('note', 200)->nullable();

            $table->unique(['room_id', 'asset_id']);
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_assets');
    }
};

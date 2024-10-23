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
        Schema::create('PASSWORD_RESET', function (Blueprint $table) {
            $table->increments('RESET_ID');
            $table->string('RESET_EMAIL', 50);
            $table->string('RESET_TOKEN', 255);
            $table->dateTime('RESET_CREATED_AT')->default(DB::raw('CURRENT_TIMESTAMP')); // thoi gian hien tai
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset');
    }
};

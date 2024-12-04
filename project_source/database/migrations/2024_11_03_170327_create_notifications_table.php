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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sender_id')->unsigned();
            $table->morphs('object_id'); // tao 2 cot object, object_type
            $table->string('title');
            $table->enum('type', ['individual', 'group'])->default('individual');
            $table->string('content', 2000);
            $table->timestamps(true);

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

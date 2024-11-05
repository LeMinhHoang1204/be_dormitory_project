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
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('building_id')->unsigned();
            $table->integer('floor_number');
            $table->tinyInteger('type'); //check
            $table->decimal('unit_price', 10, 2);
            $table->integer('member_number')->default(0);
            $table->tinyInteger('status')->default(0)->check('status IN (0, 1)');

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

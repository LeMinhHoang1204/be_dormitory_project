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
        Schema::create('NOTIFICATION', function (Blueprint $table) {
            $table->increments('NOTI_ID');
            $table->integer('NOTI_SENDER_ACC_ID')->unsigned();
            $table->tinyInteger('NOTI_TYPE');
            $table->dateTime('NOTI_POST_DATE')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('NOTI_CONTENT', 2000);

            $table->foreign('NOTI_SENDER_ACC_ID')->references('ACC_ID')->on('ACCOUNT')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE NOTIFICATION ADD CONSTRAINT check_notification_type CHECK (NOTI_TYPE IN (1,2))');
        // 1: individual, 2: group
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};

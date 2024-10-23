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
        Schema::create('NOTIFICATION_RECIPIENT', function (Blueprint $table) {
            $table->integer('NOTI_ID')->unsigned();
            $table->integer('NOTI_RECIPIENT_ACC_ID')->unsigned();
            $table->integer('NOTI_RECIPIENT_GROUP_ID')->nullable()->unsigned();
            $table->tinyInteger('NOTI_RECIPIENT_IS_READ')->default(0);
            $table->dateTime('READ_AT')->default(DB::raw('CURRENT_TIMESTAMP'));

            // primary key
            $table->primary(['NOTI_ID', 'NOTI_RECIPIENT_ACC_ID'], 'NOTI_RECIPIENT_ID');

            // foreign key
            $table->foreign('NOTI_ID')->references('NOTI_ID')->on('NOTIFICATION')->onDelete('cascade');
            $table->foreign('NOTI_RECIPIENT_ACC_ID')->references('ACC_ID')->on('ACCOUNT')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE NOTIFICATION_RECIPIENT ADD CONSTRAINT check_notification_recipient_is_read CHECK (NOTI_RECIPIENT_IS_READ IN (0,1))');
        // 0: chua doc, 1: da doc
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_recipient');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ACCOUNT', function (Blueprint $table) {
            $table->increments('ACC_ID');
            $table->string('ACC_PASSWORD', 255);
            $table->tinyInteger('ACC_STATUS')->default(1);
            $table->tinyInteger('ACC_TYPE');
            $table->string('ACC_EMAIL', 50);
            $table->string('ACC_PHONE', 50)->nullable();
            $table->string('ACC_PROFILE_IMAGE_PATH', 255)->nullable();
            $table->string('ACC_BIO', 255)->nullable();
        });

        DB::statement('ALTER TABLE ACCOUNT ADD CONSTRAINT check_account_status CHECK (ACC_STATUS IN (0, 1))');
        // 0: KHONG CON HOAT DONG, 1: CON HOAT DONG
        DB::statement('ALTER TABLE ACCOUNT ADD CONSTRAINT check_user_type CHECK (ACC_TYPE IN (0, 1, 2, 3))');
        // 0: ADMIN, 1: BUILDING MANAGER, 2: ACCOUNTANT, 3: STUDENT

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

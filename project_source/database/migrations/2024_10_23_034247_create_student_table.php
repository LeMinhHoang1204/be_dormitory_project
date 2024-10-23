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
        Schema::create('STUDENT', function (Blueprint $table) {
            $table->increments('DORM_STU_ID');
            $table->bigInteger('STU_USER_ID')->unsigned();
            $table->integer('STU_UNI_ID');
            $table->string('STU_UNI_NAME', 255);
            $table->string('STU_NAME', 50);
            $table->dateTime('STU_DOB');
            $table->tinyInteger('STU_GENDER');
            $table->integer('STU_TRAINING_POINT')->default(100);
            $table->timestamps(false);

            $table->foreign('STU_USER_ID')->references('ID')->on('USERS')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE STUDENT ADD CONSTRAINT check_student_gender CHECK (STU_GENDER IN (0, 1))');
        // 0: nu, 1: nam
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};

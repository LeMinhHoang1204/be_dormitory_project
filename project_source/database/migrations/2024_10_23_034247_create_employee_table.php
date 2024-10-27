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
        Schema::create('EMPLOYEE', function (Blueprint $table) {
            $table->increments('EMP_ID');
            $table->integer('EMP_ACC_ID')->unsigned();
            $table->integer('EMP_MANAGER_ID')->unsigned();
            $table->bigInteger('EMP_CITIZEN_ID');
//            $table->string('EMP_NAME', 50);
            $table->dateTime('EMP_DOB');
            $table->tinyInteger('EMP_GENDER');
            $table->tinyInteger('EMP_TYPE');

            $table->foreign('EMP_ACC_ID')->references('ACC_ID')->on('ACCOUNT')->onDelete('cascade');
            $table->foreign('EMP_MANAGER_ID')->references('EMP_ID')->on('EMPLOYEE')->onDelete('cascade');

        });

        DB::statement('ALTER TABLE EMPLOYEE ADD CONSTRAINT check_employee_gender CHECK (EMP_GENDER IN (0, 1))');
        // 0: nu, 1: nam
        DB::statement('ALTER TABLE EMPLOYEE ADD CONSTRAINT check_employee_type CHECK (EMP_TYPE IN (0, 1, 2))');
        // 0: ADMIN, 1: BUILDING MANAGER, 2: ACCOUNTANT
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};

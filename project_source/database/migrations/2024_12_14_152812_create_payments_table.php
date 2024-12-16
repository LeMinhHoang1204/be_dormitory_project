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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('transaction_id');
            $table->integer('payer_id');
            $table->float('total')->nullable()->comment('total amount of money');
            $table->string('note')->nullable()->comment('note of payment');
            $table->string('vnp_response_code')->nullable()->comment('response code from vnpay');
            $table->string('code_vnpay')->nullable()->comment('code from vnpay');
            $table->string('code_bank')->nullable()->comment('code from bank');
            $table->dateTime('paid_time')->nullable()->comment('time of payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sender_id')->unsigned();
            $table->morphs('object');
            $table->dateTime('start_date')->nullable(); // dành cho hoá đơn user
            $table->dateTime('send_date');
            $table->dateTime('due_date');
            $table->dateTime('paid_date')->nullable();
            $table->enum('type', ['Electricity', 'Water', 'Fixing', 'Cleaning', 'Room Registration', 'Room Change', 'Renewal', 'Refund']);
            $table->enum('status', ['Not Paid', 'Paid', 'Overdue', 'Transferred Room', 'Refunding', 'Refunded', 'Reported'])->default('Not Paid');
            $table->decimal('total', 10, 2);
            $table->enum('payment_method', ['Cash', 'Bank Transfer'])->nullable();
            $table->text('note')->nullable();
            $table->string('evidence_image')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

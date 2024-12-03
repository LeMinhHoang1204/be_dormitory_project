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
            $table->integer('object_id')->unsigned();
            $table->dateTime('send_date');
            $table->dateTime('due_date');
            $table->dateTime('paid_date')->nullable();
            $table->enum('type', ['Room', 'Service', 'Other']);
            $table->enum('status', ['Not Paid', 'Paid', 'Overdue', 'Tranfered Roo' ])->default('Not Paid');
            $table->decimal('total', 10, 2);
            $table->enum('payment_method', ['Cash', 'Bank Transfer']);
            $table->string('note', 200)->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('object_id')->references('id')->on('rooms')->onDelete('cascade');
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

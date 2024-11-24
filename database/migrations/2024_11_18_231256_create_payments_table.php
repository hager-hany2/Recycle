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
            $table->id('payment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('OrderPoint_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('order_id')->references('order_id')->on('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('OrderPoint_id')->references('OrderPoint_id')->on('orderpoints')->cascadeOnDelete()->cascadeOnUpdate();
            $table->String('payment_method');
            $table->decimal('Amount_paid',10,2);//12346378.22
            $table->enum('status', ['pending', 'cancel', 'complete']);  // حالة الدفع
            $table->string('transaction_id')->unique();
//            $table->string('phone');
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

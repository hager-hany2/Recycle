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
        Schema::create('orderpoints', function (Blueprint $table) {
            $table->id('OrderPoint_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('ProductsPoints_id');
            $table->foreign('ProductsPoints_id')->references('id')->on('productspoints')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('address')->nullable();  // العنوان يمكن أن يكون فارغًا
            $table->string('phone')->nullable();  // الهاتف يمكن أن يكون فارغًا
            $table->enum('status', ['pending', 'cancel', 'complete']);  // حالة الطلب
            $table->decimal('total_price', 10, 2);  // السعر الإجمالي
            $table->integer('quantity');  // الكمية
            $table->string('pickup_time');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderpoints');
    }
};

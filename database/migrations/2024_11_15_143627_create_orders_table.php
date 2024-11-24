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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');  // العمود الأساسي للـ order
            $table->unsignedBigInteger('user_id');  // تأكد من أن النوع هو unsignedBigInteger
            $table->unsignedBigInteger('product_id');  // تأكد من أن النوع هو unsignedBigInteger
            $table->text('address')->nullable();  // العنوان يمكن أن يكون فارغًا
            $table->string('phone')->nullable();  // الهاتف يمكن أن يكون فارغًا
            $table->enum('status', ['pending', 'cancel', 'complete']);  // حالة الطلب
            $table->decimal('total_price', 10, 2);  // السعر الإجمالي
            $table->integer('quantity');  // الكمية
            $table->timestamps();  // تاريخ الإنشاء والتحديث
            // إضافة القيود الأجنبية بشكل يدوي
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('product_id')->references('product_id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

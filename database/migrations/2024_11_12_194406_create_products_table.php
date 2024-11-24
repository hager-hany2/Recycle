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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('category_id');
            $table->string('product_name');
            $table->string('product_description');
            $table->integer('price_product');
            $table->integer('point_product');
            $table->string('category_name');
            $table->string('image_url');
            $table->string('QuantityType');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

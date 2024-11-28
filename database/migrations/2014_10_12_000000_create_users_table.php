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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('category_user', ['restaurant', 'home', 'school']); // يملأ فقط للمستخدم العادي
            $table->string('api_token', 80)->unique()->nullable(); // حقل لتخزين API Token
            $table->integer('price')->default(0);
            $table->integer('point')->default(0);
            $table->tinyInteger('is_locked')->default(0);//tiny integer نوع البيانات بس ارقام عددية صغيربة جدا بين 0 الي 225
            $table->string('image_url')->default('images/96fe121-5dfa-43f4-98b5-db50019738a7.jpg');
            $table->enum('Gender',['female','male']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

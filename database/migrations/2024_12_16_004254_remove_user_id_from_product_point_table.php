<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('productspoints', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);

            // Drop the user_id column
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('productspoints', function (Blueprint $table) {
            // Recreate the user_id column
            $table->unsignedBigInteger('user_id');

            // Recreate the foreign key constraint
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
};

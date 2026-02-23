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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->nullable()->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('total_price')->nullable()->change();
        });

        Schema::table('order_item', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_price')->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('amount')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable()->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('total_price')->nullable()->change();
        });

        Schema::table('order_item', function (Blueprint $table) {
            $table->unsignedInteger('unit_price')->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('amount')->change();
        });
    }
};

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
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key first, then unique index (MySQL requires this order)
            $table->dropForeign(['order_id']);
            $table->dropUnique(['order_id']);

            // Re-add foreign key without the unique constraint
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();

            // Add new payment fields with backwards-compatible defaults
            $table->string('method', 32)->default('cash')->after('amount');
            $table->string('status', 32)->default('successful')->after('method');
            $table->string('reference', 191)->nullable()->after('status');
            $table->json('meta')->nullable()->after('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['method', 'status', 'reference', 'meta']);

            // Drop foreign key, re-add unique index, then restore foreign key with unique
            $table->dropForeign(['order_id']);
            $table->unique('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }
};

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
            // Remove unique constraint on order_id to allow multiple payments per order
            $table->dropUnique(['order_id']);
            
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
            
            // Re-add unique constraint on order_id
            $table->unique('order_id');
        });
    }
};

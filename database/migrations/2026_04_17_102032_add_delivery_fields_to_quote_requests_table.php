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
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('city')->nullable()->after('company');
            $table->text('address')->nullable()->after('city');
            $table->string('building')->nullable()->after('address');
            $table->string('floor')->nullable()->after('building');
            $table->string('payment_method')->default('cod')->after('message'); // cod, bank_transfer
            $table->text('delivery_notes')->nullable()->after('payment_method');
            $table->string('tracking_token', 64)->nullable()->unique()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['city', 'address', 'building', 'floor', 'payment_method', 'delivery_notes', 'tracking_token']);
        });
    }
};

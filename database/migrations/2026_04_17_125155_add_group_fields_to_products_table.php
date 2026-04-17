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
            $table->string('group_slug')->nullable()->index()->after('slug');
            $table->string('variant_label')->nullable()->after('group_slug');
            $table->integer('group_sort')->default(0)->after('variant_label');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['group_slug', 'variant_label', 'group_sort']);
        });
    }
};

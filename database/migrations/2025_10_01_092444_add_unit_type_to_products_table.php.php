<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit_type')->default('piece'); // 'piece', 'kg', 'g', etc.
            $table->decimal('unit_value', 8, 2)->nullable(); // e.g. 1 (for 1kg), 0.5 (for 500g), null for pieces
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit_type', 'unit_value']);
        });
    }
};
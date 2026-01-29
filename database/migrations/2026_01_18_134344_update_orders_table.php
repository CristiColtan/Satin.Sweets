<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('total_price');
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('transport', 10, 2)->default(0)->after('discount');
            $table->string('coupon_code', 50)->nullable()->after('transport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'discount', 'transport', 'coupon_code']);
        });
    }
};

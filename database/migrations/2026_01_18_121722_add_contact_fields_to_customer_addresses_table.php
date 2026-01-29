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
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->string('first_name', 255)->after('type');
            $table->string('last_name', 255)->after('first_name');
            $table->string('email', 255)->after('last_name');
            $table->string('phone_number', 20)->after('email');

            $table->index(['customer_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropIndex(['customer_id', 'type']);
            $table->dropColumn(['first_name', 'last_name', 'email', 'phone_number']);
        });
    }
};

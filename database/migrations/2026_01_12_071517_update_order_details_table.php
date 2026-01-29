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
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['address2', 'village', 'commune']);
            $table->renameColumn('address1', 'address');
            $table->string('city', 45)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('address2', 45);
            $table->string('village', 45);
            $table->string('commune', 45);

            $table->renameColumn('address', 'address1');

            $table->string('city', 45)->nullable()->change();
        });
    }
};

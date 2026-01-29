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
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'provider_transaction_id')) {
                $table->string('provider_transaction_id', 255)->after('type');
            }
        });

        DB::statement('ALTER TABLE payments DROP CONSTRAINT IF EXISTS payments_order_id_foreign');

        DB::statement(
            "
            ALTER TABLE payments
            ADD CONSTRAINT payments_order_id_foreign
            FOREIGN KEY (order_id)
            REFERENCES orders(id)
            ON DELETE CASCADE
        "
        );

        DB::statement('CREATE INDEX IF NOT EXISTS payments_status_idx ON payments(status)');
        DB::statement('CREATE INDEX IF NOT EXISTS payments_order_id_idx ON payments(order_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS payments_status_idx');
        DB::statement('DROP INDEX IF EXISTS payments_order_id_idx');

        DB::statement('ALTER TABLE payments DROP CONSTRAINT payments_order_id_foreign');

        DB::statement(
            "
            ALTER TABLE payments
            ADD CONSTRAINT payments_order_id_foreign
            FOREIGN KEY (order_id)
            REFERENCES orders(id)
        "
        );

        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'provider_transaction_id')) {
                $table->dropColumn('provider_transaction_id');
            }
        });
    }
};

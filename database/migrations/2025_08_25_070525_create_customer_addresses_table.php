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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('type',45);
            $table->string('address1',45);
            $table->string('address2',45);
            $table->string('village',45);
            $table->string('commune',45);
            $table->string('city',45)->nullable();
            $table->string('state',45);
            $table->string('zipcode',45);

            $table->string('country_code',3);
            $table->unsignedBigInteger('customer_id');
            $table->foreign('country_code')->references('code')->on('countries');
            $table->foreign('customer_id')->references('user_id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};

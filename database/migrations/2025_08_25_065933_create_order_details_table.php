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
        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('order_id')->primary();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('phone_number',45);
            $table->string('email',45);
            $table->string('address1',45);
            $table->string('address2',45);
            $table->string('village',45);
            $table->string('commune',45);
            $table->string('city',45)->nullable();
            $table->string('state',45);
            $table->string('zipcode',45);

            $table->string('country_code',3);
            $table->foreign('country_code')->references('code')->on('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};

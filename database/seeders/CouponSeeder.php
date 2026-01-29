<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::updateOrCreate(
            ['code' => 'WELCOME10'],
            ['type' => 'percent', 'value' => '10', 'min_subtotal' => '0', 'is_active' => true]
        );

        Coupon::updateOrCreate(
            ['code' => 'SATIN5'],
            ['type' => 'percent', 'value' => '5', 'min_subtotal' => '300', 'is_active' => true]
        );

        Coupon::updateOrCreate(
            ['code' => 'SATIN10'],
            ['type' => 'percent', 'value' => '10', 'min_subtotal' => '400', 'is_active' => true]
        );
    }
}

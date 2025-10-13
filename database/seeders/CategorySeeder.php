<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buchet = Category::create(['name' => 'Buchet']);
        $tablou = Category::create(['name' => 'Tablou']);

        Category::create(['name' => '8 Martie', 'parent_id' => $buchet->id]);
        Category::create(['name' => 'Zi de naștere', 'parent_id' => $buchet->id]);
        Category::create(['name' => 'Pentru Mama', 'parent_id' => $buchet->id]);
        Category::create(['name' => 'Pentru Bunica', 'parent_id' => $buchet->id]);
        Category::create(['name' => "Valentine's Day", 'parent_id' => $buchet->id]);

        Category::create(['name' => 'Cartoon', 'parent_id' => $tablou->id]);
    }
}

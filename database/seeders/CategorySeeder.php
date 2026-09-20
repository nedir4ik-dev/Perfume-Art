<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Luxury Perfumes',
            'Exclusive Collection',
            'Limited Edition',
            'Oriental Scents',
            'Fresh & Floral'
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat],
                ['slug' => str_replace(' ', '-', strtolower($cat))]
            );
        }
    }
}

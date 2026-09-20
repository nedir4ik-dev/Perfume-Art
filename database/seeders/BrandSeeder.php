<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::updateOrCreate(
            ['slug' => 'designer-collection'],
            [
                'name' => 'Designer Collection',
                'name_tm' => 'Dizaýner Kolleksiýasy',
                'name_ru' => 'Дизайнерская Коллекция',
                'is_active' => true
            ]
        );
    }
}

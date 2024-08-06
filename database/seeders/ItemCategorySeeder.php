<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'uuid' => '247b6ad6-4f25-11ef-988f-9a039bff5563',
                'name' => 'Makanan'
            ],
            [
                'uuid' => '43c44908-4f25-11ef-afa5-9a039bff5563',
                'name' => 'Minuman'
            ],
            [
                'uuid' => '480e5e2c-4f25-11ef-be99-9a039bff5563',
                'name' => 'Souvenir'
            ]
        ];

        foreach ($categories as $category) {
            ItemCategory::insert([
                [
                    'uuid' => $category['uuid'],
                    'name' => $category['name'],
                    'code' => '',
                    'description' => ''
                ]
            ]);
        }
    }
}

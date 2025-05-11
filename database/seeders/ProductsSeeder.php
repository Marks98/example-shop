<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Oříšky',
                'price' => 10,
                'stock' => 25
            ],
            [
                'name' => 'Sušenky',
                'price' => 15,
                'stock' => 150
            ],
            [
                'name' => 'Banány',
                'price' => 35,
                'stock' => 55
            ],
            [
                'name' => 'Melouny',
                'price' => 54,
                'stock' => 68
            ],
            [
                'name' => 'Jahody',
                'price' => 32,
                'stock' => 11
            ]
        ];

        foreach ($products as $product) {
            Product::create(array_merge(
                ['state' => 'published'],
                $product
            ));
        }
    }
}

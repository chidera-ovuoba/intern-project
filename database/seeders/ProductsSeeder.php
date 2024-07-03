<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Product 1', 'price' => 100.00, 'stock' => 100],
            ['name' => 'Product 2', 'price' => 2300.00, 'stock' => 20],
            ['name' => 'Product 3', 'price' => 330.00, 'stock' => 40],
            ['name' => 'Product 4', 'price' => 20.00, 'stock' => 50],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

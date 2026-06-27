<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sembako', 'description' => 'Beras, Minyak, Gula, dll'],
            ['name' => 'Minuman', 'description' => 'Air Mineral, Teh, Kopi'],
            ['name' => 'Makanan Ringan', 'description' => 'Snack, Biskuit, Keripik'],
            ['name' => 'Keperluan Mandi', 'description' => 'Sabun, Sampo, Pasta Gigi'],
            ['name' => 'Makanan Instan', 'description' => 'Mie Instan, Bubur, Sarden'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        $products = [
            // Sembako
            ['category_id' => 1, 'name' => 'Beras Premium 5kg', 'stock' => 50, 'buy_price' => 65000, 'sell_price' => 70000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Beras+5kg'],
            ['category_id' => 1, 'name' => 'Minyak Goreng 2L', 'stock' => 30, 'buy_price' => 32000, 'sell_price' => 35000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Minyak+2L'],
            ['category_id' => 1, 'name' => 'Gula Pasir 1kg', 'stock' => 40, 'buy_price' => 15000, 'sell_price' => 17000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Gula+1kg'],
            // Minuman
            ['category_id' => 2, 'name' => 'Air Mineral 600ml', 'stock' => 100, 'buy_price' => 2000, 'sell_price' => 3000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Air+Mineral'],
            ['category_id' => 2, 'name' => 'Teh Manis Botol 350ml', 'stock' => 60, 'buy_price' => 3000, 'sell_price' => 4000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Teh+Botol'],
            // Makanan Ringan
            ['category_id' => 3, 'name' => 'Keripik Kentang 68g', 'stock' => 45, 'buy_price' => 8500, 'sell_price' => 10000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Keripik'],
            ['category_id' => 3, 'name' => 'Biskuit Cokelat', 'stock' => 35, 'buy_price' => 6000, 'sell_price' => 7500, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Biskuit'],
            // Keperluan Mandi
            ['category_id' => 4, 'name' => 'Sabun Mandi Cair 450ml', 'stock' => 25, 'buy_price' => 22000, 'sell_price' => 25000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Sabun+Cair'],
            ['category_id' => 4, 'name' => 'Sampo Anti Ketombe 130ml', 'stock' => 20, 'buy_price' => 18000, 'sell_price' => 22000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Sampo'],
            // Makanan Instan
            ['category_id' => 5, 'name' => 'Mie Goreng Spesial', 'stock' => 200, 'buy_price' => 2500, 'sell_price' => 3000, 'image' => 'https://placehold.co/400x400/0d6efd/white?text=Mie+Goreng'],
        ];

        foreach ($products as $prod) {
            \App\Models\Product::create($prod);
        }
    }
}

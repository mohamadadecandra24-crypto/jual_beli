<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat1 = \App\Models\Category::firstOrCreate(['name' => 'Elektronik']);
        $cat2 = \App\Models\Category::firstOrCreate(['name' => 'Pakaian']);
        $cat3 = \App\Models\Category::firstOrCreate(['name' => 'Makanan']);

        $products = [
            [
                'category_id' => $cat1->id,
                'name' => 'Laptop Asus ROG',
                'stock' => 15,
                'buy_price' => 15000000,
                'sell_price' => 16500000,
                // placeholder image url since we don't have files
                'image' => null
            ],
            [
                'category_id' => $cat1->id,
                'name' => 'Mouse Wireless Logitech',
                'stock' => 50,
                'buy_price' => 150000,
                'sell_price' => 200000,
                'image' => null
            ],
            [
                'category_id' => $cat1->id,
                'name' => 'Keyboard Mechanical Keychron',
                'stock' => 20,
                'buy_price' => 1200000,
                'sell_price' => 1500000,
                'image' => null
            ],
            [
                'category_id' => $cat1->id,
                'name' => 'Monitor Samsung 24 Inch',
                'stock' => 12,
                'buy_price' => 1800000,
                'sell_price' => 2100000,
                'image' => null
            ],
            [
                'category_id' => $cat2->id,
                'name' => 'Kaos Polos Cotton Combed',
                'stock' => 100,
                'buy_price' => 30000,
                'sell_price' => 50000,
                'image' => null
            ],
            [
                'category_id' => $cat2->id,
                'name' => 'Kemeja Flanel Kotak',
                'stock' => 45,
                'buy_price' => 85000,
                'sell_price' => 135000,
                'image' => null
            ],
            [
                'category_id' => $cat2->id,
                'name' => 'Celana Jeans Denim',
                'stock' => 60,
                'buy_price' => 120000,
                'sell_price' => 200000,
                'image' => null
            ],
            [
                'category_id' => $cat2->id,
                'name' => 'Jaket Hoodie Hitam',
                'stock' => 30,
                'buy_price' => 110000,
                'sell_price' => 175000,
                'image' => null
            ],
            [
                'category_id' => $cat3->id,
                'name' => 'Keripik Kentang Balado',
                'stock' => 200,
                'buy_price' => 10000,
                'sell_price' => 15000,
                'image' => null
            ],
            [
                'category_id' => $cat3->id,
                'name' => 'Kopi Arabica 200g',
                'stock' => 80,
                'buy_price' => 45000,
                'sell_price' => 65000,
                'image' => null
            ],
        ];

        // We download placeholder images locally so they appear via Storage::url
        foreach ($products as $p) {
            $filename = 'products/placeholder_' . md5($p['name']) . '.jpg';
            if (!\Storage::disk('public')->exists($filename)) {
                // To avoid hanging or timeout in seeder, we will just use a tiny base64 decoded image for demo
                // Or just an empty file since we're just testing the view
                $imgData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nCJ8xAAAAAAElFTkSuQmCC'); 
                \Storage::disk('public')->put($filename, $imgData);
            }
            $p['image'] = $filename;
            
            \App\Models\Product::create($p);
        }
    }
}

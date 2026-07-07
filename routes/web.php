<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('transactions.create');
});

Route::resource('categories', CategoryController::class);
Route::post('products/{product}/restock', [ProductController::class, 'restock'])->name('products.restock');
Route::resource('products', ProductController::class);
Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('expenses', ExpenseController::class);

Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit_loss');
Route::post('/reports/login', [ReportController::class, 'login'])->name('reports.login');
Route::post('/reports/logout', [ReportController::class, 'logout'])->name('reports.logout');


Route::get('/migrate', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return "Migrasi Berhasil!";
});

Route::get('/seed', function() {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return "Seeding Minimarket Berhasil!";
});

Route::get('/seed-sembako', function() {
    $category = \App\Models\Category::firstOrCreate(['name' => 'Sembako']);
    $products = [
        ['name' => 'Beras Pandan Wangi 5kg', 'stock' => 20, 'buy_price' => 70000, 'sell_price' => 75000],
        ['name' => 'Beras Rojolele 10kg', 'stock' => 15, 'buy_price' => 130000, 'sell_price' => 140000],
        ['name' => 'Minyak Goreng Bimoli 2L', 'stock' => 50, 'buy_price' => 33000, 'sell_price' => 36000],
        ['name' => 'Minyak Goreng Filma 1L', 'stock' => 40, 'buy_price' => 16500, 'sell_price' => 18000],
        ['name' => 'Gula Pasir Gulaku 1kg', 'stock' => 60, 'buy_price' => 15000, 'sell_price' => 16500],
        ['name' => 'Telur Ayam Negeri 1kg', 'stock' => 30, 'buy_price' => 25000, 'sell_price' => 28000],
        ['name' => 'Tepung Terigu Segitiga Biru 1kg', 'stock' => 25, 'buy_price' => 10500, 'sell_price' => 12000],
        ['name' => 'Garam Dapur Halus 500g', 'stock' => 100, 'buy_price' => 2000, 'sell_price' => 3000],
        ['name' => 'Kecap Manis Bango 520ml', 'stock' => 35, 'buy_price' => 20000, 'sell_price' => 22000],
        ['name' => 'Saus Sambal Indofood 340ml', 'stock' => 45, 'buy_price' => 13500, 'sell_price' => 15000],
    ];

    foreach ($products as $p) {
        \App\Models\Product::firstOrCreate(
            ['name' => $p['name']],
            [
                'category_id' => $category->id,
                'stock' => $p['stock'],
                'buy_price' => $p['buy_price'],
                'sell_price' => $p['sell_price'],
                'image' => 'https://placehold.co/400x400/0d6efd/white?text='.urlencode($p['name'])
            ]
        );
    }
    return "10 Produk Sembako berhasil ditambahkan! Silakan kembali ke web Anda.";
});

// Fallback route: jika user mengetik URL yang salah (atau via localhost/folder/public), arahkan ke halaman utama
Route::fallback(function () {
    return redirect()->route('transactions.create');
});
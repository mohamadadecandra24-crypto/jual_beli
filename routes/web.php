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
    // Hapus kategori 'Sembako' lama beserta produknya jika ada
    $oldCategory = \App\Models\Category::where('name', 'Sembako')->first();
    if ($oldCategory) {
        \App\Models\Product::where('category_id', $oldCategory->id)->delete();
        $oldCategory->delete();
    }

    $catBahanPokok = \App\Models\Category::firstOrCreate(['name' => 'Bahan Pokok Dasar']);
    $catBumbu = \App\Models\Category::firstOrCreate(['name' => 'Bumbu & Saus']);
    
    $products = [
        ['cat' => $catBahanPokok->id, 'name' => 'Beras Pandan Wangi 5kg', 'stock' => 20, 'buy_price' => 70000, 'sell_price' => 75000, 'img' => 'https://images.unsplash.com/photo-1586201375761-83865001e8ac?w=400&q=80'],
        ['cat' => $catBahanPokok->id, 'name' => 'Beras Rojolele 10kg', 'stock' => 15, 'buy_price' => 130000, 'sell_price' => 140000, 'img' => 'https://images.unsplash.com/photo-1593922570081-37eb8da5cfa1?w=400&q=80'],
        ['cat' => $catBahanPokok->id, 'name' => 'Minyak Goreng Bimoli 2L', 'stock' => 50, 'buy_price' => 33000, 'sell_price' => 36000, 'img' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&q=80'],
        ['cat' => $catBahanPokok->id, 'name' => 'Minyak Goreng Filma 1L', 'stock' => 40, 'buy_price' => 16500, 'sell_price' => 18000, 'img' => 'https://images.unsplash.com/photo-1620706857370-e1b9770e8bb1?w=400&q=80'],
        ['cat' => $catBumbu->id, 'name' => 'Gula Pasir Gulaku 1kg', 'stock' => 60, 'buy_price' => 15000, 'sell_price' => 16500, 'img' => 'https://images.unsplash.com/photo-1581428982868-e410dd1fc0aa?w=400&q=80'],
        ['cat' => $catBahanPokok->id, 'name' => 'Telur Ayam Negeri 1kg', 'stock' => 30, 'buy_price' => 25000, 'sell_price' => 28000, 'img' => 'https://images.unsplash.com/photo-1587486913049-53fc88980cfc?w=400&q=80'],
        ['cat' => $catBahanPokok->id, 'name' => 'Tepung Terigu Segitiga Biru 1kg', 'stock' => 25, 'buy_price' => 10500, 'sell_price' => 12000, 'img' => 'https://images.unsplash.com/photo-1627485937980-221c88ac04f9?w=400&q=80'],
        ['cat' => $catBumbu->id, 'name' => 'Garam Dapur Halus 500g', 'stock' => 100, 'buy_price' => 2000, 'sell_price' => 3000, 'img' => 'https://images.unsplash.com/photo-1621235129633-855e4cb185b3?w=400&q=80'],
        ['cat' => $catBumbu->id, 'name' => 'Kecap Manis Bango 520ml', 'stock' => 35, 'buy_price' => 20000, 'sell_price' => 22000, 'img' => 'https://images.unsplash.com/photo-1615485925600-97237c4fc1ec?w=400&q=80'],
        ['cat' => $catBumbu->id, 'name' => 'Saus Sambal Indofood 340ml', 'stock' => 45, 'buy_price' => 13500, 'sell_price' => 15000, 'img' => 'https://images.unsplash.com/photo-1585122501062-84196b010be5?w=400&q=80'],
    ];

    foreach ($products as $p) {
        \App\Models\Product::updateOrCreate(
            ['name' => $p['name']],
            [
                'category_id' => $p['cat'],
                'stock' => $p['stock'],
                'buy_price' => $p['buy_price'],
                'sell_price' => $p['sell_price'],
                'image' => $p['img']
            ]
        );
    }
    return "Data Produk berhasil diperbaiki dengan Kategori dan Gambar yang lebih bagus! Silakan kembali ke web Anda.";
});

// Fallback route: jika user mengetik URL yang salah (atau via localhost/folder/public), arahkan ke halaman utama
Route::fallback(function () {
    return redirect()->route('transactions.create');
});
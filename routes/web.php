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
        ['cat' => $catBahanPokok->id, 'name' => 'Beras Pandan Wangi 5kg', 'stock' => 20, 'buy_price' => 70000, 'sell_price' => 75000, 'img' => 'https://cdn-icons-png.flaticon.com/512/6889/6889988.png'],
        ['cat' => $catBahanPokok->id, 'name' => 'Beras Rojolele 10kg', 'stock' => 15, 'buy_price' => 130000, 'sell_price' => 140000, 'img' => 'https://cdn-icons-png.flaticon.com/512/3014/3014522.png'],
        ['cat' => $catBahanPokok->id, 'name' => 'Minyak Goreng Bimoli 2L', 'stock' => 50, 'buy_price' => 33000, 'sell_price' => 36000, 'img' => 'https://cdn-icons-png.flaticon.com/512/1000/1000085.png'],
        ['cat' => $catBahanPokok->id, 'name' => 'Minyak Goreng Filma 1L', 'stock' => 40, 'buy_price' => 16500, 'sell_price' => 18000, 'img' => 'https://cdn-icons-png.flaticon.com/512/5753/5753965.png'],
        ['cat' => $catBumbu->id, 'name' => 'Gula Pasir Gulaku 1kg', 'stock' => 60, 'buy_price' => 15000, 'sell_price' => 16500, 'img' => 'https://cdn-icons-png.flaticon.com/512/3081/3081977.png'],
        ['cat' => $catBahanPokok->id, 'name' => 'Telur Ayam Negeri 1kg', 'stock' => 30, 'buy_price' => 25000, 'sell_price' => 28000, 'img' => 'https://cdn-icons-png.flaticon.com/512/837/837560.png'],
        ['cat' => $catBahanPokok->id, 'name' => 'Tepung Terigu Segitiga Biru 1kg', 'stock' => 25, 'buy_price' => 10500, 'sell_price' => 12000, 'img' => 'https://cdn-icons-png.flaticon.com/512/2927/2927341.png'],
        ['cat' => $catBumbu->id, 'name' => 'Garam Dapur Halus 500g', 'stock' => 100, 'buy_price' => 2000, 'sell_price' => 3000, 'img' => 'https://cdn-icons-png.flaticon.com/512/3944/3944111.png'],
        ['cat' => $catBumbu->id, 'name' => 'Kecap Manis Bango 520ml', 'stock' => 35, 'buy_price' => 20000, 'sell_price' => 22000, 'img' => 'https://cdn-icons-png.flaticon.com/512/3014/3014498.png'],
        ['cat' => $catBumbu->id, 'name' => 'Saus Sambal Indofood 340ml', 'stock' => 45, 'buy_price' => 13500, 'sell_price' => 15000, 'img' => 'https://cdn-icons-png.flaticon.com/512/8173/8173752.png'],
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
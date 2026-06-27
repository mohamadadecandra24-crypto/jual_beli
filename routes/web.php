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

Route::get('/migrate', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return "Migrasi Berhasil!";
});

Route::get('/seed', function() {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return "Seeding Minimarket Berhasil!";
});

// Fallback route: jika user mengetik URL yang salah (atau via localhost/folder/public), arahkan ke halaman utama
Route::fallback(function () {
    return redirect()->route('transactions.create');
});
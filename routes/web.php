<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');
    Route::get('products/stock-report/download', [ProductController::class, 'downloadStockReport'])->name('products.stock-report');
    Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');
    Route::resource('clients', ClientController::class);
    Route::get('invoices/{invoice}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';


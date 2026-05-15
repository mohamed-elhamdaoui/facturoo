<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('invoices/{invoice}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';

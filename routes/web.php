<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');
    Route::resource('clients', ClientController::class);
    Route::get('invoices/{invoice}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';

// Safe, secure fallback route to serve uploaded storage files in case of broken symlinks or container mount issues
Route::get('product-images/{path}', function ($path) {
    // Prevent path traversal
    $path = str_replace(['../', '..\\'], '', $path);
    
    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    
    if (!$disk->exists($path)) {
        abort(404);
    }
    
    $file = $disk->get($path);
    $type = $disk->mimeType($path);
    
    return \Illuminate\Support\Facades\Response::make($file, 200, [
        'Content-Type' => $type,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

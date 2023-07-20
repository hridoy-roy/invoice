<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//    Product CRUD
    Route::prefix('products')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->name('products.index');
        Route::get('create', [ProductController::class, 'create'])->name('products.create');
        Route::post('store', [ProductController::class, 'store'])->name('products.store');
        Route::get('edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('update/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::get('destroy/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

//    Invoice
    Route::prefix('invoice')->group(function (){
        Route::get('index',[InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('create',[InvoiceController::class, 'create'])->name('invoice.create');
        Route::get('product/{product}',[InvoiceController::class, 'getProduct'])->name('invoice.product');
        Route::post('store',[InvoiceController::class, 'store'])->name('invoice.store');
        Route::get('print/{invoice}',[InvoiceController::class, 'printInvoice'])->name('invoice.print');
    });

});

require __DIR__ . '/auth.php';

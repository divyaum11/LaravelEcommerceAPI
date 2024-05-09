<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'getAllProducts'])->name('home');
Route::get('/view-product/{id}', [ProductController::class, 'viewProducts']);
Route::get('/add-products-view', [ProductController::class, 'addProductsView'])->name('add-products-view');
Route::post('/add-products', [ProductController::class, 'addProducts']);
Route::get('/get-products', [ProductController::class, 'getProducts']);
Route::post('/add-to-cart', [ProductController::class, 'addToCart']);
Route::get('/get-cart', [ProductController::class, 'getCart']);
Route::get('/cart', [ProductController::class, 'cartData'])->name('cart');

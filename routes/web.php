<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home-haak-hart');
});


Route::inertia('/home-producten', 'components/magazijn/HomeProducten/HomeProducten')->name('home-producten');
Route::inertia('/mijn-reserveringen', 'components/magazijn/MijnReserveringen/MijnReserveringen')->name('mijn-reserveringen');

Route::inertia('/home-haak-hart', 'components/haak-hart/HomeHaakHart/HomeHaakHart')->name('home-haak-hart');
Route::inertia('/producten-haak-hart', 'components/haak-hart/ProductenHaakHart/ProductenHaakHart')->name('producten-haak-hart');
Route::inertia('/donatie-haak-hart', 'components/haak-hart/DonatieHaakHart/DonatieHaakHart')->name('donatie-haak-hart');
Route::inertia('/contact-haak-hart', 'components/haak-hart/ContactHaakHart/ContactHaakHart')->name('contact-haak-hart');

Route::inertia('/admin-producten-beheer', 'components/magazijn/AdminProductenBeheer/AdminProductenBeheer')->name('admin-producten-beheer');
Route::inertia('/admin-reserveringen', 'components/magazijn/AdminReserveringen/AdminReserveringen')->name('admin-reserveringen');


Route::get('/api/items', [ProductController::class, 'index']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/api/my-reservations', [BorrowingController::class, 'userReservations']);
    Route::post('/borrowings', [BorrowingController::class, 'store']);
    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnItem']);
});


Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/api/admin/reservations', [BorrowingController::class, 'index']);
    Route::delete('/api/admin/reservations/{id}', [BorrowingController::class, 'destroy']);

    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update.post');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__ . '/settings.php';

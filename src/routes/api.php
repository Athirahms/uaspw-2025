<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookkingMenuController;

use Illuminate\Support\Facades\Route;

// Bookings
Route::prefix('Bookings')->middleware('apikey')->group(function () {
    Route::get('/', [BookingController::class, 'index']);     // GET /api/Bookings
    Route::get('{id}', [BookingController::class, 'show']);   // GET /api/Bookings/{id}
    Route::post('/', [BookingController::class, 'store']);    // POST /api/Bookings
    Route::put('{id}', [BookingController::class, 'update']); // PUT /api/Bookings/{id}
    Route::delete('{id}', [BookingController::class, 'destroy']); // DELETE /api/Bookings/{id}
});

// Menus
Route::prefix('Menus')->middleware('apikey')->group(function () {
    Route::get('/', [MenuController::class, 'index']);     // GET /api/Menus
    Route::post('/decrypt', [MenuController::class, 'decryptResponse']);
    Route::get('{id}', [MenuController::class, 'show']);   // GET /api/Menus/{id}
    Route::post('/', [MenuController::class, 'store']);    // POST /api/Menus
    Route::put('{id}', [MenuController::class, 'update']); // PUT /api/Menus/{id}
    Route::delete('{id}', [MenuController::class, 'destroy']); // DELETE /api/Menus/{id}
});

Route::prefix('BookkingMenus')->middleware('apikey')->group(function () {
    Route::get('/', [BookkingMenuController::class, 'index']);     // GET /api/BookkingMenus
    Route::get('{id}', [BookkingMenuController::class, 'show']);   // GET /api/BookkingMenus/{id}
    Route::post('/', [BookkingMenuController::class, 'store']);    // POST /api/BookkingMenus
    Route::put('{id}', [BookkingMenuController::class, 'update']); // PUT /api/BookkingMenus/{id}
    Route::delete('{id}', [BookkingMenuController::class, 'destroy']); // DELETE /api/BookkingMenus/{id}
});
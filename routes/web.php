<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LoginController;

//Route::get('/', function () {
  //  return view('login_staff');
//});
//Route::post('/login_staff', [LoginController::class, 'login'])->name('login_staff');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/stores', [StoreController::class, 'index'])->name('stores.store');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/films/create', [FilmController::class, 'create'])->name('film.create');
Route::post('/films', [FilmController::class, 'store'])->name('film.store');


Route::get('/films', [FilmController::class, 'index'])->name('films');

Route::get('/details', [FilmController::class, 'details'])->name('films.details');

Route::get('/films/{filmId}/edit', [FilmController::class, 'edit'])->name('film.edit');
Route::delete('/films/{filmId}', [FilmController::class, 'destroy'])->name('film.destroy');
Route::put('/films/{filmId}', [FilmController::class, 'update'])->name('film.update');


Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');

Route::get('/search-customers', [RentalController::class, 'searchCustomers'])->name('customers.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VaultController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(VaultController::class)->name('vault.')->group(function() {

    // Show all vaults
    Route::get('/vaults', 'showAll')->name('all');

    // Vault creation routes
    Route::get('/vault/create', 'create')->name('create');
    Route::post('/vault/create', 'store')->name('store');


    
});
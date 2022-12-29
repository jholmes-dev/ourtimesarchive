<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VaultController;
use App\Http\Controllers\InviteController;

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

/**
 * Vault related routes
 * 
 */
Route::controller(VaultController::class)->name('vault.')->group(function() {

    // Show all vaults
    Route::get('/vaults', 'showAll')->name('all');

    // Vault creation routes
    Route::get('/vault/create', 'create')->name('create');
    Route::post('/vault/create', 'store')->name('store');


    
});

/**
 * Invite related routes
 * 
 */
Route::controller(InviteController::class)->name('invite.')->group(function() {

    Route::get('invites', 'viewAll')->name('all');
    Route::post('invite/{id}', 'respond')->name('respond');

});

/**
 * Guest view for invites
 * 
 */
Route::get('invite/{id}', function($id) {
    return response()
        ->view('invite.view-guest', ['invite' => App\Models\Invite::findOrFail($id)])
        ->cookie('fromInvite', $id, 600);
})->name('invite.view.guest');

Route::get('/emailtest', function() {
    $invite = App\Models\Invite::all();
    return new App\Mail\UserInvite($invite[0]);
});
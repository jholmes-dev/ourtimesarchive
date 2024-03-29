<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VaultController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnlockController;
use App\Http\Controllers\AssetController;

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
 * User management routes
 * 
 */
Route::controller(UserController::class)->name('user.')->group(function() {

    // My Account page
    Route::get('/account', 'viewAccount')->name('account');

    // Change password request
    Route::post('/account/password/change', 'changePassword')->name('password.change');

    // Accont deletion
    Route::post('/account/delete', 'deleteAccount')->name('delete');

    // Name update
    Route::post('/account/update/name', 'updateName')->name('update.name');

});

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

    // View a single vault
    Route::get('/vault/{id}/view', 'view')->name('view');

    // Vault photo actions
    Route::get('/vault/{id}/photo', 'getPhoto')->name('photo.get');
    Route::post('/vault/{id}/photo', 'updatePhoto')->name('photo.update');

    // Leave a vault
    Route::post('/vault/{id}/leave', 'leave')->name('leave');

    // Generate a local vault unlock
    Route::post('/vault/{id}/unlock/local', 'generateLocalUnlock')->name('unlock.local');

});

/**
 * Unlock related routes
 * 
 */
Route::controller(UnlockController::class)->name('unlock.')->group(function() {

    // Local unlock. Routes the request to the proper method
    Route::get('/vault/{vid}/unlock/{uid}/', 'routeUnlock')->name('route');

});

/**
 * Asset related routes
 * 
 */
Route::controller(AssetController::class)->name('asset.')->group(function() {

    // Local unlock. Routes the request to the proper method
    Route::get('/asset/{id}', 'view')->name('view');

});

/**
 * Invite related routes
 * 
 */
Route::controller(InviteController::class)->name('invite.')->group(function() {

    // All invites
    Route::get('/invites', 'viewAll')->name('all');

    // Invite responses
    Route::post('/invite/{id}/accept', 'accept')->name('accept');
    Route::post('/invite/{id}/reject', 'reject')->name('reject');

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

/**
 * Entry related routes
 * 
 */
Route::controller(EntryController::class)->name('entry.')->group(function() {

    // New entry routes
    Route::get('/entry/new', 'create')->name('create');
    Route::get('/vault/{id}/entry/new', 'create')->name('create.for');
    Route::post('/entry/new', 'store')->name('store');

});

Route::get('/emailtest', function() {
    $invite = App\Models\Invite::all();
    return new App\Mail\UserInvite($invite[0]);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UnlockAuthorizationController;
use App\Http\Controllers\api\UnlockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Unlock related routes
 * 
 */
Route::middleware('auth:sanctum')->controller(UnlockAuthorizationController::class)->name('api.uauth.')->group(function() {

    // Local unlock. Routes the request to the proper method
    Route::post('/uauth/verify', 'verifyAuthorization')->name('verify');

});

/**
 * Unlock related routes
 * 
 */
Route::middleware('auth:sanctum')->controller(UnlockController::class)->name('api.unlock.')->group(function() {

    // Get an unlock's entries
    Route::get('/unlock/{unlock_id}/entries', 'getUnlockEntries')->name('entries.get');

});


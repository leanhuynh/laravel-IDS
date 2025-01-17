<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserControllerAPI;

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

Route::prefix('/users')->group(function() {
    Route::get('/search', [UserControllerAPI::class, 'searchByKeyword'])->name('users.search');
    Route::post('/', [UserControllerAPI::class, 'store'])->name('users.store');
    Route::put('/{user}', [UserControllerAPI::class, 'update'])->name('users.update');
    Route::delete('/delete', [UserControllerAPI::class, 'destroy'])->name('users.destroy');
});

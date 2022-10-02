<?php

use App\Http\Controllers\API\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('/lists', ListController::class);
// Route::get('/lists', [ListController::class, 'index'])->name('lists.index');
// Route::post('/lists', [ListController::class, 'store'])->name('lists.store');
// Route::get('/lists/{id}', [ListController::class, 'show'])->name('lists.show');
// Route::put('/lists/{id}', [ListController::class, 'update'])->name('lists.show');
// Route::delete('/lists/{id}', [ListController::class, 'destroy'])->name('lists.show');

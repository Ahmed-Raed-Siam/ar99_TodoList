<?php

use App\Http\Controllers\ItemController;
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

//Route::resource('items', ItemController::class);

Route::group([
    'as' => 'api.web.',
//    'prefix' => '',
    'middleware' => ['guest:sanctum'],
], function () {
    Route::get('items', [ItemController::class, 'index'])->name('items');
    Route::post('item', [ItemController::class, 'store'])->name('item.store');
    Route::put('item/{id}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('item/{id}', [ItemController::class, 'destroy'])->name('item.delete');
});

//Route::controller(ItemController::class)->group(function () {
//    Route::post('/orders', 'store');
//});

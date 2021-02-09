<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Tag\TagController;
use App\Http\Controllers\API\Review\ReviewController;
use App\Http\Controllers\API\Business\BusinessController;
use App\Http\Controllers\API\Authorization\LoginController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',                            [LoginController::class, 'store']);
Route::post('update_name',                       [UserController::class, 'update']);

Route::get('tags',                              [TagController::class, 'index'])->name('tags');

Route::get('businesses',                        [BusinessController::class, 'index']);
// Route::get('/businesses/with_login',            [BusinessController::class, 'with_login'])->name('businesses.with_login')->middleware('auth:sanctum');
Route::get('businesses/my_list',                [BusinessController::class, 'my_list'])->middleware('auth:sanctum');

// Route::get('business/{business}',              [BusinessController::class, 'show'])->name('business.show')->middleware('auth:sanctum');

Route::get('reviews',                           [ReviewController::class, 'index'])->name('reviews');
Route::post('business/review',                  [ReviewController::class, 'store'])->middleware('auth:sanctum');


Route::post('business/{business}/call_count',   [BusinessController::class, 'call_count'])->middleware('auth:sanctum');
Route::post('business/{business}/share_count',  [BusinessController::class, 'share_count'])->middleware('auth:sanctum');


// Route::post('business/{business}/feedback',     [BusinessController::class, 'feedback'])->name('business.feedback')->middleware('auth:sanctum');
Route::post('business/{business}/add_to_my_list',         [BusinessController::class, 'add_to_my_list'])->middleware('auth:sanctum');

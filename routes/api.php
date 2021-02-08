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

Route::get('/tags',                             [TagController::class, 'index'])->name('tags');

Route::get('/businesses/without_login',         [BusinessController::class, 'without_login'])->name('businesses.without_login');
Route::get('/businesses/with_login',            [BusinessController::class, 'with_login'])->name('businesses.with_login')->middleware('auth:sanctum');

Route::get('/business/{business}',              [BusinessController::class, 'show'])->name('business.show')->middleware('auth:sanctum');

Route::get('/reviews',                          [ReviewController::class, 'index'])->name('reviews');
Route::post('/business/review',                 [BusinessController::class, 'store'])->name('business.store')->middleware('auth:sanctum');

Route::post('business/{business}/call_count',   [BusinessController::class, 'call_count'])->name('business.call_count')->middleware('auth:sanctum');
Route::post('business/{business}/share_count',  [BusinessController::class, 'share_count'])->name('business.share_count')->middleware('auth:sanctum');
Route::post('business/{business}/feedback',     [BusinessController::class, 'feedback'])->name('business.feedback')->middleware('auth:sanctum');
Route::post('business/{business}/review',       [BusinessController::class, 'review'])->name('business.review')->middleware('auth:sanctum');


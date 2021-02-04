<?php

use App\Http\Livewire\Admin\Business\BusinessCreateComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Tag\TagComponent;
use App\Http\Livewire\Admin\Business\BusinessIndexComponent;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home',                             [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tag',                              TagComponent::class)->name('tag');
Route::get('/business',                         BusinessIndexComponent::class)->name('business');
Route::get('/business/create',                  BusinessCreateComponent::class)->name('business.create');
Route::get('/business/{business}/edit',         BusinessCreateComponent::class)->name('business.edit');



<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Messenger;
use App\Http\Livewire\MessengerChat;
use App\Http\Livewire\ProductProfil;
use App\Http\Livewire\UserProfil;
use App\Http\Livewire\ShowProducts;
use App\Http\Livewire\RegisteringNewUser;

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

Route::get('/', Home::class)->name('home');
Route::get('/articles', ShowProducts::class)->name('products');
Route::get('/articles/{id?}', ProductProfil::class)->name('product-profil');
Route::post('/inscription', RegisteringNewUser::class)->middleware('guest')->name('inscription');

Route::get('/administration', Admin::class)->middleware('auth')->name('admin');
Route::get('/messenger', Messenger::class)->middleware('auth')->name('messenger');
Route::get('/messenger/chat/{id?}', MessengerChat::class)->middleware('auth')->name('chat');
Route::get('profil/{id}', UserProfil::class)->middleware('auth')->name('user-profil');



Route::get('/about', function () {
    return view('layouts/app');
})->name('about');
Route::get('/contact', function () {
    return view('layouts/app');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

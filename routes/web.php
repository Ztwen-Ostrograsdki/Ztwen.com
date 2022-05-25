<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Messenger;
use App\Http\Livewire\UserProfil;
use App\Http\Livewire\ShowProducts;
use App\Http\Livewire\MessengerChat;
use App\Http\Livewire\ProductProfil;
use App\Http\Livewire\ShowCategories;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\AuthRedirections;
use App\Http\Livewire\RegisteringNewUser;
use App\Http\Livewire\EmailVerifyNotification;
use App\Http\Livewire\ConfirmedEmailVerification;
use App\Http\Livewire\ForceEmailVerifyNotification;
use App\Http\Controllers\Auth\VerifyEmailController;

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
Route::get('/connexion', AuthRedirections::class)->name('login')->middleware('guest');
Route::get('/inscription', AuthRedirections::class)->name('registration')->middleware('guest');


Route::get('/articles', ShowProducts::class)->name('products');
Route::get('/categories', ShowCategories::class)->name('categories');
Route::get('/categories/{id?}', ShowCategories::class)->name('category');
Route::get('/articles/{id?}', ProductProfil::class)->name('product-profil');
Route::post('/inscription', RegisteringNewUser::class)->middleware('guest')->name('inscription');

Route::get('/administration', Admin::class)->middleware(['admin', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('admin');
Route::get('/messenger', Messenger::class)->middleware(['auth', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('messenger');
Route::get('/messenger/chat/{id?}', MessengerChat::class)->middleware(['auth', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('chat');
Route::get('profil/{id}', UserProfil::class)->middleware(['user', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('user-profil');
Route::prefix('verification')->group(function(){
    Route::get('/email/{id}', EmailVerifyNotification::class)->name('email-verification-notify')->middleware('guest');
    Route::get('/email/confirmation/id={id}/evtok={token}/k={key}/hash={hash}/r=accepted/confirmed=true', ConfirmedEmailVerification::class)->name('confirmed-email-verification')->middleware(['guest', 'signed']);
    Route::get('/fire/email', ForceEmailVerifyNotification::class)->name('force-email-verification-notify')->middleware('guest');
});

Route::get('/about', function () {
    return view('layouts/app');
})->name('about');
Route::get('/contact', function () {
    return view('layouts/app');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

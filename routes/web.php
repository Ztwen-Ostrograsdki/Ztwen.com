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
use App\Http\Controllers\BlockTemporaryMyAccount;
use App\Http\Livewire\AdminAuthorization;
use App\Http\Livewire\ResetPassword;

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
Route::get('/authentification', AdminAuthorization::class)->name('get-admin-authorization')->middleware('auth');
Route::get('/mot-de-passe-oublie', AuthRedirections::class)->name('password-forgot')->middleware('guest');
Route::get('/changer-mot-de-passe/get-protection/id={id}/token={token}/key={key}/hash={hash}/s={skey?}/from-email={email?}/reset-password=1/password=new', ResetPassword::class)->name('reset-password')->middleware(['guest', 'signed']);
Route::get('/verrouillage-de-mon-compte/protection=1/id={id}/token={token}/hash={hash}/security=1/blocked=true', [BlockTemporaryMyAccount::class, '__locked'])->name('block-temporary-account')->middleware(['signed']);

Route::get('/articles', ShowProducts::class)->name('products');
Route::get('/categories', ShowCategories::class)->name('categories');
Route::get('/categories/{id?}', ShowCategories::class)->name('category');
Route::get('/articles/{id?}', ProductProfil::class)->name('product-profil');
Route::post('/inscription', RegisteringNewUser::class)->middleware('guest')->name('inscription');

Route::get('/administration', Admin::class)->middleware(['admin', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser', 'authorized.admin'])->name('admin');
Route::get('/messenger', Messenger::class)->middleware(['auth', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('messenger');
Route::get('/messenger/chat/{id?}', MessengerChat::class)->middleware(['auth', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('chat');
Route::get('profil/{id}', UserProfil::class)->middleware(['user', 'verifiedUser', 'notBlockedUser', 'notFullReportedUser'])->name('user-profil');
Route::prefix('verification')->group(function(){
    Route::get('/email/{id}', EmailVerifyNotification::class)->name('email-verification-notify')->middleware('guest');
    Route::get('/email/confirmation/id={id}/evtok={token}/k={key}/hash={hash}/r=accepted/confirmed=true', ConfirmedEmailVerification::class)->name('confirmed-email-verification')->middleware(['guest', 'signed']);
    Route::get('/fire/email={email}/evtok={token}/k={key}/hash={hash}/r=accepted/confirmed=forced', ForceEmailVerifyNotification::class)->name('force-email-verification-notify')->middleware(['guest', 'signed']);
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

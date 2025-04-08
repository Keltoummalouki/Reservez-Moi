<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProviderReservationController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


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
    return view('home');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(uniqid()),
        ]);

        $role = Role::where('name', 'Client')->first();
        if ($role) {
            $user->roles()->attach($role);
        }
    }

    Auth::login($user);
    return redirect()->intended();
});

Route::get('login/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('login/facebook/callback', function () {
    $facebookUser = Socialite::driver('facebook')->user();

    $user = User::where('facebook_id', $facebookUser->getId())->first();

    if (!$user) {
        $user = User::create([
            'name' => $facebookUser->getName(),
            'email' => $facebookUser->getEmail(),
            'facebook_id' => $facebookUser->getId(),
        ]);

        $role = Role::where('name', 'Client')->first();
        if ($role) {
            $user->roles()->attach($role);
        }
    }

    Auth::login($user);
    return redirect()->intended();
});

Route::middleware(['auth', 'role:Client'])->group(function () {

    Route::get('/client/services', [ClientServiceController::class, 'index'])->name('client.services');

    Route::get('/client/reserve/{service}/form', [ReservationController::class, 'showForm'])->name('client.reserve.form');
    Route::post('/client/reserve/{service}', [ReservationController::class, 'reserve'])->name('client.reserve');
    Route::get('/client/reservations', [ReservationController::class, 'index'])->name('client.reservations');
    Route::post('/client/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('client.reservations.cancel');

    Route::put('/client/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
    ->name('client.reservations.cancel');

    Route::get('/client/reservations/{reservation}/paypal', [ReservationController::class, 'paypal'])
    ->name('client.reservations.paypal');
    Route::get('/client/reservations/paypal/success', [ReservationController::class, 'paypalSuccess'])
        ->name('client.reservations.paypal.success');
    Route::get('/client/reservations/paypal/cancel', [ReservationController::class, 'paypalCancel'])
        ->name('client.reservations.paypal.cancel');
});
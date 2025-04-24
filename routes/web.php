<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProviderReservationController;
use App\Http\Controllers\ProviderAvailabilityController;
use App\Http\Controllers\AdminServiceProviderController;
use App\Http\Controllers\AdminServicesController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProprietaireController;
use App\Http\Controllers\ProviderDashboardController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\ServiceProvider;
use App\Models\Category;

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
})->name('home');

// Routes d'authentification
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:10,1');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Vérification d'email
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Réinitialisation de mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Authentification via Google
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
            'email_verified_at' => now(), // Compte automatiquement vérifié car authentifié par Google
        ]);

        $role = Role::where('name', 'Client')->first();
        if ($role) {
            $user->roles()->attach($role);
        }
    } else {
        // Mettre à jour le google_id si l'utilisateur existe déjà mais n'avait pas de google_id
        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }
    }

    Auth::login($user);
    
    // Redirection basée sur le rôle
    $role = $user->roles->first();
    if ($role) {
        switch ($role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'ServiceProvider':
                return redirect()->route('provider.dashboard');
            case 'Client':
                return redirect()->route('client.services');
            default:
                return redirect()->route('home');
        }
    }
    
    return redirect()->route('home');
});

// Authentification via Facebook
Route::get('login/facebook', function () {
    return Socialite::driver('facebook')->redirect();
})->name('facebook.login');

Route::get('login/facebook/callback', function () {
    $facebookUser = Socialite::driver('facebook')->user();

    $user = User::where('facebook_id', $facebookUser->getId())->orWhere('email', $facebookUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $facebookUser->getName(),
            'email' => $facebookUser->getEmail(),
            'facebook_id' => $facebookUser->getId(),
            'password' => bcrypt(uniqid()),
            'email_verified_at' => now(), // Compte automatiquement vérifié car authentifié par Facebook
        ]);

        $role = Role::where('name', 'Client')->first();
        if ($role) {
            $user->roles()->attach($role);
        }
    } else {
        // Mettre à jour le facebook_id si l'utilisateur existe déjà mais n'avait pas de facebook_id
        if (!$user->facebook_id) {
            $user->update(['facebook_id' => $facebookUser->getId()]);
        }
    }

    Auth::login($user);
    
    // Redirection basée sur le rôle
    $role = $user->roles->first();
    if ($role) {
        switch ($role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'ServiceProvider':
                return redirect()->route('provider.dashboard');
            case 'Client':
                return redirect()->route('client.services');
            default:
                return redirect()->route('home');
        }
    }
    
    return redirect()->route('home');
});

// Routes pour les clients
Route::middleware(['auth', 'role:Client', 'throttle:10,1'])->prefix('client')->name('client.')->group(function () {
    // Services
    Route::get('/services', [ClientServiceController::class, 'index'])->name('services');

    // Réservations
    Route::get('/reserve/{service}/form', [ReservationController::class, 'showForm'])->name('reserve.form');
    Route::get('/reserve/{service}/timeslots', [ReservationController::class, 'getTimeSlots'])->name('timeslots');
    Route::post('/reserve/{service}', [ReservationController::class, 'reserve'])->name('reserve');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
    Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Paiement PayPal
    Route::get('/reservations/{reservation}/paypal', [ReservationController::class, 'paypal'])->name('reservations.paypal');
    Route::get('/reservations/paypal/success', [ReservationController::class, 'paypalSuccess'])->name('reservations.paypal.success');
    Route::get('/reservations/paypal/cancel', [ReservationController::class, 'paypalCancel'])->name('reservations.paypal.cancel');
});

// Routes pour les prestataires de services
Route::middleware(['auth', 'role:ServiceProvider', 'verified'])->prefix('provider')->name('provider.')->group(function () {
    // Tableau de bord
    Route::get('/dashboard', [ProviderDashboardController::class, 'index'])->name('dashboard');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Réservations
    Route::get('/reservations', [ProviderReservationController::class, 'index'])->name('reservations');
    Route::patch('/reservations/{reservation}/confirm', [ProviderReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::patch('/reservations/{reservation}/cancel', [ProviderReservationController::class, 'cancel'])->name('reservations.cancel');

    // Disponibilités
    Route::get('/services/{service}/availability', [ProviderAvailabilityController::class, 'index'])->name('availability.index');
    Route::get('/services/{service}/availability/create-weekly', [ProviderAvailabilityController::class, 'createWeekly'])->name('availability.create-weekly');
    Route::post('/services/{service}/availability/weekly', [ProviderAvailabilityController::class, 'storeWeekly'])->name('availability.store-weekly');
    Route::get('/services/{service}/availability/create-specific', [ProviderAvailabilityController::class, 'createSpecific'])->name('availability.create-specific');
    Route::post('/services/{service}/availability/specific', [ProviderAvailabilityController::class, 'storeSpecific'])->name('availability.store-specific');
    Route::delete('/services/{service}/availability/{availability}', [ProviderAvailabilityController::class, 'destroy'])->name('availability.destroy');

    Route::get('/provider/availability/{serviceId}/edit-weekly/{availabilityId}', [ProviderAvailabilityController::class, 'editWeekly'])
    ->name('provider.availability.edit-weekly');

    Route::put('/provider/availability/{serviceId}/update-weekly/{availabilityId}', [ProviderAvailabilityController::class, 'updateWeekly'])
    ->name('provider.availability.update-weekly');
});

// Routes pour les administrateurs
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les prestataires
    Route::get('/service-providers', [AdminServiceProviderController::class, 'index'])->name('service_providers');
    Route::get('/service-providers/create', [AdminServiceProviderController::class, 'create'])->name('service_providers.create');
    Route::post('/service-providers', [AdminServiceProviderController::class, 'store'])->name('service_providers.store');
    Route::get('/service-providers/{provider}', [AdminServiceProviderController::class, 'show'])->name('service_providers.show');
    Route::get('/service-providers/{provider}/edit', [AdminServiceProviderController::class, 'edit'])->name('service_providers.edit');
    Route::put('/service-providers/{provider}', [AdminServiceProviderController::class, 'update'])->name('service_providers.update');
    Route::delete('/service-providers/{provider}', [AdminServiceProviderController::class, 'destroy'])->name('service_providers.destroy');
    
    // Routes pour les services
    Route::get('/services', [AdminServicesController::class, 'index'])->name('services');
    Route::get('/services/create', [AdminServicesController::class, 'create'])->name('services.create');
    Route::post('/services', [AdminServicesController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminServicesController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [AdminServicesController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServicesController::class, 'destroy'])->name('services.destroy');
    
    // Routes pour les propriétaires
    Route::get('/proprietaires', [AdminProprietaireController::class, 'index'])->name('proprietaires.index');
    Route::get('/proprietaires/create', [AdminProprietaireController::class, 'create'])->name('proprietaires.create');
    Route::post('/proprietaires', [AdminProprietaireController::class, 'store'])->name('proprietaires.store');
    Route::get('/proprietaires/{proprietaire}', [AdminProprietaireController::class, 'show'])->name('proprietaires.show');
    Route::get('/proprietaires/{proprietaire}/edit', [AdminProprietaireController::class, 'edit'])->name('proprietaires.edit');
    Route::put('/proprietaires/{proprietaire}', [AdminProprietaireController::class, 'update'])->name('proprietaires.update');
    Route::delete('/proprietaires/{proprietaire}', [AdminProprietaireController::class, 'destroy'])->name('proprietaires.destroy');
    
    // Routes pour les statistiques
    Route::get('/statistics', [AdminStatisticsController::class, 'index'])->name('statistics');
    
    // Routes pour les paramètres
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});

// Routes pour le système de paiement PayPal
Route::middleware(['auth'])->prefix('paypal')->name('paypal.')->group(function () {
    Route::get('/create-payment', [PayPalController::class, 'createPayment'])->name('create-payment');
    Route::get('/success', [PayPalController::class, 'success'])->name('success');
    Route::get('/cancel', [PayPalController::class, 'cancel'])->name('cancel');
    Route::post('/webhook', [PayPalController::class, 'webhook'])->name('webhook');
});
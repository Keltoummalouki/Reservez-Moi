<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Paramètres - Reservez-Moi">
    <meta name="keywords" content="admin, paramètres, configuration">
    <title>Paramètres - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .sidebar-item.active {
            background-color: rgba(37, 99, 235, 1);
            color: white;
        }
        
        .sidebar-item.active i {
            color: white;
        }
        
        /* Responsive sidebar */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .overlay {
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            }
            
            .overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Mobile Sidebar Toggle -->
    <div class="md:hidden fixed top-4 left-4 z-30">
        <button id="sidebar-toggle" class="bg-white p-2 rounded-md shadow-md text-gray-700 hover:bg-gray-100 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden overlay"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed top-0 left-0 z-30 h-full w-64 bg-blue-800 text-white overflow-y-auto transition-transform">
        <div class="p-5 border-b border-blue-700">
            <div class="flex items-center space-x-3">
                <div class="bg-white rounded-full h-10 w-10 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-lg font-bold">{{ Auth::user()->name }}</div>
                    <p class="text-xs text-blue-200">Administrateur</p>
                </div>
            </div>
        </div>
        
        <div class="p-5">
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-tachometer-alt text-blue-300 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('admin.service_providers') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-building text-blue-300 w-5"></i>
                    <span>Prestataires</span>
                </a>
                <a href="{{ route('admin.services') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-clipboard-list text-blue-300 w-5"></i>
                    <span>Services</span>
                </a>
                <a href="{{ route('admin.statistics') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-chart-bar text-blue-300 w-5"></i>
                    <span>Statistiques</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-cog text-blue-300 w-5"></i>
                    <span>Paramètres</span>
                </a>
                
                <div class="pt-5 mt-5 border-t border-blue-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex w-full items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-sign-out-alt text-blue-300 w-5"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="md:ml-64 min-h-screen">
        <!-- Top Bar -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <h1 class="text-xl font-bold text-gray-800">Paramètres</h1>
                    <div class="flex items-center space-x-4">
                        <button class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-gray-200 focus:outline-none relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Settings Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                        <button class="settings-tab active whitespace-nowrap py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-target="general">
                            Général
                        </button>
                        <button class="settings-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="security">
                            Sécurité
                        </button>
                        <button class="settings-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="payment">
                            Paiement
                        </button>
                        <button class="settings-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="emails">
                            Emails
                        </button>
                        <button class="settings-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="system">
                            Système
                        </button>
                    </nav>
                </div>
            </div>
            
            <!-- Settings Content -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- General Settings -->
                <div id="general-settings" class="settings-content block">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Paramètres généraux</h2>
                        <p class="mt-1 text-sm text-gray-500">Configurez les paramètres généraux de la plateforme</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Site Name -->
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700">Nom du site</label>
                                    <input type="text" name="site_name" id="site_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['site_name']->value ?? 'Reservez-Moi' }}">
                                </div>
                                
                                <!-- Site Email -->
                                <div>
                                    <label for="site_email" class="block text-sm font-medium text-gray-700">Email du site</label>
                                    <input type="email" name="site_email" id="site_email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['site_email']->value ?? 'contact@reservez-moi.fr' }}">
                                </div>
                                
                                <!-- Site Description -->
                                <div class="md:col-span-2">
                                    <label for="site_description" class="block text-sm font-medium text-gray-700">Description du site</label>
                                    <textarea name="site_description" id="site_description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $settings['site_description']->value ?? 'Plateforme de réservation de services en ligne' }}</textarea>
                                </div>
                                
                                <!-- Logo Settings -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Logo du site</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <i class="fas fa-calendar-check text-gray-400 flex items-center justify-center h-full w-full text-xl"></i>
                                        </span>
                                        <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Changer
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Timezone -->
                                <div>
                                    <label for="timezone" class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                                    <select id="timezone" name="timezone" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="Europe/Paris" {{ ($settings['timezone']->value ?? 'Europe/Paris') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (GMT+01:00)</option>
                                        <option value="Europe/London" {{ ($settings['timezone']->value ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT+00:00)</option>
                                        <option value="America/New_York" {{ ($settings['timezone']->value ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (GMT-05:00)</option>
                                    </select>
                                </div>
                                
                                <!-- Date Format -->
                                <div>
                                    <label for="date_format" class="block text-sm font-medium text-gray-700">Format de date</label>
                                    <select id="date_format" name="date_format" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="d/m/Y" {{ ($settings['date_format']->value ?? 'd/m/Y') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY (31/12/2023)</option>
                                        <option value="m/d/Y" {{ ($settings['date_format']->value ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY (12/31/2023)</option>
                                        <option value="Y-m-d" {{ ($settings['date_format']->value ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD (2023-12-31)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200 mt-6">
                                <div class="flex justify-end">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                                        Annuler
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Security Settings -->
                <div id="security-settings" class="settings-content hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Paramètres de sécurité</h2>
                        <p class="mt-1 text-sm text-gray-500">Configurez les paramètres de sécurité de la plateforme</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.settings.security.update') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Password Policy -->
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">Politique de mot de passe</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="password_min_length" name="password_min_length_enabled" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['password_min_length_enabled']->value ?? true) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="password_min_length" class="font-medium text-gray-700">Longueur minimale</label>
                                                <div class="mt-1 flex rounded-md shadow-sm w-32">
                                                    <input type="number" name="password_min_length" id="password_min_length_value" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $settings['password_min_length']->value ?? 8 }}" min="6" max="30">
                                                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                        caract.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="password_require_special" name="password_require_special" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['password_require_special']->value ?? true) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="password_require_special" class="font-medium text-gray-700">Exiger des caractères spéciaux</label>
                                                <p class="text-gray-500">Au moins un caractère spécial (@, #, $, etc.)</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="password_require_numbers" name="password_require_numbers" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['password_require_numbers']->value ?? true) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="password_require_numbers" class="font-medium text-gray-700">Exiger des chiffres</label>
                                                <p class="text-gray-500">Au moins un chiffre (0-9)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Login Security -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Sécurité de connexion</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="login_attempts_limit" name="login_attempts_limit_enabled" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['login_attempts_limit_enabled']->value ?? true) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="login_attempts_limit" class="font-medium text-gray-700">Limiter les tentatives de connexion</label>
                                                <div class="mt-1 flex rounded-md shadow-sm w-48">
                                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                        Bloquer après
                                                    </span>
                                                    <input type="number" name="login_attempts_limit" id="login_attempts_limit_value" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300" value="{{ $settings['login_attempts_limit']->value ?? 5 }}" min="1" max="10">
                                                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                        tentatives
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_recaptcha" name="enable_recaptcha" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['enable_recaptcha']->value ?? false) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_recaptcha" class="font-medium text-gray-700">Activer Google reCAPTCHA</label>
                                                <p class="text-gray-500">Protège le formulaire de connexion contre les robots</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200 mt-6">
                                <div class="flex justify-end">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                                        Annuler
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Payment Settings -->
                <div id="payment-settings" class="settings-content hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Paramètres de paiement</h2>
                        <p class="mt-1 text-sm text-gray-500">Configurez les options de paiement de la plateforme</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Payment Providers -->
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">Fournisseurs de paiement</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_paypal" name="enable_paypal" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['enable_paypal']->value ?? true) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_paypal" class="font-medium text-gray-700">PayPal</label>
                                                <p class="text-gray-500">Activer les paiements via PayPal</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="enable_stripe" name="enable_stripe" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ ($settings['enable_stripe']->value ?? false) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="enable_stripe" class="font-medium text-gray-700">Stripe</label>
                                                <p class="text-gray-500">Activer les paiements via Stripe</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- PayPal Settings -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Configuration PayPal</h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="paypal_client_id" class="block text-sm font-medium text-gray-700">Client ID</label>
                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['paypal_client_id']->value ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="paypal_secret" class="block text-sm font-medium text-gray-700">Secret</label>
                                            <input type="password" name="paypal_secret" id="paypal_secret" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['paypal_secret']->value ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="paypal_mode" class="block text-sm font-medium text-gray-700">Mode</label>
                                            <select id="paypal_mode" name="paypal_mode" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="sandbox" {{ ($settings['paypal_mode']->value ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                                <option value="live" {{ ($settings['paypal_mode']->value ?? '') == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Commission Settings -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Commissions</h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="platform_fee" class="block text-sm font-medium text-gray-700">Frais de plateforme (%)</label>
                                            <div class="mt-1 flex rounded-md shadow-sm w-32">
                                                <input type="number" step="0.01" name="platform_fee" id="platform_fee" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-l-md" value="{{ $settings['platform_fee']->value ?? 5 }}" min="0" max="100">
                                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                    %
                                                </span>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">Le pourcentage que la plateforme prélève sur chaque transaction</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200 mt-6">
                                <div class="flex justify-end">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                                        Annuler
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Email Settings -->
                <div id="emails-settings" class="settings-content hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Paramètres des emails</h2>
                        <p class="mt-1 text-sm text-gray-500">Configurez les paramètres d'envoi d'emails</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.settings.emails.update') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- SMTP Settings -->
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">Configuration SMTP</h3>
                                    <div class="mt-4 grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label for="mail_host" class="block text-sm font-medium text-gray-700">Hôte SMTP</label>
                                            <input type="text" name="mail_host" id="mail_host" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_host']->value ?? 'smtp.gmail.com' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-3">
                                            <label for="mail_port" class="block text-sm font-medium text-gray-700">Port SMTP</label>
                                            <input type="text" name="mail_port" id="mail_port" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_port']->value ?? '587' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-6">
                                            <label for="mail_username" class="block text-sm font-medium text-gray-700">Utilisateur SMTP</label>
                                            <input type="text" name="mail_username" id="mail_username" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_username']->value ?? '' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-6">
                                            <label for="mail_password" class="block text-sm font-medium text-gray-700">Mot de passe SMTP</label>
                                            <input type="password" name="mail_password" id="mail_password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_password']->value ?? '' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-3">
                                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Chiffrement</label>
                                            <select id="mail_encryption" name="mail_encryption" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="tls" {{ ($settings['mail_encryption']->value ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ ($settings['mail_encryption']->value ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                                <option value="none" {{ ($settings['mail_encryption']->value ?? '') == 'none' ? 'selected' : '' }}>Aucun</option>
                                            </select>
                                        </div>
                                        
                                        <div class="sm:col-span-3">
                                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700">Adresse d'expéditeur</label>
                                            <input type="email" name="mail_from_address" id="mail_from_address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_from_address']->value ?? 'noreply@reservez-moi.fr' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-3">
                                            <label for="mail_from_name" class="block text-sm font-medium text-gray-700">Nom d'expéditeur</label>
                                            <input type="text" name="mail_from_name" id="mail_from_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $settings['mail_from_name']->value ?? 'Reservez-Moi' }}">
                                        </div>
                                        
                                        <div class="sm:col-span-3 pt-5">
                                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-paper-plane mr-2"></i>
                                                Tester l'envoi d'email
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Notification Templates -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Modèles de notifications</h3>
                                    <p class="mt-1 text-sm text-gray-500">Gérez les modèles d'emails envoyés automatiquement</p>
                                    
                                    <div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Type d'email</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Dernière modification</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Confirmation de réservation</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Actif
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">12/01/2023</td>
                                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Rappel de rendez-vous</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Actif
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">15/01/2023</td>
                                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Annulation de réservation</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Actif
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">18/01/2023</td>
                                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200 mt-6">
                                <div class="flex justify-end">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                                        Annuler
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- System Settings -->
                <div id="system-settings" class="settings-content hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Paramètres système</h2>
                        <p class="mt-1 text-sm text-gray-500">Configurez les paramètres techniques de la plateforme</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Attention : La modification de ces paramètres peut affecter le fonctionnement de la plateforme. Procédez avec prudence.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-base font-medium text-gray-900 mb-4">Informations système</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Version PHP</span>
                                        <span class="text-sm font-medium">{{ phpversion() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Version Laravel</span>
                                        <span class="text-sm font-medium">{{ app()->version() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Environnement</span>
                                        <span class="text-sm font-medium">{{ app()->environment() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Serveur</span>
                                        <span class="text-sm font-medium">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Non disponible' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-base font-medium text-gray-900 mb-4">Cache et performances</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Vider le cache</span>
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            Vider
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Optimiser la base de données</span>
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-database mr-2"></i>
                                            Optimiser
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Générer les assets</span>
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-sync mr-2"></i>
                                            Générer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            if (sidebarToggle && sidebar && overlay) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                });
            }
            
            // Highlight current page in sidebar
            const currentPath = window.location.pathname;
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            
            sidebarItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href)) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
            
            // Settings tabs
            const settingsTabs = document.querySelectorAll('.settings-tab');
            const settingsContents = document.querySelectorAll('.settings-content');
            
            settingsTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.dataset.target;
                    
                    // Update active tab
                    settingsTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    tab.classList.add('active', 'border-blue-500', 'text-blue-600');
                    tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    
                    // Show content
                    settingsContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(`${target}-settings`).classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>

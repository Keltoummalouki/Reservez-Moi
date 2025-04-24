<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez votre profil et vos paramètres sur Reservez-Moi">
    <meta name="keywords" content="paramètres, profil, prestataire, compte">
    <title>Paramètres du compte - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/sweetalert-config.js') }}"></script>
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
            @apply bg-primary-700 text-white;
        }
        
        .sidebar-item.active i {
            @apply text-white;
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

        /* Tab styles */
        .settings-tab.active {
            @apply bg-primary-50 border-primary-600 text-primary-700;
        }

        .settings-content {
            display: none;
        }

        .settings-content.active {
            display: block;
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
    <aside id="sidebar" class="sidebar fixed top-0 left-0 z-30 h-full w-64 bg-primary-800 text-white overflow-y-auto transition-transform">
        <div class="p-5 border-b border-primary-700">
            <div class="flex items-center space-x-3">
                <div class="bg-white rounded-full p-2">
                    <i class="fas fa-calendar-check text-primary-600 text-xl"></i>
                </div>
                <span class="text-lg font-bold">Reservez-Moi</span>
            </div>
            <p class="text-xs text-primary-200 mt-1">Espace prestataire</p>
        </div>
        
        <div class="p-5">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-primary-700 rounded-full h-10 w-10 flex items-center justify-center">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div>
                    <p class="font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-primary-200">Prestataire</p>
                </div>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('provider.dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-tachometer-alt text-primary-300 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('provider.services') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-list-alt text-primary-300 w-5"></i>
                    <span>Mes services</span>
                </a>
                <a href="{{ route('provider.availability.index') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-clock text-primary-300 w-5"></i>
                    <span>Disponibilités</span>
                </a>
                <a href="{{ route('provider.reservations') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-calendar-alt text-primary-300 w-5"></i>
                    <span>Réservations</span>
                </a>
                <a href="{{ route('provider.settings') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-cog text-primary-300 w-5"></i>
                    <span>Paramètres</span>
                </a>
                
                <div class="pt-5 mt-5 border-t border-primary-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex w-full items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                            <i class="fas fa-sign-out-alt text-primary-300 w-5"></i>
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
                    <h1 class="text-xl font-bold text-gray-800">Paramètres du compte</h1>
                    <div class="flex items-center space-x-4">
                        <button class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-gray-200 focus:outline-none relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 hidden sm:block"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Error Message -->
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Settings Layout -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Settings Tabs -->
                <div class="w-full md:w-64 shrink-0">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Paramètres</h2>
                        </div>
                        <nav class="p-2">
                            <a href="#profile" class="settings-tab active flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1" data-tab="profile">
                                <i class="fas fa-user-circle w-5 mr-2 text-gray-500"></i>
                                Profil
                            </a>
                            <a href="#business" class="settings-tab flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1" data-tab="business">
                                <i class="fas fa-briefcase w-5 mr-2 text-gray-500"></i>
                                Informations professionnelles
                            </a>
                            <a href="#security" class="settings-tab flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1" data-tab="security">
                                <i class="fas fa-lock w-5 mr-2 text-gray-500"></i>
                                Sécurité
                            </a>
                            <a href="#notifications" class="settings-tab flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1" data-tab="notifications">
                                <i class="fas fa-bell w-5 mr-2 text-gray-500"></i>
                                Notifications
                            </a>
                            <a href="#payment" class="settings-tab flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1" data-tab="payment">
                                <i class="fas fa-credit-card w-5 mr-2 text-gray-500"></i>
                                Paiements
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="flex-1">
                    <!-- Profile Settings -->
                    <div id="profile-content" class="settings-content active bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
                            <p class="mt-1 text-sm text-gray-500">Mettez à jour vos informations personnelles</p>
                        </div>
                        <form action="{{ route('provider.settings.update-profile') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Profile Picture -->
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="relative">
                                        <div class="h-32 w-32 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 overflow-hidden">
                                            @if(isset($provider) && $provider->profile_picture)
                                                <img src="{{ asset('storage/' . $provider->profile_picture) }}" alt="Photo de profil" class="h-full w-full object-cover">
                                            @else
                                                <i class="fas fa-user text-5xl"></i>
                                            @endif
                                        </div>
                                        <label for="profile_picture" class="absolute bottom-0 right-0 bg-primary-600 text-white p-2 rounded-full cursor-pointer hover:bg-primary-700 transition-colors">
                                            <i class="fas fa-camera"></i>
                                            <span class="sr-only">Changer la photo</span>
                                        </label>
                                        <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                                    </div>
                                    <p class="text-xs text-gray-500">Cliquez sur l'icône pour changer votre photo</p>
                                </div>

                                <!-- Personal Information -->
                                <div class="flex-1 space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $provider->first_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $provider->last_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $provider->phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                                        <textarea name="bio" id="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('bio', $provider->bio ?? '') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Brève description qui apparaîtra sur votre profil public</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Business Information Settings -->
                    <div id="business-content" class="settings-content bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Informations professionnelles</h2>
                            <p class="mt-1 text-sm text-gray-500">Configurez les détails de votre activité professionnelle</p>
                        </div>
                        <form action="{{ route('provider.settings.update-business') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-4">
                                <div>
                                    <label for="business_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $provider->business_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="business_type" class="block text-sm font-medium text-gray-700">Type d'activité</label>
                                    <select name="business_type" id="business_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        <option value="">Sélectionnez un type</option>
                                        <option value="Médical" {{ old('business_type', $provider->business_type ?? '') == 'Médical' ? 'selected' : '' }}>Médical</option>
                                        <option value="Juridique" {{ old('business_type', $provider->business_type ?? '') == 'Juridique' ? 'selected' : '' }}>Juridique</option>
                                        <option value="Beauté & Spa" {{ old('business_type', $provider->business_type ?? '') == 'Beauté & Spa' ? 'selected' : '' }}>Beauté & Spa</option>
                                        <option value="Hôtel" {{ old('business_type', $provider->business_type ?? '') == 'Hôtel' ? 'selected' : '' }}>Hôtel</option>
                                        <option value="Restaurant" {{ old('business_type', $provider->business_type ?? '') == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                        <option value="Autre" {{ old('business_type', $provider->business_type ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="business_description" class="block text-sm font-medium text-gray-700">Description de l'activité</label>
                                    <textarea name="business_description" id="business_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('business_description', $provider->business_description ?? '') }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $provider->address ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                        <input type="text" name="city" id="city" value="{{ old('city', $provider->city ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $provider->postal_code ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                                        <select name="country" id="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                            <option value="France" {{ old('country', $provider->country ?? '') == 'France' ? 'selected' : '' }}>France</option>
                                            <option value="Belgique" {{ old('country', $provider->country ?? '') == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                                            <option value="Suisse" {{ old('country', $provider->country ?? '') == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                                            <option value="Canada" {{ old('country', $provider->country ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                            <option value="Autre" {{ old('country', $provider->country ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Site web</label>
                                    <input type="url" name="website" id="website" value="{{ old('website', $provider->website ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="siret" class="block text-sm font-medium text-gray-700">Numéro SIRET</label>
                                        <input type="text" name="siret" id="siret" value="{{ old('siret', $provider->siret ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="vat_number" class="block text-sm font-medium text-gray-700">Numéro de TVA</label>
                                        <input type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', $provider->vat_number ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Settings -->
                    <div id="security-content" class="settings-content bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Sécurité</h2>
                            <p class="mt-1 text-sm text-gray-500">Gérez votre mot de passe et la sécurité de votre compte</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Change Password Form -->
                            <form action="{{ route('provider.settings.update-password') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <h3 class="text-base font-medium text-gray-900">Changer le mot de passe</h3>
                                
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Mettre à jour le mot de passe
                                    </button>
                                </div>
                            </form>
                            
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Sessions actives</h3>
                                
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="bg-green-100 p-2 rounded-full text-green-600">
                                                    <i class="fas fa-desktop"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">Session actuelle</p>
                                                    <p class="text-xs text-gray-500">Chrome sur Windows • Paris, France • Connecté il y a 2 minutes</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="bg-gray-100 p-2 rounded-full text-gray-600">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">iPhone 13</p>
                                                    <p class="text-xs text-gray-500">Safari sur iOS • Lyon, France • Dernière connexion il y a 2 jours</p>
                                                </div>
                                            </div>
                                            <button type="button" class="text-sm text-red-600 hover:text-red-900">Déconnecter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Authentification à deux facteurs</h3>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="two_factor" name="two_factor" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="two_factor" class="font-medium text-gray-700">Activer l'authentification à deux facteurs</label>
                                        <p class="text-gray-500">Ajoutez une couche de sécurité supplémentaire à votre compte en exigeant plus qu'un mot de passe pour vous connecter.</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pl-7 hidden" id="two-factor-setup">
                                    <p class="text-sm text-gray-500 mb-4">Scannez le code QR ci-dessous avec votre application d'authentification préférée (comme Google Authenticator, Authy, etc.).</p>
                                    
                                    <div class="bg-gray-100 p-4 rounded-md flex justify-center mb-4">
                                        <div class="h-40 w-40 bg-white p-2 rounded-md">
                                            <!-- QR Code placeholder -->
                                            <div class="h-full w-full border-2 border-dashed border-gray-300 rounded flex items-center justify-center text-gray-400">
                                                <span>QR Code</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="verification_code" class="block text-sm font-medium text-gray-700">Code de vérification</label>
                                        <input type="text" name="verification_code" id="verification_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Entrez le code à 6 chiffres">
                                    </div>
                                    
                                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Vérifier et activer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Settings -->
                    <div id="notifications-content" class="settings-content bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
                            <p class="mt-1 text-sm text-gray-500">Gérez vos préférences de notifications</p>
                        </div>
                        <form action="{{ route('provider.settings.update-notifications') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">Notifications par e-mail</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_new_reservation" name="email_new_reservation" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_new_reservation ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_new_reservation" class="font-medium text-gray-700">Nouvelles réservations</label>
                                                <p class="text-gray-500">Recevez un e-mail lorsqu'un client effectue une nouvelle réservation.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_reservation_reminder" name="email_reservation_reminder" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_reservation_reminder ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_reservation_reminder" class="font-medium text-gray-700">Rappels de réservation</label>
                                                <p class="text-gray-500">Recevez un e-mail de rappel avant les réservations à venir.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_reservation_cancelled" name="email_reservation_cancelled" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_reservation_cancelled ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_reservation_cancelled" class="font-medium text-gray-700">Annulations de réservation</label>
                                                <p class="text-gray-500">Recevez un e-mail lorsqu'un client annule une réservation.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_marketing" name="email_marketing" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_marketing ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_marketing" class="font-medium text-gray-700">Communications marketing</label>
                                                <p class="text-gray-500">Recevez des e-mails sur les nouvelles fonctionnalités, les conseils et les offres spéciales.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Notifications SMS</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="sms_new_reservation" name="sms_new_reservation" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->sms_new_reservation ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="sms_new_reservation" class="font-medium text-gray-700">Nouvelles réservations</label>
                                                <p class="text-gray-500">Recevez un SMS lorsqu'un client effectue une nouvelle réservation.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="sms_reservation_reminder" name="sms_reservation_reminder" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->sms_reservation_reminder ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="sms_reservation_reminder" class="font-medium text-gray-700">Rappels de réservation</label>
                                                <p class="text-gray-500">Recevez un SMS de rappel avant les réservations à venir.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-base font-medium text-gray-900">Notifications dans l'application</h3>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="app_all_notifications" name="app_all_notifications" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->app_all_notifications ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="app_all_notifications" class="font-medium text-gray-700">Toutes les notifications</label>
                                                <p class="text-gray-500">Activez ou désactivez toutes les notifications dans l'application.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Enregistrer les préférences
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Settings -->
                    <div id="payment-content" class="settings-content bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Paiements</h2>
                            <p class="mt-1 text-sm text-gray-500">Gérez vos informations de paiement et vos préférences</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Bank Account Information -->
                            <div>
                                <h3 class="text-base font-medium text-gray-900 mb-4">Informations bancaires</h3>
                                
                                <form action="{{ route('provider.settings.update-payment') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div>
                                        <label for="account_holder" class="block text-sm font-medium text-gray-700">Titulaire du compte</label>
                                        <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder', $payment->account_holder ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="iban" class="block text-sm font-medium text-gray-700">IBAN</label>
                                        <input type="text" name="iban" id="iban" value="{{ old('iban', $payment->iban ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="bic" class="block text-sm font-medium text-gray-700">BIC/SWIFT</label>
                                        <input type="text" name="bic" id="bic" value="{{ old('bic', $payment->bic ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            Enregistrer les informations bancaires
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Payment Preferences -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Préférences de paiement</h3>
                                
                                <form action="{{ route('provider.settings.update-payment-preferences') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div>
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Méthode de paiement préférée</label>
                                        <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                            <option value="bank_transfer" {{ isset($payment) && $payment->payment_method == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                                            <option value="stripe" {{ isset($payment) && $payment->payment_method == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                            <option value="paypal" {{ isset($payment) && $payment->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="payout_frequency" class="block text-sm font-medium text-gray-700">Fréquence de versement</label>
                                        <select name="payout_frequency" id="payout_frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                            <option value="weekly" {{ isset($payment) && $payment->payout_frequency == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                                            <option value="biweekly" {{ isset($payment) && $payment->payout_frequency == 'biweekly' ? 'selected' : '' }}>Bimensuelle</option>
                                            <option value="monthly" {{ isset($payment) && $payment->payout_frequency == 'monthly' ? 'selected' : '' }}>Mensuelle</option>
                                        </select>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            Enregistrer les préférences
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Payment History -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Historique des paiements</h3>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($payments ?? [] as $payment)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->date }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->amount }} €</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($payment->method) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                        Aucun paiement trouvé
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
            
            // Settings tabs functionality
            const tabLinks = document.querySelectorAll('.settings-tab');
            const tabContents = document.querySelectorAll('.settings-content');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(tab => {
                        tab.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    // Show the corresponding tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId + '-content').classList.add('active');
                    
                    // Update URL hash
                    window.location.hash = this.getAttribute('href');
                });
            });
            
            // Check for hash in URL and activate corresponding tab
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const tab = document.querySelector(`.settings-tab[data-tab="${hash}"]`);
                if (tab) {
                    tab.click();
                }
            }
            
            // Two-factor authentication toggle
            const twoFactorCheckbox = document.getElementById('two_factor');
            const twoFactorSetup = document.getElementById('two-factor-setup');
            
            if (twoFactorCheckbox && twoFactorSetup) {
                twoFactorCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        twoFactorSetup.classList.remove('hidden');
                    } else {
                        twoFactorSetup.classList.add('hidden');
                    }
                });
            }
            
            // Profile picture upload preview
            const profilePictureInput = document.getElementById('profile_picture');
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const file = e.target.files[0];
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const profilePictureContainer = profilePictureInput.closest('.relative').querySelector('.rounded-full');
                            
                            // Check if there's already an image
                            let img = profilePictureContainer.querySelector('img');
                            
                            if (!img) {
                                // Create new image if it doesn't exist
                                img = document.createElement('img');
                                img.classList.add('h-full', 'w-full', 'object-cover');
                                
                                // Remove icon if it exists
                                const icon = profilePictureContainer.querySelector('i');
                                if (icon) {
                                    profilePictureContainer.removeChild(icon);
                                }
                                
                                profilePictureContainer.appendChild(img);
                            }
                            
                            img.src = e.target.result;
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>
</html>

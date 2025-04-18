<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajoutez une disponibilité hebdomadaire pour votre service sur Reservez-Moi.">
    <meta name="keywords" content="disponibilités, service provider, réservations">
    <title>Ajouter une disponibilité hebdomadaire - Reservez-Moi</title>
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
                <a href="{{ route('provider.availability.index', $service->id) }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-clock text-primary-300 w-5"></i>
                    <span>Disponibilités</span>
                </a>
                <a href="{{ route('provider.reservations') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-calendar-alt text-primary-300 w-5"></i>
                    <span>Réservations</span>
                </a>
                <a href="#" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Ajouter une disponibilité hebdomadaire</h1>
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
        
        <!-- Form Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-gray-900 sm:text-xl">
                        Ajouter une disponibilité hebdomadaire
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Service : {{ $service->name }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('provider.availability.index', $service->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                        <i class="fas fa-arrow-left -ml-1 mr-2 text-gray-500"></i>
                        Retour aux disponibilités
                    </a>
                </div>
            </div>
            
            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Veuillez corriger les erreurs suivantes :
                            </h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('provider.availability.store-weekly', $service->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700">Jour de la semaine</label>
                            <select id="day_of_week" name="day_of_week" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md" required>
                                <option value="" disabled selected>Sélectionnez un jour</option>
                                <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>Lundi</option>
                                <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>Mardi</option>
                                <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>Mercredi</option>
                                <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>Jeudi</option>
                                <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>Vendredi</option>
                                <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>Samedi</option>
                                <option value="0" {{ old('day_of_week') === '0' ? 'selected' : '' }}>Dimanche</option>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début</label>
                                <div class="mt-1 relative">
                                    <input id="start_time" name="start_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" value="{{ old('start_time') }}" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                                <div class="mt-1 relative">
                                    <input id="end_time" name="end_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" value="{{ old('end_time') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="max_reservations" class="block text-sm font-medium text-gray-700">Nombre maximum de réservations</label>
                            <div class="mt-1 relative">
                                <input id="max_reservations" name="max_reservations" type="number" min="1" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" value="{{ old('max_reservations', 1) }}" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Combien de clients peuvent réserver ce créneau en même temps</p>
                        </div>
                        
                        <div class="flex space-x-4 pt-4">
                            <button type="submit" class="flex-grow bg-primary-600 text-white px-6 py-3 rounded-md font-medium hover:bg-primary-700 transition duration-300 shadow-md hover:shadow-lg">
                                <i class="fas fa-save mr-2"></i> Ajouter cette disponibilité
                            </button>
                            <a href="{{ route('provider.availability.index', $service->id) }}" class="bg-gray-500 text-white px-6 py-3 rounded-md font-medium hover:bg-gray-600 transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </a>
                        </div>
                    </form>
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
        });
    </script>
</body>
</html>
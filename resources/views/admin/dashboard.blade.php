<!-- dashboard.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord administrateur - Reservez-Moi">
    <meta name="keywords" content="admin, dashboard, gestion">
    <title>Tableau de bord Admin - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif']
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
            background-color: rgba(2, 132, 199, 1);
            color: white;
        }
        
        .sidebar-item.active i {
            color: white;
        }
        
        /* Improved loading animation */
        .loader {
            border-top-color: rgba(2, 132, 199, 1);
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }
        
        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Card hover effect */
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
        
        /* Table hover effects */
        .table-row-hover:hover {
            background-color: rgba(243, 244, 246, 1);
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Mobile Sidebar Toggle -->
    <div class="md:hidden fixed top-4 left-4 z-30">
        <button id="sidebar-toggle" class="bg-white p-2 rounded-md shadow-md text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden overlay"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed top-0 left-0 z-30 h-full w-64 bg-primary-800 text-white overflow-y-auto transition-transform custom-scrollbar">
        <div class="p-5 border-b border-primary-700">
            <div class="flex items-center space-x-3">
                <div class="bg-white rounded-full h-10 w-10 flex items-center justify-center">
                    <i class="fas fa-user text-primary-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-lg font-bold">{{ Auth::user()->name }}</div>
                    <p class="text-xs text-primary-200">Administrateur</p>
                </div>
            </div>
        </div>
        
        <div class="p-5">
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-tachometer-alt text-primary-300 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('admin.service_providers') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-building text-primary-300 w-5"></i>
                    <span>Prestataires</span>
                </a>
                <a href="{{ route('admin.services') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-clipboard-list text-primary-300 w-5"></i>
                    <span>Services</span>
                </a>
                <a href="{{ route('admin.statistics') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-chart-bar text-primary-300 w-5"></i>
                    <span>Statistiques</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
        <div class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <h1 class="text-xl font-bold text-gray-800">Tableau de bord Administrateur</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notif-btn" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 relative">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                            <div id="notif-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-700">Notifications</p>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                                <i class="fas fa-user-plus text-primary-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Nouveau prestataire</p>
                                                <p class="text-xs text-gray-500 mt-1">Le compte "Spa Zenitude" a été créé</p>
                                                <p class="text-xs text-gray-400 mt-1">Il y a 30 minutes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                                <i class="fas fa-calendar-check text-green-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Nouvelle réservation</p>
                                                <p class="text-xs text-gray-500 mt-1">Une nouvelle réservation a été confirmée</p>
                                                <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="px-4 py-2 border-t border-gray-100 text-center">
                                    <a href="#" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Voir toutes les notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button id="user-menu-btn" class="flex text-sm bg-primary-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <span class="sr-only">Ouvrir le menu utilisateur</span>
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Votre profil</a>
                                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm animate__animated animate__fadeIn">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                        <button class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm animate__animated animate__fadeIn">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                        <button class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Vue d'ensemble</h2>
                <p class="text-gray-500 text-sm mt-1">Consultez les statistiques de votre plateforme en un coup d'œil</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Prestataires</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($serviceProviders) }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 5%
                        </span>
                        <div class="bg-gray-200 h-1 w-full ml-2 rounded-full">
                            <div class="bg-green-500 h-1 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Services</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalServices ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8%
                        </span>
                        <div class="bg-gray-200 h-1 w-full ml-2 rounded-full">
                            <div class="bg-green-500 h-1 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Clients</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalClients ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 12%
                        </span>
                        <div class="bg-gray-200 h-1 w-full ml-2 rounded-full">
                            <div class="bg-green-500 h-1 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenus</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalRevenue ?? '0' }} €</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 15%
                        </span>
                        <div class="bg-gray-200 h-1 w-full ml-2 rounded-full">
                            <div class="bg-green-500 h-1 rounded-full" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities & Reservations Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Activities Section -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Activités récentes</h2>
                        <a href="#" class="text-primary-600 hover:text-primary-800 text-sm font-medium flex items-center">
                            Voir tout <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 space-y-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Nouveau prestataire ajouté</p>
                                    <p class="text-sm text-gray-500">Le prestataire "Spa Zenitude" a été ajouté par Admin</p>
                                    <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Nouveau service ajouté</p>
                                    <p class="text-sm text-gray-500">Le service "Consultation juridique" a été ajouté par Maître Dupont</p>
                                    <p class="text-xs text-gray-400 mt-1">Il y a 5 heures</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Nouvel avis client</p>
                                    <p class="text-sm text-gray-500">Marie L. a laissé un avis 5 étoiles pour "Massage relaxant"</p>
                                    <p class="text-xs text-gray-400 mt-1">Il y a 1 jour</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Prestataire supprimé</p>
                                    <p class="text-sm text-gray-500">Le prestataire "Salon Coiffure Express" a été supprimé par Admin</p>
                                    <p class="text-xs text-gray-400 mt-1">Il y a 2 jours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Reservations Chart -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Réservations récentes</h2>
                        <a href="#" class="text-primary-600 hover:text-primary-800 text-sm font-medium flex items-center">
                            Voir tout <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-lg font-medium text-gray-800">Vue d'ensemble</p>
                                <p class="text-sm text-gray-500">30 derniers jours</p>
                            </div>
                            <select class="text-sm border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                <option>30 derniers jours</option>
                                <option>3 derniers mois</option>
                                <option>6 derniers mois</option>
                            </select>
                        </div>
                        <div class="h-60 relative">
                            <canvas id="reservationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Reservations Table -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Dernières réservations</h2>
                    <a href="#" class="text-primary-600 hover:text-primary-800 text-sm font-medium flex items-center">
                        Voir toutes les réservations <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentReservations ?? [] as $reservation)
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center text-primary-700">
                                                {{ substr($reservation->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name ?? 'Client inconnu' }}</div>
                                                <div class="text-xs text-gray-500">{{ $reservation->user->email ?? 'email@exemple.com' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->service->name ?? 'Service inconnu' }}</div>
                                        <div class="text-xs text-gray-500">{{ $reservation->service->provider->name ?? 'Prestataire inconnu' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->reservation_date ? $reservation->reservation_date->format('d/m/Y H:i') : 'Date inconnue' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->amount ?? '0' }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reservation->status === 'confirmed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmée
                                            </span>
                                        @elseif($reservation->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Annulée
                                            </span>
                                        @elseif($reservation->status === 'completed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Terminée
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Statut inconnu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="#" class="text-primary-600 hover:text-primary-900" title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($reservation->status === 'pending')
                                                <button class="text-green-600 hover:text-green-900" title="Confirmer">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($reservation->status !== 'cancelled' && $reservation->status !== 'completed')
                                                <button class="text-red-600 hover:text-red-900" title="Annuler">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if(empty($recentReservations ?? []))
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <p class="py-6">Aucune réservation récente</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Services by Category -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Services par catégorie</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            @foreach($servicesByCategory ?? [] as $category)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $category['name'] }}</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $category['count'] }} services</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if(empty($servicesByCategory ?? []))
                            <div class="text-center py-4">
                                <p class="text-gray-500">Aucune donnée disponible</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Reservations Overview -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800">Aperçu des réservations</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                                <p class="text-sm font-medium text-gray-500">Aujourd'hui</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $todayReservations ?? 0 }}</p>
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <span class="text-green-600 font-medium mr-1">+{{ $todayReservationsGrowth ?? 0 }}%</span>
                                    vs. hier
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                                <p class="text-sm font-medium text-gray-500">Cette semaine</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $weekReservations ?? 0 }}</p>
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <span class="text-green-600 font-medium mr-1">+{{ $weekReservationsGrowth ?? 0 }}%</span>
                                    vs. semaine dernière
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                                <p class="text-sm font-medium text-gray-500">Ce mois</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $monthReservations ?? 0 }}</p>
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <span class="text-green-600 font-medium mr-1">+{{ $monthReservationsGrowth ?? 0 }}%</span>
                                    vs. mois dernier
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:shadow-md">
                                <p class="text-sm font-medium text-gray-500">Annulations</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $cancelledReservations ?? 0 }}</p>
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <span class="text-red-600 font-medium mr-1">{{ $cancelledReservationsGrowth ?? 0 }}%</span>
                                    du total
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Section -->
            <div class="mb-8">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Actions rapides</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.service_providers.create') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-all duration-300 flex flex-col items-center text-center group">
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mb-4 group-hover:bg-primary-200 transition-colors">
                            <i class="fas fa-user-plus text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-1">Gestion des prestataires</h3>
                        <p class="text-sm text-gray-500">Consulter et gérer les prestataire</p>
                    </a>
                    
                    <a href="{{ route('admin.services') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-all duration-300 flex flex-col items-center text-center group">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-4 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-1">Gérer les services</h3>
                        <p class="text-sm text-gray-500">Consulter et gérer les services</p>
                    </a>
                    
                    <a href="{{ route('admin.statistics') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-all duration-300 flex flex-col items-center text-center group">
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mb-4 group-hover:bg-indigo-200 transition-colors">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-1">Voir les statistiques</h3>
                        <p class="text-sm text-gray-500">Analyser les performances</p>
                    </a>
                    
                    <a href="{{ route('admin.settings') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-all duration-300 flex flex-col items-center text-center group">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mb-4 group-hover:bg-yellow-200 transition-colors">
                            <i class="fas fa-cog text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-1">Paramètres</h3>
                        <p class="text-sm text-gray-500">Configurer la plateforme</p>
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-calendar-check text-primary-600 mr-2"></i>
                    <span class="text-sm text-gray-500">© {{ date('Y') }} Reservez-Moi. Tous droits réservés.</span>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Aide</span>
                            <i class="fas fa-question-circle"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Documentation</span>
                            <i class="fas fa-book"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Support</span>
                            <i class="fas fa-headset"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            
            // Toggle dropdown for notifications
            const notifBtn = document.getElementById('notif-btn');
            const notifDropdown = document.getElementById('notif-dropdown');
            
            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                    userDropdown.classList.add('hidden');
                });
            }
            
            // Toggle dropdown for user menu
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                    notifDropdown.classList.add('hidden');
                });
            }
            
            // Close dropdowns when clicking elsewhere
            document.addEventListener('click', function() {
                if (notifDropdown) notifDropdown.classList.add('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
            });
            
            // Reservation Chart
            const reservationChartCtx = document.getElementById('reservationChart');
            if (reservationChartCtx) {
                new Chart(reservationChartCtx, {
                    type: 'line',
                    data: {
                        labels: ['1 Jan', '5 Jan', '10 Jan', '15 Jan', '20 Jan', '25 Jan', '30 Jan'],
                        datasets: [
                            {
                                label: 'Nombre de réservations',
                                data: [12, 19, 15, 25, 22, 30, 35],
                                borderColor: 'rgb(2, 132, 199)',
                                backgroundColor: 'rgba(2, 132, 199, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#111827',
                                bodyColor: '#6B7280',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.raw + ' réservations';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [2, 4],
                                    color: '#E5E7EB'
                                }
                            }
                        }
                    }
                });
            }
            
            // Auto close alerts after 5 seconds
            const alerts = document.querySelectorAll('.animate__animated');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('animate__fadeOut');
                    setTimeout(() => {
                        alert.remove();
                    }, 1000);
                }, 5000);
            });
        });
    </script>
</body>
</html>
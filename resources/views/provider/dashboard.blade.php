<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord prestataire - Reservez-Moi">
    <meta name="keywords" content="dashboard, prestataire, services, réservations">
    <title>Tableau de bord prestataire - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
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
                <a href="{{ route('provider.dashboard') }}" class="sidebar-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-tachometer-alt text-primary-300 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('provider.services.index') }}" class="sidebar-item {{ request()->routeIs('provider.services*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-list-alt text-primary-300 w-5"></i>
                    <span>Mes services</span>
                </a>
                <a href="{{ route('provider.reservations') }}" class="sidebar-item {{ request()->routeIs('provider.reservations*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-calendar-alt text-primary-300 w-5"></i>
                    <span>Réservations</span>
                </a>
                <a href="#" class="sidebar-item {{ request()->routeIs('provider.settings*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Tableau de bord</h1>
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
        
        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Services actifs</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $servicesCount ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            <i class="fas fa-list-alt"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="{{ route('provider.services.index') }}" class="text-primary-600 font-medium flex items-center hover:underline">
                            <span>Gérer mes services</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Réservations totales</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $reservationsCount ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="{{ route('provider.reservations') }}" class="text-primary-600 font-medium flex items-center hover:underline">
                            <span>Voir les réservations</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Réservations en attente</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingReservationsCount ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="{{ route('provider.reservations') }}" class="text-primary-600 font-medium flex items-center hover:underline">
                            <span>Gérer les attentes</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Revenus estimés</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $revenue ?? '0' }} €</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="#" class="text-primary-600 font-medium flex items-center hover:underline">
                            <span>Voir les revenus</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Services Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Mes services</h2>
                    <a href="{{ route('provider.services.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter un service
                    </a>
                </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disponibilités</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($services ?? [] as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($service->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $service->category->name ?? 'Non classé' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->price }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($service->is_available)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Disponible
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Non disponible
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->reservations_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->availabilities_count ?? 0 }}
                                        <a href="{{ route('provider.availability.index', $service->id) }}" class="ml-2 text-xs text-primary-600 hover:text-primary-800">
                                            <i class="fas fa-calendar"></i> Gérer
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('provider.services.edit', $service->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('provider.availability.index', $service->id) }}" class="text-blue-600 hover:text-blue-900" title="Disponibilités">
                                                <i class="fas fa-clock"></i>
                                            </a>
                                            <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center py-6">
                                            <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                                                <i class="fas fa-clipboard-list text-2xl"></i>
                                            </div>
                                            <p class="text-gray-500 mb-2">Vous n'avez pas encore ajouté de services</p>
                                            <a href="{{ route('provider.services.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                                                <i class="fas fa-plus mr-2"></i> Ajouter un service
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Services par catégorie -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Services par catégorie</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mr-4">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->services->count() }} services</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            @forelse($category->services as $service)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $service->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $service->price }} € - {{ $service->duration }} min</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                    <a href="{{ route('provider.services.edit', $service) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 text-center">Aucun service dans cette catégorie</p>
                            @endforelse
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('provider.services.create') }}?category={{ $category->id }}" 
                               class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-plus mr-1"></i> Ajouter un service
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Recent Reservations Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Réservations récentes</h2>
                    <a href="{{ route('provider.reservations') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium flex items-center">
                        Voir toutes <i class="fas fa-arrow-right ml-2"></i>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reservations ?? [] as $reservation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($reservation->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name ?? 'Client inconnu' }}</div>
                                                <div class="text-xs text-gray-500">{{ $reservation->user->email ?? 'Email inconnu' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->service->name ?? 'Service inconnu' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->reservation_date ? $reservation->reservation_date->format('d/m/Y H:i') : 'Date inconnue' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reservation->status == 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($reservation->status == 'confirmed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmée
                                            </span>
                                        @elseif($reservation->status == 'cancelled')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Annulée
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reservation->payment_status == 'completed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Payé
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($reservation->status == 'pending')
                                                <form action="{{ route('provider.reservations.confirm', $reservation->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Confirmer" onclick="return confirm('Êtes-vous sûr de vouloir confirmer cette réservation?');">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($reservation->status == 'pending' || $reservation->status == 'confirmed')
                                                <form action="{{ route('provider.reservations.cancel', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Annuler">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button class="text-blue-600 hover:text-blue-900 view-details" data-id="{{ $reservation->id }}" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <div class="py-6">
                                            <p class="text-gray-500">Aucune réservation récente</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Disponibilités récentes -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Prochaines disponibilités</h2>
                    @if(count($services ?? []) > 0)
                        <a href="{{ route('provider.availability.index', $services->first()->id) }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium flex items-center">
                            Gérer les disponibilités <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Jour</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horaires</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($upcomingAvailabilities ?? [] as $availability)
                                     <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $availability->service->name ?? 'Service inconnu' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($availability->specific_date)
                                            {{ \Carbon\Carbon::parse($availability->specific_date)->format('d/m/Y') }}
                                        @else
                                            @switch($availability->day_of_week)
                                                @case(0) Dimanche @break
                                                @case(1) Lundi @break
                                                @case(2) Mardi @break
                                                @case(3) Mercredi @break
                                                @case(4) Jeudi @break
                                                @case(5) Vendredi @break
                                                @case(6) Samedi @break
                                            @endswitch
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($availability->is_available)
                                            <span class="text-gray-900">{{ $availability->reservations_count ?? 0 }} / {{ $availability->max_reservations }}</span>
                                        @else
                                            <span class="text-red-600">Indisponible</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($availability->specific_date)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Spécifique
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Récurrent
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('provider.availability.index', $availability->service_id) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir toutes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <div class="py-6">
                                            <p class="text-gray-500">Aucune disponibilité configurée</p>
                                            @if(count($services ?? []) > 0)
                                                <a href="{{ route('provider.availability.index', $services->first()->id) }}" class="mt-2 inline-block text-primary-600 hover:text-primary-800">
                                                    Ajouter une disponibilité
                                                </a>
                                            @endif
                                        </div>                         
                                        <tr class="hover:bg-gray-50">
   
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Reservation Details Modal -->
    <div id="details-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Détails de la réservation</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6" id="modal-content">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-600"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Si l'utilisateur a des services, le menu "Disponibilités" redirige vers le premier service
            const availabilityMenuItem = document.getElementById('availability-menu-item');
            if (availabilityMenuItem) {
                @if(isset($services) && count($services) > 0)
                    availabilityMenuItem.href = "{{ route('provider.availability.index', isset($services->first()->id) ? $services->first()->id : '') }}";
                @elseif(isset($service))
                    availabilityMenuItem.href = "{{ route('provider.availability.index', $service->id) }}";
                @else
                    availabilityMenuItem.href = "{{ route('provider.services') }}";
                @endif
            }
        });
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
            
            // Modal functionality
            const detailsModal = document.getElementById('details-modal');
            const closeModal = document.getElementById('close-modal');
            const viewDetailsButtons = document.querySelectorAll('.view-details');
            const modalContent = document.getElementById('modal-content');
            
            if (viewDetailsButtons.length > 0 && detailsModal && closeModal && modalContent) {
                viewDetailsButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const reservationId = this.getAttribute('data-id');
                        detailsModal.classList.remove('hidden');
                        
                        // Show loading spinner
                        modalContent.innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-600"></div></div>';
                        
                        // Fetch reservation details
                        fetch(`/provider/reservations/${reservationId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const reservation = data.reservation;
                                    let statusClass = '';
                                    let statusText = '';
                                    
                                    if (reservation.status === 'pending') {
                                        statusClass = 'bg-yellow-100 text-yellow-800';
                                        statusText = 'En attente';
                                    } else if (reservation.status === 'confirmed') {
                                        statusClass = 'bg-green-100 text-green-800';
                                        statusText = 'Confirmée';
                                    } else if (reservation.status === 'cancelled') {
                                        statusClass = 'bg-red-100 text-red-800';
                                        statusText = 'Annulée';
                                    }
                                    
                                    modalContent.innerHTML = `
                                        <div class="space-y-4">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Client</h4>
                                                <p class="mt-1 text-sm text-gray-900">${reservation.user.name}</p>
                                                <p class="mt-1 text-sm text-gray-500">${reservation.user.email}</p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Service</h4>
                                                <p class="mt-1 text-sm text-gray-900">${reservation.service.name}</p>
                                                <p class="mt-1 text-sm text-gray-500">${reservation.service.category || ''}</p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Date et heure</h4>
                                                <p class="mt-1 text-sm text-gray-900">${new Date(reservation.reservation_date).toLocaleDateString('fr-FR')} à ${new Date(reservation.reservation_date).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Statut</h4>
                                                <p class="mt-1">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold ${statusClass}">
                                                        ${statusText}
                                                    </span>
                                                </p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Prix</h4>
                                                <p class="mt-1 text-sm text-gray-900">${reservation.service.price} €</p>
                                            </div>
                                            ${reservation.notes ? `
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                                                <p class="mt-1 text-sm text-gray-900">${reservation.notes}</p>
                                            </div>
                                            ` : ''}
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">Créée le</h4>
                                                <p class="mt-1 text-sm text-gray-900">${new Date(reservation.created_at).toLocaleDateString('fr-FR')} à ${new Date(reservation.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</p>
                                            </div>
                                        </div>
                                        ${reservation.status === 'pending' ? `
                                        <div class="mt-6 flex space-x-3">
                                            <form action="/provider/reservations/${reservation.id}/confirm" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors">
                                                    Confirmer
                                                </button>
                                            </form>
                                            <form action="/provider/reservations/${reservation.id}/cancel" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                                                    Annuler
                                                </button>
                                            </form>
                                        </div>
                                        ` : ''}
                                        ${reservation.status === 'confirmed' ? `
                                        <div class="mt-6">
                                            <form action="/provider/reservations/${reservation.id}/cancel" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                                                    Annuler
                                                </button>
                                            </form>
                                        </div>
                                        ` : ''}
                                    `;
                                } else {
                                    modalContent.innerHTML = '<p class="text-red-500">Erreur lors du chargement des détails de la réservation.</p>';
                                }
                            })
                            .catch(error => {
                                modalContent.innerHTML = '<p class="text-red-500">Erreur lors du chargement des détails de la réservation.</p>';
                                console.error('Error:', error);
                            });
                    });
                });
                
                closeModal.addEventListener('click', function() {
                    detailsModal.classList.add('hidden');
                });
                
                // Close modal when clicking outside
                detailsModal.addEventListener('click', function(e) {
                    if (e.target === detailsModal) {
                        detailsModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
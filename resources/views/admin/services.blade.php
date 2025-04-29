<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion des services - Reservez-Moi">
    <meta name="keywords" content="admin, services, gestion">
    <title>Gestion des Services - Reservez-Moi</title>
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
                <a href="{{ route('admin.services') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-clipboard-list text-blue-300 w-5"></i>
                    <span>Services</span>
                </a>
                <a href="{{ route('admin.statistics') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-chart-bar text-blue-300 w-5"></i>
                    <span>Statistiques</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-blue-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Gestion des Services</h1>
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
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Services</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalServices }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Services actifs</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $activeServices }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Réservations</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalReservations }}</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Revenus générés</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalRevenue }} €</h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Services Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Liste des services</h2>
                </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prestataire</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($services as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $service->category->name ?? 'Non catégorisé' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $service->provider->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $service->provider->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->price }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->duration }} min
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline delete-service-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-900 delete-service-btn" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <div class="py-6">
                                            <p class="text-gray-500 mb-2">Aucun service trouvé</p>
                                            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-plus mr-1"></i> Ajouter un service
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
            
            <!-- Top Services Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Services les plus réservés</h2>
                </div>
                <div id="top-services-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Top services will be loaded here dynamically -->
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
            
            const periodSelector = document.getElementById('period-selector');
            const exportPeriod = document.getElementById('export-period');
            if (periodSelector && exportPeriod) {
                periodSelector.addEventListener('change', function() {
                    exportPeriod.value = this.value;
                });
            }
            
            // SweetAlert2 for delete confirmation
            document.querySelectorAll('.delete-service-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = btn.closest('form');
                    SweetAlertHelper.confirm('deleteItem', function() {
                        form.submit();
                    });
                });
            });
            
            // Fetch and render top services dynamically
            function renderTopServices(services) {
                const container = document.getElementById('top-services-container');
                if (!container) return;
                if (!services.length) {
                    container.innerHTML = '<div class="col-span-3 text-center text-gray-500">Aucun service trouvé</div>';
                    return;
                }
                container.innerHTML = services.map(service => `
                    <div class=\"bg-white rounded-lg shadow p-6\">
                        <div class=\"flex items-center mb-4\">
                            <div class=\"h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mr-4\">
                                <i class=\"fas fa-clipboard-list\"></i>
                            </div>
                            <div>
                                <h3 class=\"text-lg font-semibold text-gray-900\">${service.name}</h3>
                                <p class=\"text-sm text-gray-500\">${service.provider}</p>
                            </div>
                        </div>
                        <div class=\"flex justify-between text-sm\">
                            <div>
                                <p class=\"text-gray-500\">Réservations</p>
                                <p class=\"font-semibold\">${service.reservations}</p>
                            </div>
                            <div>
                                <p class=\"text-gray-500\">Prix</p>
                                <p class=\"font-semibold\">${service.price} €</p>
                            </div>
                            <div>
                                <p class=\"text-gray-500\">Durée</p>
                                <p class=\"font-semibold\">${service.duration} min</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            function fetchTopServices() {
                fetch('/admin/services/top')
                    .then(response => response.json())
                    .then(data => renderTopServices(data))
                    .catch(() => {
                        renderTopServices([]);
                    });
            }

            fetchTopServices();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérer vos services sur Reservez-Moi">
    <meta name="keywords" content="services, prestataire, gestion">
    <title>Mes Services - Reservez-Moi</title>
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
                <a href="{{ route('provider.services') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-list-alt text-primary-300 w-5"></i>
                    <span>Mes services</span>
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
                    <h1 class="text-xl font-bold text-gray-800">Mes services</h1>
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
        
        <!-- Services Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header with Add Button -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Liste de mes services</h2>
                    <p class="mt-1 text-sm text-gray-500">Gérez les services que vous proposez aux clients</p>
                </div>
                <a href="{{ route('provider.services.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors shadow-md hover:shadow-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter un service
                </a>
            </div>
            
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
            
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($services as $service)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition hover:shadow-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-3">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $service->category->name ?? 'Non classé' }}</p>
                                    </div>
                                </div>
                                <div>
                                    @if ($service->is_available)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i> Non disponible
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Catégorie:</span>
                                    <span class="text-sm text-gray-500">{{ $service->category->name ?? 'Non classé' }}</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Prix:</span>
                                    <span class="text-sm text-gray-500">{{ $service->price }} €</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Réservations:</span>
                                    <span class="text-sm text-gray-500">{{ $service->reservations_count ?? '0' }}</span>
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-6">{{ Str::limit($service->description, 100) }}</p>
                            
                            <div class="flex justify-between pt-4 border-t border-gray-200">
                                <a href="{{ route('provider.services.edit', $service->id) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Modifier
                                </a>
                                <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="flex flex-col items-center py-8">
                            <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                <i class="fas fa-clipboard-list text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun service trouvé</h3>
                            <p class="text-gray-500 mb-6">Vous n'avez pas encore créé de services à proposer à vos clients</p>
                            <a href="{{ route('provider.services.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-md font-medium transition-colors shadow-md hover:shadow-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Créer votre premier service
                            </a>
                        </div>
                    </div>
                @endforelse
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
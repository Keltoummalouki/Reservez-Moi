<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez vos disponibilités sur Reservez-Moi">
    <meta name="keywords" content="disponibilités, service provider, réservations">
    <title>Gestion des disponibilités - Reservez-Moi</title>
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
                <a href="{{ isset($service) ? route('provider.availability.index', $service->id) : route('provider.services') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Gestion des disponibilités</h1>
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
        
        <!-- Availability Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Service Selector -->
            <div class="mb-6">
                <label for="service-selector" class="block text-sm font-medium text-gray-700 mb-1">Sélectionnez un service</label>
                <div class="relative">
                    <select id="service-selector" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                        @if(count($services ?? []) > 0)
                            @foreach($services as $serviceOption)
                                <option value="{{ $serviceOption->id }}" {{ isset($service) && $service->id == $serviceOption->id ? 'selected' : '' }}>
                                    {{ $serviceOption->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled selected>Aucun service disponible</option>
                        @endif
                    </select>
                </div>
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
            
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <ul class="text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(isset($service))
                <!-- Availability Tabs -->
                <div class="mb-6 border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <a href="#weekly" class="tab-link border-primary-500 text-primary-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                            Disponibilités hebdomadaires
                        </a>
                        <a href="#specific" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Disponibilités spécifiques
                        </a>
                    </nav>
                </div>
                
                <!-- Weekly Availability Tab Content -->
                <div id="weekly-tab" class="tab-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Disponibilités hebdomadaires</h2>
                        <a href="{{ route('provider.availability.create-weekly', $service->id) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter une disponibilité
                        </a>
                    </div>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @forelse($weeklyAvailabilities ?? [] as $availability)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                                    <i class="fas fa-calendar-day"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        @switch($availability->day_of_week)
                                                            @case(0) Dimanche @break
                                                            @case(1) Lundi @break
                                                            @case(2) Mardi @break
                                                            @case(3) Mercredi @break
                                                            @case(4) Jeudi @break
                                                            @case(5) Vendredi @break
                                                            @case(6) Samedi @break
                                                        @endswitch
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Max: {{ $availability->max_reservations }} réservation(s)
                                                </span>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('provider.availability.edit-weekly', $availability->id) }}" class="text-primary-600 hover:text-primary-900" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('provider.availability.destroy', ['service' => $service->id, 'availability' => $availability->id]) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette disponibilité ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-4 py-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                                            <i class="fas fa-calendar-times text-xl"></i>
                                        </div>
                                        <p>Aucune disponibilité hebdomadaire configurée</p>
                                        <a href="{{ route('provider.availability.create-weekly', $service->id) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                            <i class="fas fa-plus mr-2"></i> Ajouter une disponibilité
                                        </a>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                
                <!-- Specific Availability Tab Content -->
                <div id="specific-tab" class="tab-content hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Disponibilités spécifiques</h2>
                        <a href="{{ route('provider.availability.create-specific', $service->id) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter une disponibilité
                        </a>
                    </div>
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @forelse($specificAvailabilities ?? [] as $availability)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full {{ $availability->is_available ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center">
                                                    <i class="fas {{ $availability->is_available ? 'fa-calendar-check' : 'fa-calendar-times' }}"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($availability->specific_date)->format('d/m/Y') }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                @if($availability->is_available)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Disponible (Max: {{ $availability->max_reservations }})
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Indisponible
                                                    </span>
                                                @endif
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('provider.availability.edit-specific', $availability->id) }}" class="text-primary-600 hover:text-primary-900" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('provider.availability.destroy', ['service' => $service->id, 'availability' => $availability->id]) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette disponibilité ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-4 py-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                                            <i class="fas fa-calendar-times text-xl"></i>
                                        </div>
                                        <p>Aucune disponibilité spécifique configurée</p>
                                        <a href="{{ route('provider.availability.create-specific', $service->id) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                            <i class="fas fa-plus mr-2"></i> Ajouter une disponibilité
                                        </a>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @else
                <!-- No Service Selected Message -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">Veuillez sélectionner un service pour gérer ses disponibilités.</p>
                            @if(count($services ?? []) === 0)
                                <p class="text-sm text-yellow-700 mt-1">Vous n'avez pas encore créé de services. <a href="{{ route('provider.services.create') }}" class="font-medium underline">Créer votre premier service</a>.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
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
            
            // Tab switching
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(tab => {
                        tab.classList.remove('border-primary-500', 'text-primary-600');
                        tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('border-primary-500', 'text-primary-600');
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show the corresponding tab content
                    const tabId = this.getAttribute('href').substring(1);
                    document.getElementById(tabId + '-tab').classList.remove('hidden');
                });
            });
            
            // Service selector change event
            const serviceSelector = document.getElementById('service-selector');
            if (serviceSelector) {
                serviceSelector.addEventListener('change', function() {
                    const serviceId = this.value;
                    if (serviceId) {
                        window.location.href = "/provider/services/" + serviceId + "/availability";
                    }
                });
            }
        });
    </script>
</body>
</html>
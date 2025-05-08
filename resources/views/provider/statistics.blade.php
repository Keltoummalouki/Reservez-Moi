<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Statistiques - Reservez-Moi">
    <meta name="keywords" content="admin, statistiques, analytics">
    <title>Statistiques - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="{{ route('provider.statistics') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-chart-bar text-primary-300 w-5"></i>
                    <span>Statistiques</span>
                </a>
                <a href="{{ route('provider.settings') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Statistiques</h1>
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
            <!-- Filter Controls -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <label for="period-selector" class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                        <select id="period-selector" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="7">7 derniers jours</option>
                            <option value="30" selected>30 derniers jours</option>
                            <option value="90">3 derniers mois</option>
                            <option value="180">6 derniers mois</option>
                            <option value="365">Année en cours</option>
                        </select>
                        <span id="selected-period-label" class="ml-2 text-blue-700 font-semibold"></span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button id="export-btn" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-file-export mr-2"></i> Exporter
                            </button>
                    </div>
                            </div>
                                        </div>
            
            <!-- Loader -->
            <div id="stats-loader" class="flex justify-center items-center py-6" style="display:none;">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Réservations</p>
                            <h3 id="total-reservations" class="text-2xl font-bold text-gray-800 mt-1">{{ $totalReservations ?? 0 }}</h3>
                            </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $reservationsGrowth ?? '0' }}%
                        </span>
                        <span class="text-gray-500">par rapport à la période précédente</span>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Revenus</p>
                            <h3 id="total-revenue" class="text-2xl font-bold text-gray-800 mt-1">{{ $totalRevenue ?? '0' }} €</h3>
                            </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $revenueGrowth ?? '0' }}%
                        </span>
                        <span class="text-gray-500">par rapport à la période précédente</span>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nouveaux Clients</p>
                            <h3 id="new-clients" class="text-2xl font-bold text-gray-800 mt-1">{{ $newClients ?? 0 }}</h3>
                            </div>
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <span class="text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $clientsGrowth ?? '0' }}%
                        </span>
                        <span class="text-gray-500">par rapport à la période précédente</span>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Taux de conversion</p>
                            <h3 id="conversion-rate" class="text-2xl font-bold text-gray-800 mt-1">{{ $conversionRate ?? '0' }}%</h3>
                            </div>
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <span class="{{ ($conversionRateChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                            <i class="fas {{ ($conversionRateChange ?? 0) >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i> {{ abs($conversionRateChange ?? 0) }}%
                        </span>
                        <span class="text-gray-500">par rapport à la période précédente</span>
                    </div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Reservations Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Réservations et revenus</h2>
                    <div class="h-80">
                        <canvas id="reservationsChart"></canvas>
                    </div>
                </div>
                
                <!-- Categories Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Catégories populaires</h2>
                    <div class="h-80">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Top Services Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Services les plus réservés</h2>
                    </div>
                
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenus</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taux de conversion</th>
                                </tr>
                            </thead>
                            <tbody id="top-services-tbody" class="bg-white divide-y divide-gray-200">
                                @php
                                    $maxReservations = $topServices->max('reservations_count');
                                @endphp
                                @forelse($topServices as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->reservations_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->revenue }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                @php
                                                    $percent = $maxReservations > 0 ? min(($service->reservations_count / $maxReservations) * 100, 100) : 0;
                                                @endphp
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500">
                                                {{ $maxReservations > 0 ? round(($service->reservations_count / $maxReservations) * 100) : 0 }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Aucune donnée disponible
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Popular Categories Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Catégories populaires</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($popularCategories ?? [] as $category)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $category['name'] }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $category['count'] }} réservations
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                    </div>
                        <div class="text-right text-sm text-gray-500">
                            {{ $category['percentage'] }}% des réservations
                                    </div>
                                </div>
                            @endforeach
                </div>
            </div>
            
            <!-- Conversion Funnel -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Entonnoir de conversion</h2>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="h-80">
                        <canvas id="funnelChart"></canvas>
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
            
            // Period selector
            const periodSelector = document.getElementById('period-selector');
            const exportPeriod = document.getElementById('export-period');
            const selectedPeriodLabel = document.getElementById('selected-period-label');
            const exportBtn = document.getElementById('export-btn');
            const statsLoader = document.getElementById('stats-loader');

            function setLoading(isLoading) {
                if (isLoading) {
                    statsLoader.style.display = 'flex';
                    if (exportBtn) exportBtn.disabled = true;
                    if (exportBtn) exportBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    statsLoader.style.display = 'none';
                    if (exportBtn) exportBtn.disabled = false;
                    if (exportBtn) exportBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            function updatePeriodLabel() {
                const selectedOption = periodSelector.options[periodSelector.selectedIndex].text;
                selectedPeriodLabel.textContent = selectedOption;
            }

            // Initialisation
            if (periodSelector && exportPeriod && selectedPeriodLabel) {
                exportPeriod.value = periodSelector.value;
                updatePeriodLabel();
                periodSelector.addEventListener('change', function() {
                    exportPeriod.value = this.value;
                    updatePeriodLabel();
                });
            }
            
            // Charts instances (pour update)
            let reservationsChart = null;
            let categoriesChart = null;
            let funnelChart = null;

            // Initialisation des charts (si besoin)
            function initCharts() {
            const reservationsCtx = document.getElementById('reservationsChart');
            if (reservationsCtx) {
                    reservationsChart = new Chart(reservationsCtx, {
                type: 'line',
                data: {
                        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                        datasets: [
                            {
                                label: 'Réservations',
                                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Revenus (€)',
                                    data: [0,0,0,0,0,0,0,0,0,0,0,0],
                                borderColor: 'rgb(16, 185, 129)',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Réservations'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Revenus (€)'
                                }
                            }
                        }
                    }
                });
            }
            const categoriesCtx = document.getElementById('categoriesChart');
            if (categoriesCtx) {
                    categoriesChart = new Chart(categoriesCtx, {
                    type: 'doughnut',
                    data: {
                            labels: [],
                    datasets: [{
                                data: [],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
            const funnelCtx = document.getElementById('funnelChart');
            if (funnelCtx) {
                    funnelChart = new Chart(funnelCtx, {
                type: 'bar',
                data: {
                        labels: ['Visites', 'Recherches', 'Vues de services', 'Tentatives de réservation', 'Réservations complétées'],
                    datasets: [{
                                label: "Nombre d'utilisateurs",
                                data: [0,0,0,0,0],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(59, 130, 246, 0.6)',
                                'rgba(59, 130, 246, 0.5)',
                                'rgba(59, 130, 246, 0.4)'
                            ],
                            borderColor: [
                                'rgb(59, 130, 246)',
                                'rgb(59, 130, 246)',
                                'rgb(59, 130, 246)',
                                'rgb(59, 130, 246)',
                                'rgb(59, 130, 246)'
                            ],
                            borderWidth: 1
                    }]
                },
                options: {
                        indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            }

            // Met à jour les données des charts
            function updateCharts(data) {
                if (reservationsChart) {
                    // À adapter si tu veux des vraies données par mois
                    reservationsChart.data.datasets[0].data = [data.totalReservations];
                    reservationsChart.data.datasets[1].data = [data.totalRevenue];
                    reservationsChart.update();
                }
                if (categoriesChart) {
                    categoriesChart.data.labels = data.popularCategories.map(c => c.name);
                    categoriesChart.data.datasets[0].data = data.popularCategories.map(c => c.percentage);
                    categoriesChart.update();
                }
                // funnelChart: à adapter si tu veux des vraies données
            }

            function fetchStats(period) {
                setLoading(true);
                fetch(`{{ route('provider.statistics.ajax') }}?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        // Met à jour les cards
                        document.getElementById('total-reservations').textContent = data.totalReservations;
                        document.getElementById('total-revenue').textContent = data.totalRevenue + ' €';
                        document.getElementById('new-clients').textContent = data.newClients;
                        document.getElementById('conversion-rate').textContent = data.conversionRate + '%';
                        // ... mets à jour les autres stats

                        // Met à jour le tableau des top services
                        let tbody = '';
                        data.topServices.forEach(service => {
                            tbody += `<tr>
                                <td>${service.name}</td>
                                <td>${service.reservations}</td>
                                <td>${service.revenue} €</td>
                                <td><!-- taux de conversion ou autre --></td>
                            </tr>`;
                        });
                        document.getElementById('top-services-tbody').innerHTML = tbody;

                        // Met à jour les graphiques (exemple Chart.js)
                        updateCharts(data);
                    })
                    .finally(() => setLoading(false));
            }

            // Initialisation
            initCharts();
            updatePeriodLabel();
            periodSelector.addEventListener('change', function() {
                updatePeriodLabel();
                fetchStats(this.value);
            });
        });
    </script>
</body>
</html> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez les réservations de vos services sur Reservez-Moi.">
    <meta name="keywords" content="réservations, service provider, plateforme">
    <title>Réservations - Reservez-Moi</title>
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
                <a href="{{ route('provider.reservations') }}" class="sidebar-item active flex items-center space-x-3 p-3 rounded-md hover:bg-primary-700 transition-colors">
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
                    <h1 class="text-xl font-bold text-gray-800">Réservations</h1>
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
        
        <!-- Reservations Content -->
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Filter and Search -->
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-48">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="all">Tous les statuts</option>
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmées</option>
                            <option value="cancelled">Annulées</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-48">
                        <label for="service-filter" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                        <select id="service-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="all">Tous les services</option>
                            @foreach($providerServices ?? [] as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="w-full md:w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Nom du client...">
                    </div>
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
            
            <!-- Reservations List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Heure</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reservations as $reservation)
                                <tr class="hover:bg-gray-50" data-service="{{ $reservation->service->id ?? '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($reservation->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name ?? 'Client inconnu' }}</div>
                                                <div class="text-sm text-gray-500">{{ $reservation->user->email ?? 'Email inconnu' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->service->name ?? 'Service inconnu' }}</div>
                                        <div class="text-xs text-gray-500">{{ $reservation->service->category ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->reservation_date ? $reservation->reservation_date->format('d/m/Y') : 'Date inconnue' }}</div>
                                        <div class="text-sm text-gray-500">{{ $reservation->reservation_date ? $reservation->reservation_date->format('H:i') : '' }}</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->service->price ?? '0' }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
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
                                                <form action="{{ route('provider.reservations.cancel', $reservation->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Annuler" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button class="text-primary-600 hover:text-primary-900 view-details" data-id="{{ $reservation->id }}" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center py-6">
                                            <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                                                <i class="fas fa-calendar-times text-xl"></i>
                                            </div>
                                            <p>Aucune réservation trouvée</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $reservations->links() }}
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
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
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
            
            // Filter functionality
            const statusFilter = document.getElementById('status-filter');
            const serviceFilter = document.getElementById('service-filter');
            const searchInput = document.getElementById('search');
            
            function applyFilters() {
                const status = statusFilter.value;
                const serviceId = serviceFilter.value;
                const searchTerm = searchInput.value.toLowerCase();
                
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    let showRow = true;
                    
                    // Status filter
                    if (status !== 'all') {
                        const statusCell = row.querySelector('td:nth-child(4) span');
                        if (statusCell) {
                            const rowStatus = statusCell.textContent.trim().toLowerCase();
                            if (status === 'pending' && rowStatus !== 'en attente') showRow = false;
                            if (status === 'confirmed' && rowStatus !== 'confirmée') showRow = false;
                            if (status === 'cancelled' && rowStatus !== 'annulée') showRow = false;
                        }
                    }
                    // Service filter
                    if (serviceId !== 'all' && showRow) {
                        const rowServiceId = row.getAttribute('data-service');
                        if (rowServiceId !== serviceId) {
                            showRow = false;
                        }
                    }
                    
                    // Search filter
                    if (searchTerm && showRow) {
                        const clientNameCell = row.querySelector('td:nth-child(1) .text-sm.font-medium');
                        if (clientNameCell) {
                            const clientName = clientNameCell.textContent.toLowerCase();
                            if (!clientName.includes(searchTerm)) showRow = false;
                        }
                    }
                    
                    // Show or hide row
                    row.classList.toggle('hidden', !showRow);
                });
            }
            
            statusFilter.addEventListener('change', applyFilters);
            serviceFilter.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);
        });
    </script>
</body>
</html>
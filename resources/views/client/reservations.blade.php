<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consultez vos réservations sur Reservez-Moi.">
    <meta name="keywords" content="réservations, client, plateforme">
    <title>Mes Réservations - Reservez-Moi</title>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .header-scrolled {
            @apply shadow-md bg-white/95 backdrop-blur-sm;
        }
        
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }
        
        .ripple:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }
        
        .glow-on-hover:hover {
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header/Navigation -->
    <header id="main-header" class="fixed top-0 z-50 w-full transition-all duration-300 bg-white">
        <div class="container mx-auto flex h-20 items-center justify-between px-4 md:px-6">
            <div class="flex items-center gap-2">
                <div class="bg-primary-600 text-white p-2 rounded-lg shadow-md">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
                <a href="{{ url('/') }}" class="text-xl font-bold">Reservez-<span class="text-primary-600">moi</span></a>
            </div>
            <nav class="hidden md:flex gap-6">
                <a href="{{ url('/#how-it-works') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Comment ça marche</a>
                <a href="{{ route('client.services') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Services</a>
                <a href="{{ route('client.reservations') }}" class="text-sm font-medium text-primary-600 transition-colors">Mes Réservations</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="text-sm font-medium hover:text-primary-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </button>
                </form>
                <button id="mobile-menu-button" class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed inset-0 z-50 bg-white md:hidden">
            <div class="flex h-20 items-center justify-between border-b px-4">
                <div class="flex items-center gap-2">
                    <div class="bg-primary-600 text-white p-2 rounded-lg">
                        <i class="fas fa-calendar text-xl"></i>
                    </div>
                    <span class="text-xl font-bold">Reservez-<span class="text-primary-600">moi</span></span>
                </div>
                <button id="close-menu-button" class="text-gray-500">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="flex flex-col p-4">
                <a href="{{ url('/#how-it-works') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Comment ça marche</a>
                <a href="{{ route('client.services') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Services</a>
                <a href="{{ route('client.reservations') }}" class="border-b border-gray-100 py-4 text-lg font-medium text-primary-600 transition-colors mobile-link">Mes Réservations</a>
                <a href="{{ url('/#faq') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">FAQ</a>
                <div class="mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center rounded-md bg-primary-600 py-3 font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors ripple">
                            <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <!-- Page Header -->
        <section class="relative bg-gradient-to-r from-primary-600 to-primary-800 py-16 md:py-20 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
            </div>
            
            <div class="container mx-auto px-4 md:px-6 relative">
                <div class="max-w-4xl mx-auto text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-4" data-aos="fade-up">Mes Réservations</h1>
                    <p class="text-lg md:text-xl text-white/90 mb-8" data-aos="fade-up" data-aos-delay="100">
                        Suivez et gérez toutes vos réservations en un seul endroit
                    </p>
                </div>
            </div>
        </section>

        <!-- Reservations Section -->
        <section class="py-12">
            <div class="container mx-auto px-4 md:px-6">
                <!-- Messages de succès ou d'erreur -->
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" data-aos="fade-up">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" data-aos="fade-up">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Filtres et recherche -->
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4">
                    <div class="flex-1 mb-2 md:mb-0">
                        <input type="text" id="search-input" placeholder="Rechercher un service, un prestataire..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    </div>
                    <div class="mb-2 md:mb-0">
                        <select id="status-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Tous les statuts</option>
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmé</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                    </div>
                    <div>
                        <input type="date" id="date-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    </div>
                </div>
                <!-- Loader -->
                <div id="reservations-loader" class="w-full flex justify-center py-6 hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
                </div>
                <!-- Liste des réservations -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Vos réservations</h2>
                        <p class="text-gray-600 mt-1">Consultez l'historique et le statut de vos réservations</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reservations-tbody" class="bg-white divide-y divide-gray-200">
                                @forelse($reservations as $reservation)
                                {{-- Le contenu initial sera remplacé dynamiquement --}}
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div id="reservations-pagination" class="px-6 py-4 border-t border-gray-200"></div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white">
        <div class="container mx-auto flex flex-col gap-8 py-12 px-4 md:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                <div class="flex flex-col gap-4">
                    <h3 class="text-lg font-bold">Reservez-moi</h3>
                    <div class="flex items-center gap-2">
                        <div class="bg-primary-600 text-white p-2 rounded-lg">
                            <i class="fas fa-calendar text-sm"></i>
                        </div>
                        <span class="text-sm font-medium">Reservez-<span class="text-primary-600">moi</span></span>
                    </div>
                    <p class="text-sm text-gray-500">
                        La plateforme de réservation multi-secteurs qui simplifie votre quotidien
                    </p>
                    <div class="flex gap-4 pt-2">
                        <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-bold">Liens utiles</h3>
                    <nav class="flex flex-col gap-2">
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Comment ça marche
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Nos services
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            FAQ
                        </a>
                    </nav>
                </div>
                
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-bold">Support</h3>
                    <nav class="flex flex-col gap-2">
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Centre d'aide
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Contact
                        </a>
                    </nav>
                </div>
                
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-bold">Légal</h3>
                    <nav class="flex flex-col gap-2">
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Conditions d'utilisation
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Politique de confidentialité
                        </a>
                    </nav>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-t pt-8">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Reservez-moi. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-primary-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-primary-700 transition-colors z-50 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('close-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileLinks = document.querySelectorAll('.mobile-link');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            closeMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
            
            // Header scroll effect
            const header = document.getElementById('main-header');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            });
            
            // Back to top button
            const backToTopButton = document.getElementById('back-to-top');
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Recherche et filtrage dynamique des réservations
            const searchInput = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const tbody = document.getElementById('reservations-tbody');
            const loader = document.getElementById('reservations-loader');
            const pagination = document.getElementById('reservations-pagination');

            function renderReservations(reservations) {
                if (reservations.data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        <div class='flex flex-col items-center'>
                            <div class='bg-gray-100 rounded-full p-4 mb-4'><i class='fas fa-calendar-day text-3xl text-gray-400'></i></div>
                            <p class='text-lg font-medium mb-2'>Aucune réservation trouvée</p>
                            <p class='text-gray-500 mb-6'>Vous n'avez pas encore effectué de réservation</p>
                            <a href='{{ route('client.services') }}' class='bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md shadow-md inline-flex items-center'><i class='fas fa-search mr-2'></i> Découvrir des services</a>
                        </div>
                    </td></tr>`;
                    pagination.innerHTML = '';
                    return;
                }
                tbody.innerHTML = reservations.data.map(reservation => {
                    let statusLabel = '';
                    if (reservation.status === 'pending') {
                        statusLabel = `<span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800'>En attente</span>`;
                    } else if (reservation.status === 'confirmed') {
                        statusLabel = `<span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'>Confirmé</span>`;
                    } else if (reservation.status === 'cancelled') {
                        statusLabel = `<span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'>Annulé</span>`;
                    } else {
                        statusLabel = reservation.status;
                    }
                    let paymentLabel = '';
                    if (reservation.payment_status === 'completed') {
                        paymentLabel = `<span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'><i class='fas fa-check-circle mr-1'></i> Payé</span>`;
                    } else {
                        paymentLabel = `<span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800'><i class='fas fa-clock mr-1'></i> En attente</span>`;
                    }
                    let actions = '';
                    if (reservation.payment_status === 'pending') {
                        actions = `<a href='/client/reservations/${reservation.id}/paypal' class='bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm inline-flex items-center ripple'><i class='fab fa-paypal mr-2'></i> Payer</a>`;
                    } else if (reservation.status === 'pending' || reservation.status === 'confirmed') {
                        actions = `<form action='/client/reservations/${reservation.id}/cancel' method='POST' class='inline'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='PUT'>
                            <button type='submit' class='text-red-600 hover:text-red-800 font-medium flex items-center' onclick='return confirm("Êtes-vous sûr de vouloir annuler cette réservation?")'>
                                <i class='fas fa-times-circle mr-1'></i> Annuler
                            </button>
                        </form>`;
                    }
                    return `<tr class='hover:bg-gray-50 transition-colors'>
                        <td class='px-6 py-4 whitespace-nowrap'>
                            <div class='flex items-center'>
                                <div class='flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600'>
                                    <i class='fas fa-bookmark'></i>
                                </div>
                                <div class='ml-4'>
                                    <div class='text-sm font-medium text-gray-900'>${reservation.service ? reservation.service.name : 'Service indisponible'}</div>
                                    <div class='text-sm text-gray-500'>${reservation.service && reservation.service.provider ? reservation.service.provider.name : ''}</div>
                                </div>
                            </div>
                        </td>
                        <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700'>${reservation.reservation_date ? new Date(reservation.reservation_date).toLocaleString('fr-FR') : 'N/A'}</td>
                        <td class='px-6 py-4 whitespace-nowrap'>${statusLabel}</td>
                        <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700'><div class='flex items-center'><i class='fas fa-euro-sign mr-1 text-gray-500'></i> ${reservation.amount}</div></td>
                        <td class='px-6 py-4 whitespace-nowrap'>${paymentLabel}</td>
                        <td class='px-6 py-4 whitespace-nowrap text-sm font-medium'>${actions}</td>
                    </tr>`;
                }).join('');
                // Pagination
                let pag = '';
                if (reservations.links && reservations.links.length > 3) {
                    pag += `<nav class='flex justify-center'>`;
                    reservations.links.forEach(link => {
                        if (link.url) {
                            pag += `<a href='#' class='mx-1 px-3 py-1 rounded-md ${link.active ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-primary-100'}' data-url='${link.url}'>${link.label.replace('Previous', '«').replace('Next', '»')}</a>`;
                        } else {
                            pag += `<span class='mx-1 px-3 py-1 rounded-md bg-gray-50 text-gray-400'>${link.label.replace('Previous', '«').replace('Next', '»')}</span>`;
                        }
                    });
                    pag += `</nav>`;
                }
                pagination.innerHTML = pag;
            }

            function fetchReservations(url = null) {
                loader.classList.remove('hidden');
                tbody.innerHTML = '';
                let params = new URLSearchParams();
                if (searchInput.value) params.append('search', searchInput.value);
                if (statusFilter.value) params.append('status', statusFilter.value);
                if (dateFilter.value) params.append('date', dateFilter.value);
                let fetchUrl = url || `{{ route('client.reservations.ajax') }}?${params.toString()}`;
                fetch(fetchUrl, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(res => res.json())
                    .then(data => {
                        renderReservations(data.reservations);
                    })
                    .catch(() => {
                        tbody.innerHTML = `<tr><td colspan='6' class='text-center text-red-500 py-6'>Erreur lors du chargement des réservations.</td></tr>`;
                        pagination.innerHTML = '';
                    })
                    .finally(() => {
                        loader.classList.add('hidden');
                    });
            }

            searchInput.addEventListener('input', () => fetchReservations());
            statusFilter.addEventListener('change', () => fetchReservations());
            dateFilter.addEventListener('change', () => fetchReservations());
            pagination.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' && e.target.dataset.url) {
                    e.preventDefault();
                    fetchReservations(e.target.dataset.url);
                }
            });
            // Chargement initial
            fetchReservations();
        });
    </script>
</body>
</html>
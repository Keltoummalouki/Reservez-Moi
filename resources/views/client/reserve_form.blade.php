<!-- resources/views/client/reserve_form.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réservez un service sur Reservez-Moi.">
    <meta name="keywords" content="réservation, service, plateforme">
    <title>Réserver un Service - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #2563eb, #60a5fa);
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
        
        .date-slot {
            @apply cursor-pointer border border-gray-300 rounded-md p-4 transition-all duration-300;
        }
        
        .date-slot:hover {
            @apply border-primary-300 bg-primary-50;
        }
        
        .date-slot.selected {
            @apply border-primary-600 bg-primary-50 ring-2 ring-primary-600 ring-opacity-50;
        }
        
        .time-slot {
            cursor: pointer;
            border: 2px solid #e5e7eb; /* gray-300 */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 1rem 0;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            font-weight: 500;
            background: #fff;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,0.04);
            transition: all 0.2s;
            text-align: center;
            user-select: none;
        }
        .time-slot:hover {
            border-color: #2563eb; /* primary-600 */
            background: #eff6ff; /* primary-50 */
            color: #2563eb;
            box-shadow: 0 2px 8px 0 rgba(37,99,235,0.08);
        }
        .time-slot.selected {
            border-color: #2563eb;
            background: #2563eb;
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 16px 0 rgba(37,99,235,0.12);
            transform: scale(1.04);
        }
        @media (max-width: 640px) {
            .time-slot {
                font-size: 1rem;
                padding: 0.75rem 0;
            }
        }
        
        .time-slot.disabled {
            @apply cursor-not-allowed bg-gray-100 text-gray-400;
        }
        
        #custom-time-menu {
            min-width: 180px;
        }
        .custom-time-option {
            background: #fff;
            color: #222;
            border: 2px solid transparent;
        }
        .custom-time-option.selected,
        .custom-time-option:focus,
        .custom-time-option:hover {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
            outline: none;
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
                <a href="{{ route('client.reservations') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Mes Réservations</a>
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
                <a href="{{ route('client.reservations') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Mes Réservations</a>
                <div class="mt-6 flex flex-col gap-3">
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
        <!-- Hero Banner -->
        <section class="relative bg-gradient-to-r from-primary-600 to-primary-800 py-12 md:py-16 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
            </div>
            
            <div class="container mx-auto px-4 md:px-6 relative">
                <div class="max-w-4xl mx-auto text-center text-white">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3" data-aos="fade-up">Réserver un Service</h1>
                    <p class="text-lg text-white/90 mb-0" data-aos="fade-up" data-aos-delay="100">
                        {{ $service->name }} - {{ $service->price }} €
                    </p>
                </div>
            </div>
        </section>

        <!-- Reservation Form Section -->
        <section class="py-12">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up">
                        <div class="p-6 md:p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $service->name }}</h2>
                                    <p class="text-gray-600">Par {{ $service->provider->name }}</p>
                                </div>
                                <div class="bg-primary-50 text-primary-700 px-4 py-2 rounded-lg font-bold">
                                    {{ $service->price }} €
                                </div>
                            </div>

                            @if ($service->description)
                                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold mb-2">Description du service</h3>
                                    <p class="text-gray-700">{{ $service->description }}</p>
                                </div>
                            @endif

                            <!-- Messages d'erreur -->
                            @if (session('error'))
                                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                                    <p class="font-medium">{{ session('error') }}</p>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                                    <p class="font-medium">Veuillez corriger les erreurs suivantes :</p>
                                    <ul class="mt-1 ml-4 list-disc">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Reservation Form -->
                            <form id="reservation-form" class="space-y-6" action="{{ route('client.reserve', $service->id) }}" method="POST">
                                @csrf
                                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4">
                                    <div class="flex-1">
                                        <label for="date-picker" class="block text-sm font-semibold mb-1">1. Choisissez une date</label>
                                        <input type="date" id="date-picker" class="border rounded p-2 w-full" min="{{ now()->toDateString() }}">
                                    </div>
                                    <div class="flex-1 mt-4 sm:mt-0">
                                        <label class="block text-sm font-semibold mb-1">2. Choisissez un horaire</label>
                                        <button type="button" id="custom-time-btn" class="border rounded p-2 w-full text-left bg-white">--:--</button>
                                        <div id="custom-time-menu" class="hidden absolute z-50 bg-white border rounded shadow-lg mt-2 w-48">
                                            <div class="grid grid-cols-2 gap-2 p-2 max-h-64 overflow-y-auto">
                                                @php
                                                    $start = \Carbon\Carbon::createFromTime(8, 0);
                                                    $end = \Carbon\Carbon::createFromTime(0, 0)->addDay();
                                                @endphp
                                                @for ($time = $start->copy(); $time <= $end; $time->addMinutes(30))
                                                    <button type="button" class="custom-time-option rounded text-lg font-semibold py-2 transition" data-value="{{ $time->format('H:i') }}">
                                                        {{ $time->format('H:i') }}
                                                    </button>
                                                @endfor
                                            </div>
                                        </div>
                                        <input type="hidden" name="reservation_time" id="reservation_time">
                                    </div>
                                </div>

                                <div id="submit-container" class="hidden pt-4">
                                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg ripple">
                                        Confirmer la Réservation
                                    </button>
                                    <p class="text-sm text-gray-500 text-center mt-4">
                                        En confirmant cette réservation, vous acceptez nos 
                                        <a href="#" class="text-primary-600 hover:text-primary-700">conditions d'utilisation</a>
                                    </p>
                                </div>
                            </form>

                            <div class="mt-6 pt-6 border-t">
                                <a href="{{ route('client.services') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700">
                                    <i class="fas fa-arrow-left mr-2"></i> Retour aux services
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="calendar"></div>
        <div id="time-slots-container"></div>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white">
        <div class="container mx-auto flex flex-col gap-8 py-12 px-4 md:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="bg-primary-600 text-white p-2 rounded-lg">
                        <i class="fas fa-calendar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Reservez-<span class="text-primary-600">moi</span></span>
                </div>
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Reservez-Moi. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-primary-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-primary-700 transition-colors z-50 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Loading Indicator -->
    <div id="loading-indicator" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white p-5 rounded-lg shadow-lg flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-800 font-medium">Chargement...</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            
            if (mobileMenuButton && closeMenuButton && mobileMenu) {
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
            }
            
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
            
            // Date and time selection
            const datePicker = document.getElementById('date-picker');
            const customTimeBtn = document.getElementById('custom-time-btn');
            const customTimeMenu = document.getElementById('custom-time-menu');
            const reservationTimeInput = document.getElementById('reservation_time');
            const submitContainer = document.getElementById('submit-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            
            datePicker.addEventListener('change', function() {
                customTimeMenu.classList.add('hidden');
                submitContainer.classList.add('hidden');
            });
            
            customTimeBtn.addEventListener('click', function() {
                customTimeMenu.classList.toggle('hidden');
            });
            
            document.querySelectorAll('.custom-time-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.custom-time-option').forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                    customTimeBtn.textContent = this.textContent;
                    reservationTimeInput.value = this.getAttribute('data-value');
                    customTimeMenu.classList.add('hidden');
                    // Affiche le bouton de soumission si la date est choisie
                    if (datePicker.value && reservationTimeInput.value) {
                        submitContainer.classList.remove('hidden');
                    }
                });
            });
            
            // Fermer le menu si on clique ailleurs
            document.addEventListener('click', function(e) {
                if (!customTimeBtn.contains(e.target) && !customTimeMenu.contains(e.target)) {
                    customTimeMenu.classList.add('hidden');
                }
            });
            
            // Preselect date and time if passed in URL
            const urlParams = new URLSearchParams(window.location.search);
            const preselectedDate = urlParams.get('date');
            const preselectedTime = urlParams.get('time');
            
            if (preselectedDate) {
                const dateSlot = document.querySelector(`.date-slot[data-date="${preselectedDate}"]`);
                if (dateSlot) {
                    dateSlot.click();
                    
                    // If there's also a preselected time, we need to wait for the time slots to load
                    if (preselectedTime) {
                        const checkForTimeSlots = setInterval(() => {
                            const timeSlot = document.querySelector(`.time-slot[data-value="${preselectedDate} ${preselectedTime}"]`);
                            if (timeSlot) {
                                timeSlot.click();
                                clearInterval(checkForTimeSlots);
                            }
                        }, 100);
                        
                        // Clear the interval after 5 seconds to prevent infinite checking
                        setTimeout(() => clearInterval(checkForTimeSlots), 5000);
                    }
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    // Génère les créneaux horaires X:00 et X:30 pour la date sélectionnée
                    const slots = generateTimeSlots(info.dateStr);
                    // Affiche les créneaux dans une modal ou une section dédiée
                    displayTimeSlots(slots, info.dateStr);
                },
                events: '/api/indisponibilites?service_id=XX', // Récupère les indisponibilités pour griser les jours
            });
            calendar.render();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date-picker');
            const timeInput = document.getElementById('time-picker');
            const reserveBtn = document.getElementById('reserve-btn');
            function toggleReserveBtn() {
                reserveBtn.disabled = !(dateInput.value && timeInput.value);
            }
            if (dateInput && timeInput && reserveBtn) {
                dateInput.addEventListener('input', toggleReserveBtn);
                timeInput.addEventListener('input', toggleReserveBtn);
            }
        });
    </script>
</body>
</html>
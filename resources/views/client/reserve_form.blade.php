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
                        Confirmez les détails de votre réservation
                    </p>
                </div>
            </div>
        </section>

        <!-- Reservation Form Section -->
        <section class="py-12">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-2xl mx-auto">
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

                            <!-- Messages d'erreur -->
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
                            <form class="space-y-6" action="{{ route('client.reserve', $service->id) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="reservation_date" class="block text-sm font-medium text-gray-700">Date et Heure de Réservation</label>
                                    <div class="mt-1 relative">
                                        <input 
                                            id="reservation_date" 
                                            name="reservation_date" 
                                            type="datetime-local" 
                                            required 
                                            value="{{ old('reservation_date') }}" 
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent shadow-sm text-gray-900 transition-all duration-300"
                                        >
                                        <i class="fas fa-calendar-alt absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('reservation_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes ou instructions spéciales (facultatif)</label>
                                    <div class="mt-1">
                                        <textarea 
                                            id="notes" 
                                            name="notes" 
                                            rows="3" 
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent shadow-sm text-gray-900 transition-all duration-300" 
                                            placeholder="Ajoutez des notes ou demandes spéciales pour votre réservation..."
                                        >{{ old('notes') }}</textarea>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-6 rounded-xl space-y-3">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-medium text-gray-700">Détails du service :</h3>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Catégorie</span>
                                        <span class="font-medium">{{ $service->category ?: 'Non spécifié' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Prix</span>
                                        <span class="font-medium">{{ $service->price }} €</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Prestataire</span>
                                        <span class="font-medium">{{ $service->provider->name }}</span>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg ripple">
                                        Confirmer la Réservation
                                    </button>
                                    <p class="text-sm text-gray-500 text-center mt-4">
                                        En confirmant cette réservation, vous acceptez nos 
                                        <a href="#" class="text-primary-600 hover:text-primary-700">conditions d'utilisation</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        });
    </script>
</body>
</html>
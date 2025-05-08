<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez et réservez des services professionnels sur Reservez-moi">
    <title>Services | Reservez-moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
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
        
        .filter-pill {
            @apply px-4 py-2 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 transition-colors;
        }
        
        .filter-pill.active {
            @apply bg-primary-600 text-white;
        }
        
        .service-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        }
        
        .badge-new {
            background-color: #10b981;
            color: white;
        }
        
        .badge-popular {
            background-color: #f59e0b;
            color: white;
        }
        
        .badge-promo {
            background-color: #ef4444;
            color: white;
        }
        
        .stars-container {
            display: inline-block;
            position: relative;
        }
        
        .stars-bg {
            color: #e2e8f0;
        }
        
        .stars-fg {
            color: #f59e0b;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            white-space: nowrap;
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
                <a href="{{ route('client.services') }}" class="text-sm font-medium text-primary-600 transition-colors">Services</a>
                <a href="{{ url('/#features') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">Se connecter</a>
                    <a href="{{ route('register') }}" class="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors shadow-md hover:shadow-lg glow-on-hover ripple">S'inscrire</a>
                @else
                    <a href="{{ route('client.services') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">
                        <i class="fas fa-user-circle mr-1"></i> Mon compte
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                        @csrf
                        <button type="submit" class="text-sm font-medium hover:text-primary-600 transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                        </button>
                    </form>
                @endguest
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
                <a href="{{ route('client.services') }}" class="border-b border-gray-100 py-4 text-lg font-medium text-primary-600 transition-colors mobile-link">Services</a>
                <a href="{{ url('/#features') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">FAQ</a>
                <div class="mt-6 flex flex-col gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-center py-3 text-primary-600 font-medium border border-primary-600 rounded-md hover:bg-primary-50 transition-colors">Se connecter</a>
                        <a href="{{ route('register') }}" class="text-center rounded-md bg-primary-600 py-3 font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors ripple">S'inscrire</a>
                    @else
                        <a href="{{ route('client.services') }}" class="text-center py-3 text-primary-600 font-medium border border-primary-600 rounded-md hover:bg-primary-50 transition-colors">
                            <i class="fas fa-user-circle mr-1"></i> Mon compte
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center rounded-md bg-primary-600 py-3 font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors ripple">
                                <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                            </button>
                        </form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <!-- Hero Banner -->
        <section class="relative bg-gradient-to-r from-primary-600 to-primary-800 py-16 md:py-20 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
            </div>
            
            <div class="container mx-auto px-4 md:px-6 relative">
                <div class="max-w-4xl mx-auto text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-4" data-aos="fade-up">Découvrez tous nos services</h1>
                    <p class="text-lg md:text-xl text-white/90 mb-8" data-aos="fade-up" data-aos-delay="100">
                        Trouvez et réservez le service parfait parmi notre large sélection de prestataires qualifiés
                    </p>
                    
                    <!-- Search Bar -->
                    <form action="{{ route('client.services') }}" method="GET" class="bg-white rounded-lg shadow-xl p-2 md:p-3 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="relative flex-grow">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Rechercher un service..." 
                                    class="w-full pl-10 pr-4 py-3 rounded-md border-0 focus:ring-2 focus:ring-primary-500"
                                >
                            </div>
                            <div class="relative md:w-48">
                                <select name="category" class="w-full py-3 px-4 rounded-md border-0 focus:ring-2 focus:ring-primary-500 appearance-none bg-white">
                                    <option value="" selected>Tous les secteurs</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-md px-6 py-3 font-medium transition-colors shadow-md hover:shadow-lg ripple">
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Category Pills -->
        <section class="py-8 bg-white border-b">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-wrap justify-center gap-3" data-aos="fade-up">
                    <a href="{{ route('client.services') }}" class="filter-pill {{ !request('category') ? 'active' : '' }}">
                        Tous les services
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('client.services', ['category' => $category->id]) }}" class="filter-pill {{ request('category') == $category->id ? 'active' : '' }}">
                        @if($category->name == 'Doctors & Hospitals')
                            <i class="fas fa-stethoscope mr-1"></i>
                        @elseif($category->name == 'Services juridiques')
                            <i class="fas fa-gavel mr-1"></i>
                        @elseif($category->name == 'Beauty Salon & Spas')
                            <i class="fas fa-spa mr-1"></i>
                        @elseif($category->name == 'Hotel')
                            <i class="fas fa-hotel mr-1"></i>
                        @elseif($category->name == 'Restaurant')
                            <i class="fas fa-utensils mr-1"></i>
                        @else
                            <i class="fas fa-tag mr-1"></i>
                        @endif
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Sidebar Filters -->
                    <div class="lg:w-1/4">
                        <div class="bg-white rounded-xl shadow-md p-6 sticky top-24" data-aos="fade-right">
                            <h3 class="text-lg font-bold mb-6">Filtres</h3>
                            
                            <!-- Price Range -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold mb-3">Fourchette de prix</h4>
                                <form action="{{ route('client.services') }}" method="GET" id="price-filter-form">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input 
                                        type="range" 
                                        min="0" 
                                        max="500" 
                                        value="{{ request('max_price', 200) }}" 
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
                                        id="priceRange" 
                                        name="max_price"
                                        oninput="updatePriceValue(this.value)"
                                    >
                                    <div class="flex justify-between text-sm text-gray-600 mt-2">
                                        <span>0 €</span>
                                        <span id="priceValue">{{ request('max_price', 200) }} €</span>
                                        <span>500 €</span>
                                    </div>
                                    <button type="submit" class="mt-3 w-full bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 text-sm font-medium transition-colors">
                                        Appliquer
                                    </button>
                                </form>
                            </div>
                            
                            <div class="border-t border-gray-200 my-6 pt-6">
                                <a href="{{ route('client.services') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center">
                                    <i class="fas fa-redo-alt mr-2"></i> Réinitialiser tous les filtres
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Services Grid -->
                    <div class="lg:w-3/4">
                        <!-- Results Count -->
                        <div class="mb-6 bg-white rounded-lg shadow-sm p-4" data-aos="fade-up">
                            <div class="flex flex-col sm:flex-row justify-between items-center">
                                <p class="text-gray-600 mb-4 sm:mb-0">
                                    Affichage de <span class="font-semibold">{{ $services->count() }}</span> 
                                    services sur <span class="font-semibold">{{ $services->total() }}</span>
                                </p>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-600 mr-2">Trier par:</span>
                                    <select class="rounded-md border border-gray-200 py-1.5 px-3 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                                        <option value="recommended">Recommandés</option>
                                        <option value="price-low">Prix: croissant</option>
                                        <option value="price-high">Prix: décroissant</option>
                                        <option value="newest">Plus récents</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Services Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="services-list">
                            @include('client.partials.services_list', ['services' => $services])
                                        </div>
                        <div id="services-loader" class="w-full flex justify-center py-6 hidden">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
                        </div>
                        <div id="services-pagination" class="flex justify-center mt-12" data-aos="fade-up">
                        @if($services->hasPages())
                            {{ $services->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Featured Services -->
        @if($services->count() > 0)
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center max-w-3xl mx-auto mb-12" data-aos="fade-up">
                    <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">Recommandations</span>
                    <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl mb-4">
                        Services <span class="text-gradient">recommandés pour vous</span>
                    </h2>
                    <p class="text-gray-600 text-lg">
                        Basés sur vos préférences et votre historique de réservations
                    </p>
                </div>
                
                <div class="swiper featured-services-swiper overflow-visible" data-aos="fade-up">
                    <div class="swiper-wrapper pb-8">
                        @foreach($services->take(4) as $service)
                        <div class="swiper-slide">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg h-full">
                                <div class="relative">
                                    @if($service->photos->where('is_primary', true)->first())
                                        <img src="{{ asset('storage/service-photos/' . $service->photos->where('is_primary', true)->first()->filename) }}" 
                                             alt="{{ $service->name }}" 
                                             class="w-full h-48 object-cover">
                                    @else
                                        <img src="{{ asset('images/default-service.jpg') }}" 
                                             alt="{{ $service->name }}" 
                                             class="w-full h-48 object-cover">
                                    @endif
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                        <div class="flex items-center text-white">
                                            @if($service->category)
                                                @if($service->category->name == 'Doctors & Hospitals')
                                            <i class="fas fa-stethoscope mr-2"></i>
                                                @elseif($service->category->name == 'Services juridiques')
                                            <i class="fas fa-gavel mr-2"></i>
                                                @elseif($service->category->name == 'Beauty Salon & Spas')
                                            <i class="fas fa-spa mr-2"></i>
                                                @elseif($service->category->name == 'Hotel')
                                            <i class="fas fa-hotel mr-2"></i>
                                            @elseif($service->category->name == 'Restaurant')
                                            <i class="fas fa-utensils mr-2"></i>
                                            @else
                                            <i class="fas fa-tag mr-2"></i>
                                            @endif
                                                <span class="text-sm font-medium">{{ $service->category->name }}</span>
                                            @else
                                                <i class="fas fa-tag mr-2"></i>
                                                <span class="text-sm font-medium">Non catégorisé</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-bold">{{ $service->name }}</h3>
                                        <div class="flex items-center">
                                            <div class="stars-container">
                                                <div class="stars-bg">★★★★★</div>
                                                <div class="stars-fg" style="width: {{ rand(80, 98) }}%">★★★★★</div>
                                            </div>
                                            <span class="text-sm text-gray-600 ml-1">{{ number_format(rand(40, 50) / 10, 1) }}</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 60) }}</p>
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>{{ $service->provider->city ?? 'Paris' }}</span>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <a href="{{ route('client.reserve.form', $service->id) }}" class="bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 px-4 text-sm font-medium transition-colors shadow-md hover:shadow-lg flex-grow ripple text-center">
                                            Réserver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        @endif
        
        <!-- CTA Section -->
        <section class="py-16 bg-primary-600 text-white">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                    <h2 class="text-3xl font-bold mb-6">Vous êtes un prestataire de services?</h2>
                    <p class="text-xl mb-8">
                        Rejoignez Reservez-moi et développez votre activité en touchant des milliers de nouveaux clients
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-md font-medium transition-colors shadow-lg hover:shadow-xl ripple text-center">
                            Devenir partenaire
                        </a>
                        <button class="border border-white hover:bg-primary-700 px-8 py-3 rounded-md font-medium transition-colors ripple">
                            En savoir plus
                        </button>
                    </div>
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
                        <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h3 class="text-sm font-bold">Secteurs</h3>
                    <nav class="flex flex-col gap-2">
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Doctors & Hospitals
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Beauty Salon & Spas
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Services juridiques
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Hotel
                        </a>
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Restaurant
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
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            FAQ
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
                        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
                            Cookies
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
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
            
            // Featured services slider
            const featuredServicesSwiper = new Swiper('.featured-services-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
                autoplay: {
                    delay: 5000,
                },
            });
            
            // Dynamique catalogue services
            const servicesList = document.getElementById('services-list');
            const servicesLoader = document.getElementById('services-loader');
            const servicesPagination = document.getElementById('services-pagination');
            const searchInput = document.querySelector('input[name="search"]');
            const categorySelect = document.querySelector('select[name="category"]');
            const priceRange = document.getElementById('priceRange');
            const sortSelect = document.querySelector('select'); // le premier select de tri

            function fetchServices(url = null) {
                servicesLoader.classList.remove('hidden');
                servicesList.innerHTML = '';
                let params = new URLSearchParams();
                if (searchInput && searchInput.value) params.append('search', searchInput.value);
                if (categorySelect && categorySelect.value) params.append('category', categorySelect.value);
                if (priceRange && priceRange.value) params.append('max_price', priceRange.value);
                if (sortSelect && sortSelect.value && sortSelect.value !== 'recommended') params.append('sort', sortSelect.value);
                let fetchUrl = url || `{{ route('client.services.ajax') }}?${params.toString()}`;
                fetch(fetchUrl, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(res => res.json())
                    .then(data => {
                        servicesList.innerHTML = data.html;
                        servicesPagination.innerHTML = data.pagination;
                    })
                    .catch(() => {
                        servicesList.innerHTML = `<div class='col-span-3 text-center text-red-500 py-6'>Erreur lors du chargement des services.</div>`;
                        servicesPagination.innerHTML = '';
                    })
                    .finally(() => {
                        servicesLoader.classList.add('hidden');
                    });
            }

            if (searchInput) searchInput.addEventListener('input', () => fetchServices());
            if (categorySelect) categorySelect.addEventListener('change', () => fetchServices());
            if (priceRange) priceRange.addEventListener('change', () => fetchServices());
            if (sortSelect) sortSelect.addEventListener('change', () => fetchServices());
            servicesPagination.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' && e.target.href) {
                    e.preventDefault();
                    fetchServices(e.target.href);
                }
            });
        });
        
        // Price range slider
        function updatePriceValue(value) {
            document.getElementById('priceValue').textContent = value + ' €';
        }
    </script>
</body>
</html>

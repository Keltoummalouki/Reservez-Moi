<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Reservez-moi</title>
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
    <style type="text/css">
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
        
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #2563eb, #60a5fa);
        }
        
        .bg-gradient-primary {
            background-image: linear-gradient(to right, #2563eb, #3b82f6);
        }
        
        .shape-blob {
            border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%;
            animation: blob-animation 8s linear infinite;
            opacity: 0.1;
        }
        
        .shape-blob2 {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: blob-animation 8s linear infinite;
            animation-delay: 2s;
            opacity: 0.1;
        }
        
        @keyframes blob-animation {
            0% { border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%; }
            25% { border-radius: 45% 55% 65% 35% / 50% 60% 40% 50%; }
            50% { border-radius: 50% 50% 40% 60% / 55% 45% 55% 45%; }
            75% { border-radius: 55% 45% 35% 65% / 40% 50% 60% 50%; }
            100% { border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%; }
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
                <a href="{{ url('/#features') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">S'inscrire</a>
                <button id="mobile-menu-button" class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed inset-0 z-50 bg-white md:hidden transform -translate-x-full transition-transform duration-300">
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
                <a href="{{ url('/#features') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">FAQ</a>
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('register') }}" class="text-center py-3 text-primary-600 font-medium border border-primary-600 rounded-md hover:bg-primary-50 transition-colors">S'inscrire</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <div class="container mx-auto px-4 py-12 md:py-20">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 max-w-6xl mx-auto">
                <!-- Left Column - Image and Text -->
                <div class="lg:w-1/2 relative" data-aos="fade-right">
                    <div class="absolute -z-10 w-72 h-72 bg-primary-600 rounded-full top-0 -left-10 shape-blob"></div>
                    <div class="absolute -z-10 w-64 h-64 bg-primary-400 rounded-full bottom-0 -right-10 shape-blob2"></div>
                    
                    <div class="relative bg-white p-8 rounded-2xl shadow-xl">
                        <img src="https://images.unsplash.com/photo-1586769852044-692d6e3703f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" alt="Connexion" class="w-full h-auto rounded-lg mb-6">
                        
                        <h2 class="text-2xl font-bold mb-4">Simplifiez vos réservations</h2>
                        <p class="text-gray-600 mb-6">
                            Connectez-vous pour accéder à votre compte et gérer vos réservations en toute simplicité. Profitez de nos services personnalisés et d'une expérience utilisateur optimale.
                        </p>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                                <i class="fas fa-calendar-check text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Réservations simplifiées</h3>
                                <p class="text-sm text-gray-500">Réservez en quelques clics</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 my-6"></div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                                <i class="fas fa-bell text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Notifications en temps réel</h3>
                                <p class="text-sm text-gray-500">Restez informé de vos rendez-vous</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Login Form -->
                <div class="lg:w-1/2 w-full max-w-md" data-aos="fade-left">
                    <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold mb-2">Connexion</h1>
                            <p class="text-gray-600">Accédez à votre compte Reservez-moi</p>
                        </div>
                        
                        @if (session('status'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                                <span class="block sm:inline">{{ session('status') }}</span>
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="votre@email.com">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-500">Mot de passe oublié?</a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input id="password" type="password" name="password" required autocomplete="current-password" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="••••••••">
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg glow-on-hover ripple">
                                    Se connecter
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-8 text-center">
                            <p class="text-gray-600">Vous n'avez pas de compte?</p>
                            <a href="{{ route('register') }}" class="mt-2 inline-block font-medium text-primary-600 hover:text-primary-500">Créer un compte</a>
                        </div>
                        
                        <div class="relative flex items-center justify-center mt-8">
                            <div class="border-t border-gray-200 absolute w-full"></div>
                            <div class="bg-white px-4 relative z-10 text-sm text-gray-500">ou continuer avec</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <a href="{{ route('socialite.redirect', 'google') }}" class="flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2.5 px-4 hover:bg-gray-50 transition-colors">
                                <i class="fab fa-google text-red-500"></i>
                                <span class="text-sm font-medium">Google</span>
                            </a>
                            <a href="{{ route('socialite.redirect', 'facebook') }}" class="flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2.5 px-4 hover:bg-gray-50 transition-colors">
                                <i class="fab fa-facebook-f text-blue-600"></i>
                                <span class="text-sm font-medium">Facebook</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white py-8">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="bg-primary-600 text-white p-1.5 rounded-lg">
                        <i class="fas fa-calendar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Reservez-<span class="text-primary-600">moi</span></span>
                </div>
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Reservez-moi. Tous droits réservés.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Conditions d'utilisation</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
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
                mobileMenu.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
            });
            
            closeMenuButton.addEventListener('click', function() {
                mobileMenu.classList.add('-translate-x-full');
                document.body.style.overflow = '';
            });
            
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('-translate-x-full');
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
        });
    </script>
</body>
</html>
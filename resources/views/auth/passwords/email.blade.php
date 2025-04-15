<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réinitialisation de mot de passe - Reservez-Moi">
    <title>Mot de passe oublié | Reservez-moi</title>
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
                <a href="{{ url('/#features') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">Se connecter</a>
                <a href="{{ route('register') }}" class="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors shadow-md hover:shadow-lg glow-on-hover ripple">S'inscrire</a>
                <button id="mobile-menu-button" class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-lg absolute w-full left-0 top-16">
            <div class="px-4 pt-2 pb-4 space-y-4">
                <a href="{{ url('/#how-it-works') }}" class="block text-gray-700 hover:text-primary-600">Comment ça marche</a>
                <a href="{{ url('/#features') }}" class="block text-gray-700 hover:text-primary-600">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="block text-gray-700 hover:text-primary-600">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="block text-gray-700 hover:text-primary-600">FAQ</a>
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-primary-600">Se connecter</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-primary-600">S'inscrire</a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <div class="container mx-auto px-4 py-12 md:py-20">
            <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2">Réinitialisation du mot de passe</h1>
                    <p class="text-gray-600">Entrez votre adresse e-mail pour recevoir un lien de réinitialisation</p>
                </div>
                
                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" required class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('email') }}" placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-colors shadow-md hover:shadow-lg ripple">
                            Envoyer le lien de réinitialisation
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:text-primary-700">Retour à la connexion</a>
                    </div>
                </form>
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
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Conditions</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
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
        });
    </script>
</body>
</html>

<!-- resources/views/auth/passwords/reset.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réinitialisation de mot de passe - Reservez-Moi">
    <title>Réinitialiser mot de passe | Reservez-moi</title>
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
                <a href="{{ url('/#features') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-primary-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">Se connecter</a>
                <a href="{{ route('register') }}" class="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors shadow-md hover:shadow-lg glow-on-hover ripple">S'inscrire</a>
                <button id="mobile-menu-button" class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-lg absolute w-full left-0 top-16">
            <div class="px-4 pt-2 pb-4 space-y-4">
                <a href="{{ url('/#how-it-works') }}" class="block text-gray-700 hover:text-primary-600">Comment ça marche</a>
                <a href="{{ url('/#features') }}" class="block text-gray-700 hover:text-primary-600">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="block text-gray-700 hover:text-primary-600">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="block text-gray-700 hover:text-primary-600">FAQ</a>
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-primary-600">Se connecter</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-primary-600">S'inscrire</a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <div class="container mx-auto px-4 py-12 md:py-20">
            <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2">Réinitialiser votre mot de passe</h1>
                    <p class="text-gray-600">Choisissez un nouveau mot de passe pour votre compte</p>
                </div>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" required class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ $email ?? old('email') }}" readonly>
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" required class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password-confirm" name="password_confirmation" required class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-colors shadow-md hover:shadow-lg ripple">
                            Réinitialiser le mot de passe
                        </button>
                    </div>
                </form>
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
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Conditions</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
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
        });
    </script>
</body>
</html>
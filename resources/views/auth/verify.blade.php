<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vérifiez votre adresse email pour Reservez-Moi.">
    <meta name="keywords" content="vérification, email, compte">
    <title>Vérification d'Email - Reservez-Moi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
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
                <a href="{{ url('/') }}" class="text-xl font-bold">Reservez-<span class="text-blue-600">moi</span></a>
            </div>
            <nav class="hidden md:flex gap-6">
                <a href="{{ url('/#how-it-works') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Comment ça marche</a>
                <a href="{{ route('client.services') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Services</a>
                <a href="{{ url('/#features') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Fonctionnalités</a>
                <a href="{{ url('/#testimonials') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">Témoignages</a>
                <a href="{{ url('/#faq') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">FAQ</a>
            </nav>
            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="text-sm font-medium hover:text-blue-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </button>
                </form>
                <button id="mobile-menu-button" class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-20">
        <!-- Email Verification Section -->
        <section class="py-20 bg-gradient-to-r from-blue-50 to-blue-100">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="bg-blue-100 text-blue-600 mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-envelope text-3xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Vérifiez votre adresse email</h2>
                            <p class="text-gray-600 mt-2">Un lien de vérification a été envoyé à votre adresse email.</p>
                        </div>

                        @if (session('resent'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                                <p>Un nouveau lien de vérification a été envoyé à votre adresse email.</p>
                            </div>
                        @endif

                        <p class="text-gray-600 mb-6">
                            Avant de continuer, veuillez vérifier votre email pour un lien de vérification.
                            Si vous n'avez pas reçu l'email, vous pouvez en demander un autre.
                        </p>

                        <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg ripple">
                                Renvoyer l'email de vérification
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white py-8">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-1.5 rounded-lg">
                        <i class="fas fa-calendar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">Reservez-<span class="text-blue-600">moi</span></span>
                </div>
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Reservez-moi. Tous droits réservés.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">Conditions d'utilisation</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">Confidentialité</a>
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
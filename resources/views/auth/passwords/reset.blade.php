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
        
        .password-strength {
            height: 5px;
            transition: all 0.3s ease;
        }
        
        .form-appear {
            animation: formAppear 0.5s ease-out forwards;
        }
        
        @keyframes formAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg form-appear">
                <div class="text-center mb-8">
                    <div class="inline-block p-3 bg-primary-50 rounded-full mb-4">
                        <i class="fas fa-key text-primary-600 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold mb-2">Réinitialiser votre mot de passe</h1>
                    <p class="text-gray-600">Choisissez un nouveau mot de passe sécurisé pour votre compte</p>
                </div>
                
                <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" required 
                                class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:outline-none" 
                                value="{{ $email ?? old('email') }}" readonly>
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" required 
                                class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:outline-none">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-xs text-gray-500">Force du mot de passe:</span>
                                <span id="passwordStrengthText" class="text-xs font-medium">Faible</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1">
                                <div id="passwordStrength" class="password-strength bg-red-500 rounded-full" style="width: 10%"></div>
                            </div>
                            <ul class="text-xs text-gray-500 mt-2 space-y-1 pl-5 list-disc">
                                <li id="lengthCheck" class="text-gray-400">Au moins 8 caractères</li>
                                <li id="upperCheck" class="text-gray-400">Au moins une majuscule</li>
                                <li id="numberCheck" class="text-gray-400">Au moins un chiffre</li>
                                <li id="specialCheck" class="text-gray-400">Au moins un caractère spécial</li>
                            </ul>
                        </div>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password-confirm" name="password_confirmation" required 
                                class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:outline-none">
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p id="passwordMatch" class="text-xs mt-1 hidden">Les mots de passe correspondent</p>
                    </div>
                    
                    <div class="mb-6">
                        <button type="submit" id="submitBtn" 
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-colors shadow-md hover:shadow-lg ripple flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>
                            Réinitialiser le mot de passe
                        </button>
                    </div>
                    
                    <div class="text-center text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 hover:underline">
                            <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
                        </a>
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
            
            // Password functionality
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password-confirm');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordStrengthText = document.getElementById('passwordStrengthText');
            const passwordMatch = document.getElementById('passwordMatch');
            
            // Critères de validation
            const lengthCheck = document.getElementById('lengthCheck');
            const upperCheck = document.getElementById('upperCheck');
            const numberCheck = document.getElementById('numberCheck');
            const specialCheck = document.getElementById('specialCheck');
            
            // Toggle password visibility
            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', function() {
                    togglePasswordVisibility(passwordInput, this);
                });
            }
            
            if (toggleConfirmPasswordBtn) {
                toggleConfirmPasswordBtn.addEventListener('click', function() {
                    togglePasswordVisibility(confirmPasswordInput, this);
                });
            }
            
            function togglePasswordVisibility(input, button) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Change icon
                if (type === 'text') {
                    button.querySelector('i').classList.remove('fa-eye');
                    button.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    button.querySelector('i').classList.remove('fa-eye-slash');
                    button.querySelector('i').classList.add('fa-eye');
                }
            }
            
            // Password strength checker
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    let color = 'red';
                    
                    // Check length
                    if (password.length >= 8) {
                        strength += 25;
                        lengthCheck.classList.remove('text-gray-400');
                        lengthCheck.classList.add('text-green-500');
                    } else {
                        lengthCheck.classList.remove('text-green-500');
                        lengthCheck.classList.add('text-gray-400');
                    }
                    
                    // Check uppercase
                    if (/[A-Z]/.test(password)) {
                        strength += 25;
                        upperCheck.classList.remove('text-gray-400');
                        upperCheck.classList.add('text-green-500');
                    } else {
                        upperCheck.classList.remove('text-green-500');
                        upperCheck.classList.add('text-gray-400');
                    }
                    
                    // Check numbers
                    if (/[0-9]/.test(password)) {
                        strength += 25;
                        numberCheck.classList.remove('text-gray-400');
                        numberCheck.classList.add('text-green-500');
                    } else {
                        numberCheck.classList.remove('text-green-500');
                        numberCheck.classList.add('text-gray-400');
                    }
                    
                    // Check special characters
                    if (/[^A-Za-z0-9]/.test(password)) {
                        strength += 25;
                        specialCheck.classList.remove('text-gray-400');
                        specialCheck.classList.add('text-green-500');
                    } else {
                        specialCheck.classList.remove('text-green-500');
                        specialCheck.classList.add('text-gray-400');
                    }
                    
                    // Update strength indicator
                    if (strength <= 25) {
                        color = 'red-500';
                        passwordStrengthText.textContent = 'Faible';
                        passwordStrengthText.className = 'text-xs font-medium text-red-500';
                    } else if (strength <= 50) {
                        color = 'orange-500';
                        passwordStrengthText.textContent = 'Moyen';
                        passwordStrengthText.className = 'text-xs font-medium text-orange-500';
                    } else if (strength <= 75) {
                        color = 'yellow-500';
                        passwordStrengthText.textContent = 'Bon';
                        passwordStrengthText.className = 'text-xs font-medium text-yellow-500';
                    } else {
                        color = 'green-500';
                        passwordStrengthText.textContent = 'Excellent';
                        passwordStrengthText.className = 'text-xs font-medium text-green-500';
                    }
                    
                    passwordStrength.style.width = strength + '%';
                    passwordStrength.className = `password-strength bg-${color} rounded-full`;
                    
                    // Check if passwords match
                    checkPasswordsMatch();
                });
            }
            
            // Check if passwords match
            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', checkPasswordsMatch);
            }
            
            function checkPasswordsMatch() {
                if (!passwordMatch) return;
                
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (confirmPassword.length > 0) {
                    passwordMatch.classList.remove('hidden');
                    
                    if (password === confirmPassword) {
                        passwordMatch.textContent = 'Les mots de passe correspondent';
                        passwordMatch.className = 'text-xs mt-1 text-green-500';
                    } else {
                        passwordMatch.textContent = 'Les mots de passe ne correspondent pas';
                        passwordMatch.className = 'text-xs mt-1 text-red-500';
                    }
                } else {
                    passwordMatch.classList.add('hidden');
                }
            }
            
            // Form submission
            const resetForm = document.getElementById('resetForm');
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    
                    // Validate password
                    if (password.length < 8 || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || !/[^A-Za-z0-9]/.test(password)) {
                        e.preventDefault();
                        alert('Votre mot de passe ne respecte pas les critères de sécurité.');
                        return;
                    }
                    
                    // Check if passwords match
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Les mots de passe ne correspondent pas.');
                        return;
                    }
                });
            }
            
            // Add ripple effect to button
            const rippleButtons = document.querySelectorAll('.ripple');
            rippleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const rect = button.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const ripple = document.createElement('span');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>
</html>
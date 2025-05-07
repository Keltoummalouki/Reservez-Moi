<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservez-moi | Réservation multi-secteurs</title>
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
          'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          'float': 'float 6s ease-in-out infinite',
          'spin-slow': 'spin 8s linear infinite',
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
          float: {
            '0%, 100%': { transform: 'translateY(0)' },
            '50%': { transform: 'translateY(-10px)' },
          },
        },
        boxShadow: {
          'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
          'neon': '0 0 5px theme("colors.primary.400"), 0 0 20px theme("colors.primary.300")',
        },
        backgroundImage: {
          'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
          'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
        },
      }
    }
  }
</script>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
  
  :root {
    --swiper-theme-color: #2563eb;
  }
  
  html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
  }
  
  body {
    font-family: 'Inter', sans-serif;
  }
  
  h1, h2, h3, h4, h5, h6 {
    font-family: 'Poppins', sans-serif;
  }
  
  .mobile-menu {
    transition: transform 0.3s ease-in-out;
    transform: translateX(-100%);
  }
  
  .mobile-menu.active {
    transform: translateX(0);
  }
  
  .header-scrolled {
    @apply shadow-md bg-white/95 backdrop-blur-sm;
  }
  
  .swiper-pagination-bullet-active {
    background-color: #2563eb !important;
  }
  
  .card-hover {
    transition: all 0.3s ease;
  }
  
  .card-hover:hover {
    transform: translateY(-5px);
  }
  
  .glass-effect {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
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
  
  .custom-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1.5em 1.5em;
  }
  
  .fade-in {
    animation: fadeIn 0.5s ease-in-out;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  .slide-up {
    animation: slideUp 0.5s ease-in-out;
  }
  
  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
  
  .counter-value {
    transition: all 0.5s ease;
  }
  
  /* Gradient text */
  .text-gradient {
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    background-image: linear-gradient(to right, #2563eb, #60a5fa);
  }
  
  /* Animated underline */
  .animated-underline {
    position: relative;
    display: inline-block;
  }
  
  .animated-underline::after {
    content: '';
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: #2563eb;
    transform-origin: bottom right;
    transition: transform 0.3s ease-out;
  }
  
  .animated-underline:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
  }
  
  /* Floating animation */
  .floating {
    animation: float 6s ease-in-out infinite;
  }
  
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  
  /* Glow effect */
  .glow-on-hover:hover {
    box-shadow: 0 0 15px rgba(37, 99, 235, 0.5);
  }
  
  /* Typing animation */
  .typing-animation {
    border-right: 2px solid #2563eb;
    white-space: nowrap;
    overflow: hidden;
    animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
  }
  
  @keyframes typing {
    from { width: 0 }
    to { width: 100% }
  }
  
  @keyframes blink-caret {
    from, to { border-color: transparent }
    50% { border-color: #2563eb }
  }
  
  /* Scroll progress bar */
  .progress-bar {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(to right, #2563eb, #60a5fa);
    z-index: 9999;
    transition: width 0.2s ease;
  }
  
  /* Tooltip */
  .tooltip {
    position: relative;
  }
  
  .tooltip .tooltip-text {
    visibility: hidden;
    width: 120px;
    background-color: #172554;
    color: white;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
  }
  
  .tooltip .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #172554 transparent transparent transparent;
  }
  
  .tooltip:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
  }
  
  /* Marquee animation */
  .marquee {
    overflow: hidden;
    white-space: nowrap;
  }
  
  .marquee-content {
    display: inline-block;
    animation: marquee 20s linear infinite;
  }
  
  @keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
  }
  
  /* Parallax effect */
  .parallax {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }
  
  /* Custom scrollbar */
  ::-webkit-scrollbar {
    width: 10px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #2563eb;
    border-radius: 5px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #1d4ed8;
  }
  
  /* Dark mode toggle */
  .dark-mode {
    background-color: #1a202c;
    color: #f7fafc;
  }
  
  .dark-mode .dark-bg {
    background-color: #2d3748;
  }
  
  .dark-mode .dark-text {
    color: #f7fafc;
  }
  
  /* Preloader */
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
  }
  
  .preloader.hidden {
    opacity: 0;
    visibility: hidden;
  }
  
  .loader {
    width: 48px;
    height: 48px;
    border: 5px solid #dbeafe;
    border-bottom-color: #2563eb;
    border-radius: 50%;
    animation: rotation 1s linear infinite;
  }
  
  @keyframes rotation {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  /* Ripple effect */
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
  
  /* Tilt effect */
  .tilt {
    transform-style: preserve-3d;
    transform: perspective(1000px);
  }
  
  .tilt-inner {
    transform: translateZ(20px);
  }
  
  /* Skewed section */
  .skewed {
    position: relative;
    padding: 100px 0;
  }
  
  .skewed:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    transform: skewY(-3deg);
    transform-origin: 50% 0;
    outline: 1px solid transparent;
    backface-visibility: hidden;
    background-color: inherit;
    z-index: -1;
  }

  /* Filtres et recherche */
  .category-filter {
    transition: all 0.3s ease;
  }
  
  .category-filter.active {
    background-color: #2563eb;
    color: white;
  }
  
  .service-card {
    transition: all 0.3s ease;
    transform: scale(1);
  }
  
  .service-card.hidden {
    display: none;
  }
  
  .service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }
  
  .search-highlight {
    background-color: rgba(37, 99, 235, 0.2);
    padding: 0 2px;
    border-radius: 2px;
  }
  
  .no-results {
    display: none;
    text-align: center;
    padding: 2rem;
    width: 100%;
  }
  
  .no-results.show {
    display: block;
  }
  
  /* Animations pour les filtres */
  .filter-animation {
    animation: filterPulse 0.5s ease-in-out;
  }
  
  @keyframes filterPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
</style>
</head>
<body class="flex min-h-screen flex-col">
<!-- Preloader -->
<div class="preloader">
  <div class="loader"></div>
</div>

<!-- Progress Bar -->
<div class="progress-bar" id="progressBar"></div>

<!-- Header/Navigation -->
<header id="main-header" class="fixed top-0 z-50 w-full transition-all duration-300 bg-white">
  <div class="container mx-auto flex h-20 items-center justify-between px-4 md:px-6">
    <div class="flex items-center gap-2">
      <div class="bg-primary-600 text-white p-2 rounded-lg shadow-md">
        <i class="fas fa-calendar text-xl"></i>
      </div>
      <span class="text-xl font-bold">Reservez-<span class="text-primary-600">moi</span></span>
    </div>
    <nav class="hidden md:flex gap-6">
      <a href="#how-it-works" class="text-sm font-medium animated-underline transition-colors">Comment ça marche</a>
      <a href="#services" class="text-sm font-medium animated-underline transition-colors">Services</a>
      <a href="#features" class="text-sm font-medium animated-underline transition-colors">Fonctionnalités</a>
      <a href="#testimonials" class="text-sm font-medium animated-underline transition-colors">Témoignages</a>
      <a href="#faq" class="text-sm font-medium animated-underline transition-colors">FAQ</a>
    </nav>
    <div class="flex items-center gap-4">
      @guest
        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">Se connecter</a>
        <a href="{{ route('register') }}" class="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors shadow-md hover:shadow-lg glow-on-hover ripple">S'inscrire</a>
      @else
        <div class="flex items-center gap-3">
          <a href="{{ route('client.services') }}" class="text-sm font-medium hover:text-primary-600 transition-colors hidden md:block">
            <i class="fas fa-user-circle mr-1"></i> Mon compte
          </a>
          <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
            @csrf
            <button type="submit" class="text-sm font-medium hover:text-primary-600 transition-colors">
              <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
            </button>
          </form>
        </div>
      @endguest
      <button id="mobile-menu-button" class="md:hidden text-gray-500">
        <i class="fas fa-bars text-xl"></i>
      </button>
      <button id="dark-mode-toggle" class="text-gray-500 hover:text-primary-600 transition-colors tooltip">
        <i class="fas fa-moon text-lg"></i>
        <span class="tooltip-text text-xs">Mode sombre</span>
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
      <a href="#how-it-works" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Comment ça marche</a>
      <a href="#services" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Services</a>
      <a href="#features" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Fonctionnalités</a>
      <a href="#testimonials" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">Témoignages</a>
      <a href="#faq" class="border-b border-gray-100 py-4 text-lg font-medium hover:text-primary-600 transition-colors mobile-link">FAQ</a>
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
  <!-- Hero Section -->
  <section class="relative bg-gradient-to-r from-blue-50 to-blue-100 py-20 md:py-28 overflow-hidden">
    <!-- Decorative shapes -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-500 shape-blob"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-primary-500 shape-blob2"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-6xl max-h-6xl rounded-full bg-gradient-radial from-primary-200/20 to-transparent opacity-60 animate-pulse-slow"></div>
    
    <div class="container mx-auto px-4 md:px-6 relative">
      <div class="grid gap-6 lg:grid-cols-2 lg:gap-12 items-center">
        <div class="space-y-6" data-aos="fade-right" data-aos-duration="1000">
          <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-2">Plateforme de réservation tout-en-un</span>
          <h1 class="text-4xl font-bold tracking-tighter sm:text-5xl md:text-6xl">
            Réservez tous vos services <span class="text-gradient">en un seul endroit</span>
          </h1>
          <p class="max-w-[600px] text-gray-600 text-lg">
            Médecins, avocats, salons de beauté, hôtels ou restaurants - Simplifiez vos réservations avec notre plateforme intuitive.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button class="rounded-md bg-primary-600 px-6 py-3.5 font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors shadow-lg hover:shadow-xl ripple">
              <i class="fas fa-rocket mr-2"></i> Commencer maintenant
            </button>
            <button class="rounded-md border border-gray-300 bg-white/80 backdrop-blur-sm px-6 py-3.5 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors shadow-sm hover:shadow-md group">
              <i class="fas fa-play-circle mr-2 text-primary-600 group-hover:animate-pulse"></i> Voir la démo
            </button>
          </div>
          <div class="flex items-center gap-4 pt-4">
            <div class="flex -space-x-2">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Utilisateur">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/54.jpg" alt="Utilisateur">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/67.jpg" alt="Utilisateur">
              <div class="w-10 h-10 rounded-full border-2 border-white bg-primary-100 flex items-center justify-center text-primary-800 text-xs font-medium">+2k</div>
            </div>
            <p class="text-sm text-gray-600">Rejoint par plus de <span class="font-semibold">2,000+ utilisateurs</span> ce mois-ci</p>
          </div>
          <div class="pt-4 flex flex-wrap gap-2">
            <div class="flex items-center bg-white/80 backdrop-blur-sm rounded-full px-3 py-1 text-xs text-gray-600">
              <i class="fas fa-shield-alt text-green-500 mr-1"></i> Paiement sécurisé
            </div>
            <div class="flex items-center bg-white/80 backdrop-blur-sm rounded-full px-3 py-1 text-xs text-gray-600">
              <i class="fas fa-check-circle text-green-500 mr-1"></i> Annulation gratuite
            </div>
            <div class="flex items-center bg-white/80 backdrop-blur-sm rounded-full px-3 py-1 text-xs text-gray-600">
              <i class="fas fa-headset text-green-500 mr-1"></i> Support 24/7
            </div>
          </div>
        </div>
        <div class="relative h-[400px] lg:h-[500px] rounded-xl overflow-hidden shadow-2xl tilt" data-aos="fade-left" data-aos-duration="1000" id="hero-image-container">
          <img 
            src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
            alt="Reservez-moi platform" 
            class="w-full h-full object-cover tilt-inner"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
          
          <!-- Floating notification elements -->
          <div class="absolute bottom-4 left-4 right-4 glass-effect p-4 rounded-lg shadow-glass tilt-inner">
            <div class="flex items-center gap-3">
              <div class="bg-green-500 text-white p-2 rounded-full">
                <i class="fas fa-check text-sm"></i>
              </div>
              <div>
                <p class="text-sm font-medium">Réservation confirmée</p>
                <p class="text-xs text-gray-500">Dr. Martin - Consultation - Lundi 15 Mai, 14:30</p>
              </div>
            </div>
          </div>
          
          <div class="absolute top-4 right-4 glass-effect p-3 rounded-lg shadow-glass animate-pulse tilt-inner">
            <div class="flex items-center gap-2">
              <div class="bg-primary-500 text-white p-1.5 rounded-full">
                <i class="fas fa-bell text-xs"></i>
              </div>
              <p class="text-xs font-medium">Rappel: RDV dans 1h</p>
            </div>
          </div>
          
          <div class="absolute top-1/2 left-4 transform -translate-y-1/2 glass-effect p-3 rounded-lg shadow-glass floating tilt-inner hidden md:block">
            <div class="flex items-center gap-2">
              <div class="bg-yellow-500 text-white p-1.5 rounded-full">
                <i class="fas fa-star text-xs"></i>
              </div>
              <p class="text-xs font-medium">4.9/5 - 2,548 avis</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Trusted By Section -->
  <section class="py-8 bg-white border-b">
    <div class="container mx-auto px-4 md:px-6">
      <div class="text-center mb-6">
        <p class="text-sm text-gray-500 uppercase tracking-wider">Ils nous font confiance</p>
      </div>
      <div class="marquee">
        <div class="marquee-content flex items-center justify-around">
          <img src="https://cdn-icons-png.flaticon.com/512/5968/5968534.png" alt="Trustpilot" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png" alt="Google" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/174/174848.png" alt="Facebook" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/5968/5968534.png" alt="Trustpilot" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png" alt="Google" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/174/174848.png" alt="Facebook" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
          <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram" class="h-8 mx-8 grayscale hover:grayscale-0 transition-all duration-300">
        </div>
      </div>
    </div>
  </section>

  <!-- Search Section -->
  <section class="py-12 bg-white">
    <div class="container mx-auto px-4 md:px-6">
      <div class="mx-auto max-w-4xl bg-white rounded-xl shadow-xl p-8 -mt-12 relative z-10 border border-gray-100 glass-effect" data-aos="fade-up" data-aos-duration="1000">
        <div class="space-y-6">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Que souhaitez-vous réserver aujourd'hui?</h2>
            <p class="text-gray-500 mt-2">Trouvez le service parfait en quelques clics</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-1">
              <label for="sector-select" class="block text-sm font-medium text-gray-700 mb-1">Secteur</label>
              <select id="sector-select" class="w-full rounded-md border border-gray-200 py-2.5 px-3 text-sm custom-select focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                <option value="all" selected>Tous les secteurs</option>
                <option value="medical">Médical</option>
                <option value="beauty">Beauté & Bien-être</option>
                <option value="home">Services à domicile</option>
                <option value="legal">Juridique</option>
                <option value="coaching">Coaching</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label for="search-input" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
              <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                  id="search-input"
                  type="text"
                  placeholder="Nom du service ou prestataire"
                  class="w-full rounded-md border border-gray-200 pl-10 py-2.5 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                />
              </div>
            </div>
            <div class="md:col-span-1">
              <label for="location-input" class="block text-sm font-medium text-gray-700 mb-1">Où?</label>
              <div class="relative">
                <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                  id="location-input"
                  type="text"
                  placeholder="Ville ou code postal"
                  class="w-full rounded-md border border-gray-200 pl-10 py-2.5 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                />
              </div>
            </div>
            <div class="md:col-span-1">
              <label class="block text-sm font-medium text-gray-700 mb-1 opacity-0">Rechercher</label>
              <button id="search-button" class="bg-primary-600 hover:bg-primary-700 text-white w-full rounded-md py-2.5 transition-colors shadow-md hover:shadow-lg ripple">
                <i class="fas fa-search mr-2"></i> Rechercher
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        ...
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="home-services-list">
            @include('client.partials.services_list', ['services' => $services])
        </div>
        <div id="home-services-loader" class="w-full flex justify-center py-6 hidden">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        </div>
        <div id="home-services-pagination" class="flex justify-center mt-12" data-aos="fade-up">
            @if($services->hasPages())
                {{ $services->links() }}
            @endif
        </div>
    </div>
</section>

  <!-- How it works Section -->
  <section id="how-it-works" class="py-20 bg-gray-50 skewed">
    <div class="container mx-auto px-4 md:px-6">
      <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
        <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">Comment ça marche</span>
        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl mb-4">
          Réservez en <span class="text-gradient">3 étapes simples</span>
        </h2>
        <p class="text-gray-600 text-lg">
          Notre plateforme a été conçue pour rendre le processus de réservation aussi simple et rapide que possible.
        </p>
      </div>
      
      <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover" data-aos="fade-up" data-aos-delay="100">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-2xl font-bold mx-auto mb-6">1</div>
          <h3 class="text-xl font-bold mb-4">Choisissez un service</h3>
          <p class="text-gray-600 mb-4">Sélectionnez le type de service dont vous avez besoin parmi nos nombreuses catégories.</p>
          <img src="https://cdn-icons-png.flaticon.com/512/3588/3588614.png" alt="Choose sector" class="w-24 h-24 mx-auto opacity-75 floating">
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover" data-aos="fade-up" data-aos-delay="200">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-2xl font-bold mx-auto mb-6">2</div>
          <h3 class="text-xl font-bold mb-4">Trouvez un prestataire</h3>
          <p class="text-gray-600 mb-4">Recherchez et comparez les prestataires disponibles selon vos critères.</p>
          <img src="https://cdn-icons-png.flaticon.com/512/1786/1786971.png" alt="Find provider" class="w-24 h-24 mx-auto opacity-75 floating">
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover" data-aos="fade-up" data-aos-delay="300">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-2xl font-bold mx-auto mb-6">3</div>
          <h3 class="text-xl font-bold mb-4">Réservez votre créneau</h3>
          <p class="text-gray-600 mb-4">Choisissez une date et une heure disponible et confirmez votre réservation.</p>
          <img src="https://cdn-icons-png.flaticon.com/512/2693/2693507.png" alt="Book slot" class="w-24 h-24 mx-auto opacity-75 floating">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6">
      <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
        <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">Fonctionnalités</span>
        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl mb-4">
          Pourquoi choisir <span class="text-gradient">Reservez-moi</span>?
        </h2>
        <p class="text-gray-600 text-lg">
          Notre plateforme offre une expérience de réservation simple, efficace et adaptée à vos besoins
        </p>
      </div>
      
      <div class="mx-auto grid max-w-6xl grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Feature Cards -->
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="100">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-calendar-check text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Réservation Facile</h3>
          <p class="text-gray-600">Interface intuitive pour réserver en quelques clics sans complications</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Processus simplifié</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Interface intuitive</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Confirmation immédiate</span>
            </li>
          </ul>
        </div>
        
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="200">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-clock text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Disponibilité en Temps Réel</h3>
          <p class="text-gray-600">Consultez les disponibilités mises à jour instantanément pour tous les services</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Synchronisation instantanée</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Calendrier interactif</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Suggestions intelligentes</span>
            </li>
          </ul>
        </div>
        
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="300">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-users text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Formulaires Adaptés</h3>
          <p class="text-gray-600">Chaque secteur dispose de formulaires personnalisés pour une expérience optimale</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Champs spécifiques par secteur</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Options personnalisées</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Validation intelligente</span>
            </li>
          </ul>
        </div>
        
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="400">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-bell text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Notifications & Rappels</h3>
          <p class="text-gray-600">Recevez des confirmations et rappels par email ou SMS pour ne rien oublier</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Alertes personnalisables</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Rappels automatiques</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Notifications multi-canaux</span>
            </li>
          </ul>
        </div>
        
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="500">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-history text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Historique des Réservations</h3>
          <p class="text-gray-600">Consultez et gérez facilement vos réservations passées et futures</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Tableau de bord personnel</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Modification facile</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Annulation en un clic</span>
            </li>
          </ul>
        </div>
        
        <div class="flex flex-col items-center text-center space-y-4 p-8 border rounded-xl bg-white shadow-md card-hover" data-aos="fade-up" data-aos-delay="600">
          <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-4">
            <i class="fas fa-th-large text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold">Multi-Secteurs</h3>
          <p class="text-gray-600">Tous vos services préférés sur une seule plateforme pour plus de simplicité</p>
          <ul class="text-left w-full space-y-2 mt-4">
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Nombreuses catégories</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Interface unifiée</span>
            </li>
            <li class="flex items-center">
              <i class="fas fa-check text-green-500 mr-2"></i>
              <span class="text-sm text-gray-600">Compte unique</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 md:px-6">
      <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
        <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">Témoignages</span>
        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl mb-4">
          Ce que disent <span class="text-gradient">nos utilisateurs</span>
        </h2>
        <p class="text-gray-600 text-lg">
          Découvrez les expériences de nos utilisateurs satisfaits avec Reservez-moi
        </p>
      </div>
      
      <div class="mx-auto max-w-6xl" data-aos="fade-up">
        <!-- Swiper container -->
        <div class="swiper testimonial-swiper">
          <div class="swiper-wrapper pb-12">
            <!-- Testimonial Cards -->
            <div class="swiper-slide">
              <div class="flex flex-col space-y-4 rounded-xl border bg-white p-8 shadow-md h-full">
                <div class="flex items-center gap-4 mb-4">
                  <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Utilisateur" class="w-16 h-16 rounded-full">
                  <div>
                    <div class="flex text-yellow-400 mb-1">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <p class="font-semibold">Marie L.</p>
                    <p class="text-sm text-gray-500">Utilisatrice régulière</p>
                  </div>
                </div>
                <div class="flex-1">
                  <p class="text-gray-600 italic">"Reservez-moi a complètement simplifié ma façon de prendre rendez-vous chez le médecin. Plus besoin d'appeler et d'attendre des heures au téléphone! Je recommande vivement cette plateforme à tous mes proches."</p>
                </div>
                <div class="pt-4 border-t">
                  <p class="text-sm text-gray-500">Service utilisé: <span class="font-medium text-primary-600">Médecins & Hôpitaux</span></p>
                </div>
              </div>
            </div>
            
            <div class="swiper-slide">
              <div class="flex flex-col space-y-4 rounded-xl border bg-white p-8 shadow-md h-full">
                <div class="flex items-center gap-4 mb-4">
                  <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Utilisateur" class="w-16 h-16 rounded-full">
                  <div>
                    <div class="flex text-yellow-400 mb-1">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="font-semibold">Thomas D.</p>
                    <p class="text-sm text-gray-500">Entrepreneur</p>
                  </div>
                </div>
                <div class="flex-1">
                  <p class="text-gray-600 italic">"J'utilise cette plateforme pour réserver mes rendez-vous juridiques et c'est un gain de temps considérable. L'interface est intuitive et les rappels automatiques m'évitent d'oublier mes rendez-vous importants."</p>
                </div>
                <div class="pt-4 border-t">
                  <p class="text-sm text-gray-500">Service utilisé: <span class="font-medium text-primary-600">Services Juridiques</span></p>
                </div>
              </div>
            </div>
            
            <div class="swiper-slide">
              <div class="flex flex-col space-y-4 rounded-xl border bg-white p-8 shadow-md h-full">
                <div class="flex items-center gap-4 mb-4">
                  <img src="https://randomuser.me/api/portraits/women/67.jpg" alt="Utilisateur" class="w-16 h-16 rounded-full">
                  <div>
                    <div class="flex text-yellow-400 mb-1">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <p class="font-semibold">Sophie M.</p>
                    <p class="text-sm text-gray-500">Foodie passionnée</p>
                  </div>
                </div>
                <div class="flex-1">
                  <p class="text-gray-600 italic">"La réservation de tables de restaurant n'a jamais été aussi simple. J'adore pouvoir voir les disponibilités en temps réel et réserver immédiatement. Un vrai plus pour les restaurants populaires!"</p>
                </div>
                <div class="pt-4 border-t">
                  <p class="text-sm text-gray-500">Service utilisé: <span class="font-medium text-primary-600">Restaurants</span></p>
                </div>
              </div>
            </div>
            
            <div class="swiper-slide">
              <div class="flex flex-col space-y-4 rounded-xl border bg-white p-8 shadow-md h-full">
                <div class="flex items-center gap-4 mb-4">
                  <img src="https://randomuser.me/api/portraits/men/42.jpg" alt="Utilisateur" class="w-16 h-16 rounded-full">
                  <div>
                    <div class="flex text-yellow-400 mb-1">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <p class="font-semibold">Pierre G.</p>
                    <p class="text-sm text-gray-500">Voyageur fréquent</p>
                  </div>
                </div>
                <div class="flex-1">
                  <p class="text-gray-600 italic">"Je voyage beaucoup pour mon travail et Reservez-moi me permet de réserver facilement mes hôtels. La plateforme est fiable et les confirmations sont instantanées. Un outil indispensable!"</p>
                </div>
                <div class="pt-4 border-t">
                  <p class="text-sm text-gray-500">Service utilisé: <span class="font-medium text-primary-600">Hôtels</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6">
      <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
        <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium mb-4">FAQ</span>
        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl mb-4">
          Questions <span class="text-gradient">fréquentes</span>
        </h2>
        <p class="text-gray-600 text-lg">
          Trouvez les réponses aux questions les plus courantes sur notre plateforme
        </p>
      </div>
      
      <div class="mx-auto max-w-4xl" data-aos="fade-up">
        <div class="space-y-6">
          <!-- FAQ Items -->
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none">
              <span class="text-lg font-semibold">Comment créer un compte sur Reservez-moi?</span>
              <i class="fas fa-chevron-down text-primary-600 transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600">Pour créer un compte, cliquez sur le bouton "S'inscrire" en haut à droite de la page. Remplissez le formulaire avec vos informations personnelles, confirmez votre adresse e-mail via le lien que nous vous enverrons, et votre compte sera prêt à être utilisé.</p>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none">
              <span class="text-lg font-semibold">Comment annuler ou modifier une réservation?</span>
              <i class="fas fa-chevron-down text-primary-600 transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600">Connectez-vous à votre compte et accédez à la section "Mes Réservations". Trouvez la réservation que vous souhaitez modifier ou annuler et cliquez sur le bouton correspondant. Suivez les instructions pour finaliser votre demande. Notez que certains prestataires peuvent avoir des politiques d'annulation spécifiques.</p>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none">
              <span class="text-lg font-semibold">Les réservations sont-elles confirmées immédiatement?</span>
              <i class="fas fa-chevron-down text-primary-600 transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600">Oui, la plupart des réservations sont confirmées instantanément. Vous recevrez une confirmation par e-mail dès que votre réservation sera validée. Dans certains cas, pour des services spécifiques, une confirmation manuelle du prestataire peut être nécessaire, mais vous serez informé du statut de votre réservation en temps réel.</p>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none">
              <span class="text-lg font-semibold">Reservez-moi est-il disponible sur mobile?</span>
              <i class="fas fa-chevron-down text-primary-600 transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600">Oui, Reservez-moi est entièrement responsive et fonctionne parfaitement sur tous les appareils mobiles. Nous proposons également des applications dédiées pour iOS et Android que vous pouvez télécharger gratuitement sur l'App Store et Google Play.</p>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none">
              <span class="text-lg font-semibold">Comment contacter le support client?</span>
              <i class="fas fa-chevron-down text-primary-600 transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600">Notre équipe de support est disponible 7j/7 de 8h à 22h. Vous pouvez nous contacter par e-mail à support@reservez-moi.fr, par téléphone au 01 23 45 67 89, ou via le chat en direct disponible sur notre site et notre application mobile.</p>
            </div>
          </div>
        </div>
        
        <div class="mt-12 text-center">
          <p class="text-gray-600 mb-6">Vous ne trouvez pas la réponse à votre question?</p>
          <a href="#" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md shadow-md hover:shadow-lg transition-colors ripple">
            <i class="fas fa-headset mr-2"></i> Contacter le support
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-20 bg-primary-600 text-white overflow-hidden relative">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-500 opacity-20 rounded-full"></div>
      <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary-500 opacity-20 rounded-full"></div>
    </div>
    
    <div class="container mx-auto px-4 md:px-6 relative z-10">
      <div class="flex flex-col items-center justify-center space-y-6 text-center max-w-4xl mx-auto" data-aos="fade-up">
        <span class="inline-block px-3 py-1 bg-white/20 text-white rounded-full text-sm font-medium mb-2">Prêt à commencer?</span>
        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
          Simplifiez vos réservations <span class="underline decoration-4 decoration-white/30">dès aujourd'hui</span>
        </h2>
        <p class="max-w-[900px] md:text-xl/relaxed">
          Rejoignez des milliers d'utilisateurs qui font confiance à Reservez-moi pour tous leurs besoins de réservation
        </p>
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
          <button class="rounded-md bg-white px-8 py-4 font-medium text-primary-600 hover:bg-gray-100 focus:outline-none transition-colors shadow-lg hover:shadow-xl ripple">
            <i class="fas fa-user-plus mr-2"></i> Créer un compte gratuitement
          </button>
          <button class="rounded-md border border-white px-8 py-4 font-medium text-white hover:bg-primary-700 focus:outline-none transition-colors ripple">
            <i class="fas fa-headset mr-2"></i> Contacter un conseiller
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
        <h3 class="text-sm font-bold">Services</h3>
        <nav class="flex flex-col gap-2">
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Médecins & Hôpitaux
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Services Juridiques
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Salons de Beauté & Spas
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Services à domicile
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Coaching
          </a>
        </nav>
      </div>
      <div class="flex flex-col gap-4">
        <h3 class="text-sm font-bold">Entreprise</h3>
        <nav class="flex flex-col gap-2">
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            À propos
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Carrières
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Blog
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Presse
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Partenaires
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
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Tutoriels
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Communauté
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
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            Mentions légales
          </a>
          <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">
            RGPD
          </a>
        </nav>
      </div>
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-t pt-8">
      <p class="text-sm text-gray-500">
        © 2025 Reservez-moi. Tous droits réservés.
      </p>
      <div class="flex gap-6">
        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Accessibilité</a>
        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Plan du site</a>
        <a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Préférences cookies</a>
      </div>
    </div>
  </div>
</footer>

<!-- Back to top button -->
<button id="back-to-top" class="fixed bottom-6 right-6 bg-primary-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-primary-700 transition-colors z-50 opacity-0 invisible">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Chat support button -->
<button id="chat-support" class="fixed bottom-6 left-6 bg-primary-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-primary-700 transition-colors z-50">
  <i class="fas fa-comments text-xl"></i>
</button>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  // Données des catégories et services
  const categories = [
    { id: 1, name: "Médecins / Professionnels de santé", slug: "medecins-professionnels-de-sante", parent_id: null },
    { id: 2, name: "Médecin généraliste", slug: "medecin-generaliste", parent_id: 1 },
    { id: 3, name: "Dentiste", slug: "dentiste", parent_id: 1 },
    { id: 4, name: "Gynécologue", slug: "gynecologue", parent_id: 1 },
    { id: 5, name: "Dermatologue", slug: "dermatologue", parent_id: 1 },
    { id: 6, name: "Kinésithérapeute", slug: "kinesitherapeute", parent_id: 1 },
    { id: 7, name: "Psychologue", slug: "psychologue", parent_id: 1 },
    { id: 8, name: "Cardiologue", slug: "cardiologue", parent_id: 1 },
    { id: 9, name: "Pédiatre", slug: "pediatre", parent_id: 1 },
    { id: 10, name: "Bien-être et beauté", slug: "bien-etre-et-beaute", parent_id: null },
    { id: 11, name: "Coiffeur / Coiffeuse", slug: "coiffeur-coiffeuse", parent_id: 10 },
    { id: 12, name: "Esthéticienne", slug: "estheticienne", parent_id: 10 },
    { id: 13, name: "Masseuse", slug: "masseuse", parent_id: 10 },
    { id: 14, name: "Spa", slug: "spa", parent_id: 10 },
    { id: 15, name: "Salon de manucure", slug: "salon-de-manucure", parent_id: 10 },
    { id: 16, name: "Maquilleuse", slug: "maquilleuse", parent_id: 10 },
    { id: 17, name: "Services à domicile", slug: "services-a-domicile", parent_id: null },
    { id: 18, name: "Plombier", slug: "plombier", parent_id: 17 },
    { id: 19, name: "Électricien", slug: "electricien", parent_id: 17 },
    { id: 20, name: "Femme de ménage", slug: "femme-de-menage", parent_id: 17 },
    { id: 21, name: "Technicien électroménager", slug: "technicien-electromenager", parent_id: 17 },
    { id: 22, name: "Jardinier", slug: "jardinier", parent_id: 17 },
    { id: 23, name: "Conseils et coaching", slug: "conseils-et-coaching", parent_id: null },
    { id: 24, name: "Coach sportif", slug: "coach-sportif", parent_id: 23 },
    { id: 25, name: "Coach en nutrition", slug: "coach-en-nutrition", parent_id: 23 }
  ];
  
  // Générer des services fictifs basés sur les catégories
  const services = [];
  categories.forEach(category => {
    if (category.parent_id !== null) {
      // Générer 3 services par sous-catégorie
      for (let i = 1; i <= 3; i++) {
        services.push({
          id: services.length + 1,
          name: `${category.name} ${i}`,
          category_id: category.id,
          parent_category_id: category.parent_id,
          description: `Service de ${category.name} professionnel et de qualité.`,
          rating: (4 + Math.random()).toFixed(1),
          reviews: Math.floor(Math.random() * 100) + 10,
          price: Math.floor(Math.random() * 100) + 30,
          location: ["Paris", "Lyon", "Marseille", "Bordeaux", "Lille"][Math.floor(Math.random() * 5)],
          image: `https://source.unsplash.com/random/300x200?${category.slug}`
        });
      }
    }
  });

  // Initialize AOS
  document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });
    
    // Preloader
    const preloader = document.querySelector('.preloader');
    window.addEventListener('load', function() {
      preloader.classList.add('hidden');
    });
    
    // Progress bar
    const progressBar = document.getElementById('progressBar');
    window.addEventListener('scroll', function() {
      const totalHeight = document.body.scrollHeight - window.innerHeight;
      const progress = (window.pageYOffset / totalHeight) * 100;
      progressBar.style.width = progress + '%';
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
    
    // Testimonial slider
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
      slidesPerView: 1,
      spaceBetween: 30,
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
    
    // FAQ toggles
    const faqToggles = document.querySelectorAll('.faq-toggle');
    faqToggles.forEach(toggle => {
      toggle.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          icon.style.transform = 'rotate(180deg)';
        } else {
          content.classList.add('hidden');
          icon.style.transform = 'rotate(0)';
        }
      });
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
    
    // Dark mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    
    darkModeToggle.addEventListener('click', function() {
      body.classList.toggle('dark-mode');
      
      if (body.classList.contains('dark-mode')) {
        darkModeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i><span class="tooltip-text text-xs">Mode clair</span>';
      } else {
        darkModeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i><span class="tooltip-text text-xs">Mode sombre</span>';
      }
    });
    
    // Chat support button
    const chatSupportButton = document.getElementById('chat-support');
    if (chatSupportButton) {
      chatSupportButton.addEventListener('click', function() {
        alert('Le chat de support sera disponible prochainement!');
      });
    }
    
    // Initialiser les filtres de catégories
    initCategoryFilters();
    
    // Initialiser la grille de services
    initServicesGrid();
    
    // Initialiser la recherche
    initSearch();
  });
  
  // Fonction pour initialiser les filtres de catégories
  function initCategoryFilters() {
    const categoryFilters = document.querySelectorAll('.category-filter');
    const subcategoryFiltersContainer = document.getElementById('subcategory-filters');
    
    // Ajouter les écouteurs d'événements pour les filtres de catégories principales
    categoryFilters.forEach(filter => {
      filter.addEventListener('click', function() {
        // Supprimer la classe active de tous les filtres
        categoryFilters.forEach(f => f.classList.remove('active'));
        
        // Ajouter la classe active au filtre cliqué
        this.classList.add('active');
        
        // Récupérer la catégorie sélectionnée
        const categoryId = this.getAttribute('data-category');
        
        // Mettre à jour les sous-catégories
        updateSubcategoryFilters(categoryId);
        
        // Filtrer les services
        filterServices(categoryId, 'all');
        
        // Ajouter une animation au filtre
        this.classList.add('filter-animation');
        setTimeout(() => {
          this.classList.remove('filter-animation');
        }, 500);
      });
    });
    
    // Fonction pour mettre à jour les filtres de sous-catégories
    function updateSubcategoryFilters(categoryId) {
      // Vider le conteneur de sous-catégories
      subcategoryFiltersContainer.innerHTML = '';
      
      // Si "Tous les services" est sélectionné, ne pas afficher de sous-catégories
      if (categoryId === 'all') {
        subcategoryFiltersContainer.classList.add('hidden');
        return;
      }
      
      // Afficher le conteneur de sous-catégories
      subcategoryFiltersContainer.classList.remove('hidden');
      
      // Ajouter le filtre "Tous"
      const allFilter = document.createElement('button');
      allFilter.className = 'subcategory-filter active px-3 py-1 rounded-full bg-gray-100 text-xs font-medium hover:bg-gray-200 transition-colors';
      allFilter.setAttribute('data-subcategory', 'all');
      allFilter.textContent = 'Tous';
      allFilter.addEventListener('click', function() {
        // Supprimer la classe active de tous les filtres de sous-catégories
        document.querySelectorAll('.subcategory-filter').forEach(f => f.classList.remove('active'));
        
        // Ajouter la classe active à ce filtre
        this.classList.add('active');
        
        // Filtrer les services
        filterServices(categoryId, 'all');
      });
      subcategoryFiltersContainer.appendChild(allFilter);
      
      // Ajouter les filtres de sous-catégories
      const subcategories = categories.filter(cat => cat.parent_id === parseInt(categoryId));
      subcategories.forEach(subcat => {
        const subcatFilter = document.createElement('button');
        subcatFilter.className = 'subcategory-filter px-3 py-1 rounded-full bg-gray-100 text-xs font-medium hover:bg-gray-200 transition-colors';
        subcatFilter.setAttribute('data-subcategory', subcat.id);
        subcatFilter.textContent = subcat.name;
        subcatFilter.addEventListener('click', function() {
          // Supprimer la classe active de tous les filtres de sous-catégories
          document.querySelectorAll('.subcategory-filter').forEach(f => f.classList.remove('active'));
          
          // Ajouter la classe active à ce filtre
          this.classList.add('active');
          
          // Filtrer les services
          filterServices(categoryId, subcat.id);
        });
        subcategoryFiltersContainer.appendChild(subcatFilter);
      });
    }
    
    // Fonction pour filtrer les services
    function filterServices(categoryId, subcategoryId) {
      const servicesGrid = document.getElementById('services-grid');
      const serviceCards = document.querySelectorAll('.service-card');
      let visibleCount = 0;
      
      serviceCards.forEach(card => {
        const cardCategoryId = card.getAttribute('data-category');
        const cardSubcategoryId = card.getAttribute('data-subcategory');
        
        // Déterminer si la carte doit être visible
        let isVisible = false;
        
        if (categoryId === 'all') {
          isVisible = true;
        } else if (subcategoryId === 'all') {
          isVisible = cardCategoryId === categoryId;
        } else {
          isVisible = cardSubcategoryId === subcategoryId;
        }
        
        // Afficher ou masquer la carte
        if (isVisible) {
          card.classList.remove('hidden');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });
      
      // Afficher le message "Aucun résultat" si nécessaire
      const noResults = document.querySelector('.no-results');
      if (visibleCount === 0) {
        noResults.classList.add('show');
      } else {
        noResults.classList.remove('show');
      }
      
      // Réinitialiser la pagination
      updatePagination(1);
    }
  }
  
  // Fonction pour initialiser la grille de services
  function initServicesGrid() {
    const servicesGrid = document.getElementById('services-grid');
    
    // Vider la grille
    servicesGrid.innerHTML = '';
    
    // Ajouter le message "Aucun résultat"
    const noResults = document.createElement('div');
    noResults.className = 'no-results col-span-full';
    noResults.innerHTML = `
      <div class="text-center py-12">
        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun service trouvé</h3>
        <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
      </div>
    `;
    servicesGrid.appendChild(noResults);
    
    // Ajouter les cartes de services
    services.forEach(service => {
      const category = categories.find(cat => cat.id === service.category_id);
      const parentCategory = categories.find(cat => cat.id === service.parent_category_id);
      
      const serviceCard = document.createElement('div');
      serviceCard.className = 'service-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all';
      serviceCard.setAttribute('data-category', parentCategory.id);
      serviceCard.setAttribute('data-subcategory', category.id);
      serviceCard.setAttribute('data-name', service.name.toLowerCase());
      serviceCard.setAttribute('data-location', service.location.toLowerCase());
      
      serviceCard.innerHTML = `
        <div class="relative h-48 overflow-hidden">
          <img src="${service.image}" alt="${service.name}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
          <div class="absolute top-2 right-2 bg-white rounded-full px-2 py-1 text-xs font-medium text-primary-600 shadow-sm">
            <i class="fas fa-star text-yellow-400 mr-1"></i> ${service.rating} (${service.reviews})
          </div>
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
            <span class="text-xs text-white bg-primary-600 rounded-full px-2 py-1">${category.name}</span>
          </div>
        </div>
        <div class="p-4">
          <h3 class="text-lg font-bold mb-2">${service.name}</h3>
          <p class="text-gray-600 text-sm mb-3">${service.description}</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-gray-500 text-sm">
              <i class="fas fa-map-marker-alt mr-1 text-primary-500"></i> ${service.location}
            </div>
            <div class="text-primary-600 font-semibold">${service.price}€</div>
          </div>
          <button class="mt-4 w-full bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 text-sm font-medium transition-colors ripple">
            Réserver maintenant
          </button>
        </div>
      `;
      
      servicesGrid.appendChild(serviceCard);
    });
    
    // Initialiser la pagination
    initPagination();
  }
  
  // Fonction pour initialiser la recherche
  function initSearch() {
    const searchInput = document.getElementById('search-input');
    const locationInput = document.getElementById('location-input');
    const sectorSelect = document.getElementById('sector-select');
    const searchButton = document.getElementById('search-button');
    
    // Fonction de recherche
    function performSearch() {
      const searchTerm = searchInput.value.toLowerCase();
      const locationTerm = locationInput.value.toLowerCase();
      const sectorTerm = sectorSelect.value;
      
      const serviceCards = document.querySelectorAll('.service-card');
      let visibleCount = 0;
      
      serviceCards.forEach(card => {
        const cardName = card.getAttribute('data-name');
        const cardLocation = card.getAttribute('data-location');
        const cardCategory = card.getAttribute('data-category');
        
        // Déterminer si la carte correspond aux critères de recherche
        let matchesSearch = true;
        
        if (searchTerm && !cardName.includes(searchTerm)) {
          matchesSearch = false;
        }
        
        if (locationTerm && !cardLocation.includes(locationTerm)) {
          matchesSearch = false;
        }
        
        if (sectorTerm !== 'all' && cardCategory !== sectorTerm) {
          matchesSearch = false;
        }
        
        // Afficher ou masquer la carte
        if (matchesSearch) {
          card.classList.remove('hidden');
          visibleCount++;
          
          // Mettre en surbrillance les termes de recherche
          if (searchTerm) {
            const nameElement = card.querySelector('h3');
            const originalName = nameElement.textContent;
            const highlightedName = originalName.replace(
              new RegExp(searchTerm, 'gi'),
              match => `<span class="search-highlight">${match}</span>`
            );
            nameElement.innerHTML = highlightedName;
          }
        } else {
          card.classList.add('hidden');
        }
      });
      
      // Afficher le message "Aucun résultat" si nécessaire
      const noResults = document.querySelector('.no-results');
      if (visibleCount === 0) {
        noResults.classList.add('show');
      } else {
        noResults.classList.remove('show');
      }
      
      // Réinitialiser la pagination
      updatePagination(1);
      
      // Réinitialiser les filtres de catégories
      document.querySelectorAll('.category-filter').forEach(filter => {
        filter.classList.remove('active');
        if (filter.getAttribute('data-category') === 'all') {
          filter.classList.add('active');
        }
      });
      
      // Masquer les filtres de sous-catégories
      document.getElementById('subcategory-filters').innerHTML = '';
    }
    
    // Ajouter les écouteurs d'événements
    searchButton.addEventListener('click', performSearch);
    
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
    });
    
    locationInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
    });
    
    sectorSelect.addEventListener('change', performSearch);
  }
  
  // Fonction pour initialiser la pagination
  function initPagination() {
    const servicesPerPage = 8;
    const serviceCards = document.querySelectorAll('.service-card');
    const totalPages = Math.ceil(serviceCards.length / servicesPerPage);
    
    // Initialiser les boutons de pagination
    const paginationNumbers = document.getElementById('pagination-numbers');
    paginationNumbers.innerHTML = '';
    
    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement('button');
      pageButton.className = `w-10 h-10 rounded-md border border-gray-200 flex items-center justify-center hover:bg-gray-50 ${i === 1 ? 'bg-primary-600 text-white' : ''}`;
      pageButton.textContent = i;
      pageButton.addEventListener('click', function() {
        updatePagination(i);
      });
      paginationNumbers.appendChild(pageButton);
    }
    
    // Initialiser les boutons précédent/suivant
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    
    prevButton.addEventListener('click', function() {
      const activePage = document.querySelector('#pagination-numbers button.bg-primary-600');
      const currentPage = parseInt(activePage.textContent);
      if (currentPage > 1) {
        updatePagination(currentPage - 1);
      }
    });
    
    nextButton.addEventListener('click', function() {
      const activePage = document.querySelector('#pagination-numbers button.bg-primary-600');
      const currentPage = parseInt(activePage.textContent);
      if (currentPage < totalPages) {
        updatePagination(currentPage + 1);
      }
    });
    
    // Afficher la première page
    updatePagination(1);
  }
  
  // Fonction pour mettre à jour la pagination
  function updatePagination(page) {
    const servicesPerPage = 8;
    const serviceCards = document.querySelectorAll('.service-card:not(.hidden)');
    const totalPages = Math.ceil(serviceCards.length / servicesPerPage);
    
    // Mettre à jour les boutons de pagination
    const paginationButtons = document.querySelectorAll('#pagination-numbers button');
    paginationButtons.forEach((button, index) => {
      if (index + 1 === page) {
        button.classList.add('bg-primary-600', 'text-white');
      } else {
        button.classList.remove('bg-primary-600', 'text-white');
      }
    });
    
    // Mettre à jour les boutons précédent/suivant
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    
    prevButton.disabled = page === 1;
    nextButton.disabled = page === totalPages || totalPages === 0;
    
    // Afficher les services de la page actuelle
    serviceCards.forEach((card, index) => {
      const startIndex = (page - 1) * servicesPerPage;
      const endIndex = startIndex + servicesPerPage - 1;
      
      if (index >= startIndex && index <= endIndex) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  }
  
  // Counter animation
  const counters = document.querySelectorAll('.counter-value');
  const options = {
    threshold: 0.5
  };
  
  const observer = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;
        const target = parseInt(counter.getAttribute('data-target'));
        let count = 0;
        const speed = Math.floor(2000 / target);
        
        const updateCount = () => {
          const increment = target / 100;
          if (count < target) {
            count += increment;
            counter.innerText = Math.ceil(count).toLocaleString();
            setTimeout(updateCount, speed);
          } else {
            counter.innerText = target.toLocaleString();
          }
        };
        
        updateCount();
        observer.unobserve(counter);
      }
    });
  }, options);
  
  counters.forEach(counter => {
    observer.observe(counter);
  });
  
  // Tilt effect for hero image
  const heroImageContainer = document.getElementById('hero-image-container');
  if (heroImageContainer) {
    heroImageContainer.addEventListener('mousemove', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const xPercent = x / rect.width;
      const yPercent = y / rect.height;
      
      const rotateX = (0.5 - yPercent) * 10;
      const rotateY = (xPercent - 0.5) * 10;
      
      this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
    
    heroImageContainer.addEventListener('mouseleave', function() {
      this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const homeServicesList = document.getElementById('home-services-list');
    const homeServicesLoader = document.getElementById('home-services-loader');
    const homeServicesPagination = document.getElementById('home-services-pagination');
    const categoryButtons = document.querySelectorAll('.category-filter');

    function fetchHomeServices(url = null, extraParams = {}) {
        homeServicesLoader.classList.remove('hidden');
        homeServicesList.innerHTML = '';
        let params = new URLSearchParams();
        let activeCat = document.querySelector('.category-filter.active');
        if (activeCat && activeCat.dataset.category && activeCat.dataset.category !== 'all') {
            params.append('category', activeCat.dataset.category);
        }
        for (const [key, value] of Object.entries(extraParams)) {
            params.append(key, value);
        }
        let fetchUrl = url || `/home/services/ajax?${params.toString()}`;
        fetch(fetchUrl, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(res => res.json())
            .then(data => {
                homeServicesList.innerHTML = data.html;
                homeServicesPagination.innerHTML = data.pagination;
            })
            .catch(() => {
                homeServicesList.innerHTML = `<div class='col-span-3 text-center text-red-500 py-6'>Erreur lors du chargement des services.</div>`;
                homeServicesPagination.innerHTML = '';
            })
            .finally(() => {
                homeServicesLoader.classList.add('hidden');
            });
    }
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            fetchHomeServices();
        });
    });
    homeServicesPagination.addEventListener('click', function(e) {
        if (e.target.tagName === 'A' && e.target.href) {
            e.preventDefault();
            fetchHomeServices(e.target.href);
        }
    });
  });
</script>
</body>
</html>
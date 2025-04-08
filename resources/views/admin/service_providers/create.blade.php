<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajouter un Service Provider sur Reservez-Moi.">
    <meta name="keywords" content="admin, service provider, ajouter">
    <title>Ajouter Service Provider - Reservez-Moi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-hidden">
    <!-- Navbar -->
    <header class="bg-white shadow-lg fixed w-full z-40 top-0 transition-all duration-300" id="navbar">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Navigation principale">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <i class="fas fa-calendar-check text-indigo-700 text-3xl transition-transform duration-300 group-hover:rotate-12"></i>
                        <h1 class="text-3xl font-extrabold text-indigo-700 tracking-tight">Reservez-Moi</h1>
                    </a>
                </div>
                <div class="hidden lg:flex lg:items-center lg:space-x-10">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Tableau de bord
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-700 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                            Déconnexion
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-700 transition-all duration-300 group-hover:w-full"></span>
                        </button>
                    </form>
                </div>
                <div class="lg:hidden flex items-center">
                    <button id="menu-btn" class="text-gray-700 focus:outline-none" aria-label="Ouvrir le menu" aria-expanded="false">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-lg absolute w-full left-0 top-16">
                <div class="px-4 pt-2 pb-4 space-y-4">
                    <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Tableau de bord</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Déconnexion</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Create Form Section -->
    <section class="min-h-screen pt-24 pb-10 bg-gradient-to-br from-indigo-100 to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-8">Ajouter un Service Provider</h2>

            <!-- Messages de succès ou d'erreur -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white p-6 rounded-2xl shadow-lg max-w-lg mx-auto">
                <form action="{{ route('admin.service_providers.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nom</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" required>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="bg-indigo-700 text-white px-6 py-3 rounded-full font-medium hover:bg-indigo-800 transition duration-300 shadow-md hover:shadow-lg">
                            Ajouter
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-6 py-3 rounded-full font-medium hover:bg-gray-600 transition duration-300 shadow-md hover:shadow-lg">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">© 2025 Reservez-Moi. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- JavaScript for Interactivity -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const isOpen = !mobileMenu.classList.contains('hidden');
            menuBtn.setAttribute('aria-expanded', isOpen);
            menuBtn.querySelector('i').classList.toggle('fa-bars');
            menuBtn.querySelector('i').classList.toggle('fa-times');
        });

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-2xl');
            } else {
                navbar.classList.remove('shadow-2xl');
            }
        });
    </script>
</body>
</html>
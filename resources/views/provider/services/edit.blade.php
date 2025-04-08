<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modifiez un service sur Reservez-Moi.">
    <meta name="keywords" content="service provider, modifier service, réservations">
    <title>Modifier un Service - Reservez-Moi</title>
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
                    <a href="{{ route('provider.dashboard') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Tableau de bord
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-700 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('provider.services') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Mes Services
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-700 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('logout') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Déconnexion
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-700 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                <div class="lg:hidden flex items-center">
                    <button id="menu-btn" class="text-gray-700 focus:outline-none" aria-label="Ouvrir le menu" aria-expanded="false">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-lg absolute w-full left-0 top-16">
                <div class="px-4 pt-2 pb-4 space-y-4">
                    <a href="{{ route('provider.dashboard') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Tableau de bord</a>
                    <a href="{{ route('provider.services') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Mes Services</a>
                    <a href="{{ route('logout') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Déconnexion</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Edit Service Section -->
    <section class="min-h-screen flex items-center justify-center pt-20 pb-10 bg-gradient-to-br from-indigo-100 to-gray-50">
        <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-lg transform transition-all duration-500 animate-slide-in-up">
            <h2 class="text-3xl font-bold text-center text-gray-900">Modifier le Service</h2>
            <p class="mt-2 text-center text-gray-600">Mettez à jour les détails de votre service</p>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="mt-4 text-red-600 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Edit Service Form -->
            <form class="space-y-6" action="{{ route('provider.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du Service</label>
                    <div class="mt-1 relative">
                        <input id="name" name="name" type="text" required value="{{ old('name', $service->name) }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" placeholder="Ex. Coiffure">
                        <i class="fas fa-concierge-bell absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1 relative">
                        <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" placeholder="Décrivez votre service...">{{ old('description', $service->description) }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                    <div class="mt-1 relative">
                        <input id="price" name="price" type="number" step="0.01" required value="{{ old('price', $service->price) }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" placeholder="Ex. 30.00">
                        <i class="fas fa-euro-sign absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <div class="mt-1 relative">
                        <input id="category" name="category" type="text" value="{{ old('category', $service->category) }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-gray-900 transition duration-300" placeholder="Ex. Beauté">
                        <i class="fas fa-tag absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="is_available" class="block text-sm font-medium text-gray-700">Disponible</label>
                    <div class="mt-1">
                        <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $service->is_available) ? 'checked' : '' }} class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </div>
                    @error('is_available')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-indigo-700 text-white py-3 rounded-full font-medium hover:bg-indigo-800 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">Mettre à jour le Service</button>
            </form>
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez vos services sur Reservez-Moi.">
    <meta name="keywords" content="services, service provider, réservations">
    <title>Mes Services - Reservez-Moi</title>
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

    <!-- Services Section -->
    <section class="min-h-screen pt-24 pb-10 bg-gradient-to-br from-indigo-100 to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-4xl font-bold text-gray-900">Mes Services</h2>
                <a href="{{ route('provider.services.create') }}" class="bg-indigo-700 text-white px-4 py-2 rounded-full font-medium hover:bg-indigo-800 transition duration-300 shadow-md hover:shadow-lg">
                    Ajouter un Service
                </a>
            </div>

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

            <!-- Liste des services -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($services as $service)
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-concierge-bell text-indigo-700 text-3xl mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $service->name }}</h3>
                        </div>
                        <p class="text-gray-600 mb-2">{{ $service->description }}</p>
                        <p class="text-gray-600 mb-2"><strong>Prix :</strong> {{ $service->price }} €</p>
                        <p class="text-gray-600 mb-2"><strong>Catégorie :</strong> {{ $service->category ?? 'Non spécifiée' }}</p>
                        <p class="text-gray-600 mb-4"><strong>Disponible :</strong> {{ $service->is_available ? 'Oui' : 'Non' }}</p>
                        <div class="flex space-x-3">
                            <a href="{{ route('provider.services.edit', $service) }}" class="bg-blue-600 text-white px-4 py-2 rounded-full font-medium hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg">
                                Modifier
                            </a>
                            <form action="{{ route('provider.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full font-medium hover:bg-red-700 transition duration-300 shadow-md hover:shadow-lg">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-600">
                        <p>Vous n'avez aucun service pour le moment. Ajoutez-en un !</p>
                    </div>
                @endforelse
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
<!-- resources/views/provider/availability/create_weekly.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajoutez une disponibilité hebdomadaire pour votre service sur Reservez-Moi.">
    <meta name="keywords" content="disponibilités, service provider, réservations">
    <title>Ajouter une disponibilité hebdomadaire - Reservez-Moi</title>
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
                    <a href="{{ route('provider.reservations') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Réservations
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
                    <a href="{{ route('provider.dashboard') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Tableau de bord</a>
                    <a href="{{ route('provider.services') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Mes Services</a>
                    <a href="{{ route('provider.reservations') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Réservations</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Déconnexion</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <section class="min-h-screen flex items-center justify-center pt-24 pb-10 bg-gradient-to-br from-indigo-100 to-gray-50">
        <div class="max-w-xl w-full bg-white p-8 rounded-3xl shadow-lg transform transition-all duration-500">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Ajouter une disponibilité hebdomadaire</h2>
            <p class="text-center text-gray-600 mb-8">Service : {{ $service->name }}</p>

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

            <!-- Form -->
            <form action="{{ route('provider.availability.store-weekly', $service->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700">Jour de la semaine</label>
                    <select id="day_of_week" name="day_of_week" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        <option value="" disabled selected>Sélectionnez un jour</option>
                        <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>Lundi</option>
                        <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>Mardi</option>
                        <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>Mercredi</option>
                        <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>Jeudi</option>
                        <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>Vendredi</option>
                        <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>Samedi</option>
                        <option value="0" {{ old('day_of_week') === '0' ? 'selected' : '' }}>Dimanche</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début</label>
                        <div class="mt-1 relative">
                            <input id="start_time" name="start_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('start_time') }}" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                        <div class="mt-1 relative">
                            <input id="end_time" name="end_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('end_time') }}" required>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="max_reservations" class="block text-sm font-medium text-gray-700">Nombre maximum de réservations</label>
                    <div class="mt-1 relative">
                        <input id="max_reservations" name="max_reservations" type="number" min="1" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('max_reservations', 1) }}" required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Combien de clients peuvent réserver ce créneau en même temps</p>
                </div>
                
                <div class="flex space-x-4 pt-4">
                    <button type="submit" class="flex-grow bg-indigo-700 text-white px-6 py-3 rounded-full font-medium hover:bg-indigo-800 transition duration-300 shadow-md hover:shadow-lg">
                        Ajouter cette disponibilité
                    </button>
                    <a href="{{ route('provider.availability.index', $service->id) }}" class="bg-gray-500 text-white px-6 py-3 rounded-full font-medium hover:bg-gray-600 transition duration-300 shadow-md hover:shadow-lg">
                        Annuler
                    </a>
                </div>
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

<!-- resources/views/provider/availability/create_specific.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajoutez une disponibilité pour une date spécifique sur Reservez-Moi.">
    <meta name="keywords" content="disponibilités, service provider, réservations">
    <title>Ajouter une disponibilité spécifique - Reservez-Moi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                    <a href="{{ route('provider.reservations') }}" class="text-gray-700 hover:text-indigo-700 font-medium text-lg transition duration-300 relative group">
                        Réservations
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
                    <a href="{{ route('provider.dashboard') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Tableau de bord</a>
                    <a href="{{ route('provider.services') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Mes Services</a>
                    <a href="{{ route('provider.reservations') }}" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Réservations</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="block text-gray-700 hover:text-indigo-700 font-medium text-lg">Déconnexion</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <section class="min-h-screen flex items-center justify-center pt-24 pb-10 bg-gradient-to-br from-indigo-100 to-gray-50">
        <div class="max-w-xl w-full bg-white p-8 rounded-3xl shadow-lg transform transition-all duration-500">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Ajouter une disponibilité spécifique</h2>
            <p class="text-center text-gray-600 mb-8">Service : {{ $service->name }}</p>

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

            <!-- Form -->
            <form action="{{ route('provider.availability.store-specific', $service->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="specific_date" class="block text-sm font-medium text-gray-700">Date spécifique</label>
                    <div class="mt-1 relative">
                        <input id="specific_date" name="specific_date" type="date" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('specific_date') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début</label>
                        <div class="mt-1 relative">
                            <input id="start_time" name="start_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('start_time') }}" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                        <div class="mt-1 relative">
                            <input id="end_time" name="end_time" type="time" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('end_time') }}" required>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input id="is_available_yes" name="is_available" type="radio" value="1" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('is_available', '1') == '1' ? 'checked' : '' }}>
                            <label for="is_available_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                Disponible (créneau spécial)
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="is_available_no" name="is_available" type="radio" value="0" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('is_available') == '0' ? 'checked' : '' }}>
                            <label for="is_available_no" class="ml-3 block text-sm font-medium text-gray-700">
                                Indisponible (exception)
                            </label>
                        </div>
                    </div>
                </div>
                
                <div id="max_reservations_container" class="{{ old('is_available') == '0' ? 'hidden' : '' }}">
                    <label for="max_reservations" class="block text-sm font-medium text-gray-700">Nombre maximum de réservations</label>
                    <div class="mt-1 relative">
                        <input id="max_reservations" name="max_reservations" type="number" min="1" class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('max_reservations', 1) }}">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Combien de clients peuvent réserver ce créneau en même temps</p>
                </div>
                
                <div class="flex space-x-4 pt-4">
                    <button type="submit" class="flex-grow bg-indigo-700 text-white px-6 py-3 rounded-full font-medium hover:bg-indigo-800 transition duration-300 shadow-md hover:shadow-lg">
                        Ajouter cette disponibilité
                    </button>
                    <a href="{{ route('provider.availability.index', $service->id) }}" class="bg-gray-500 text-white px-6 py-3 rounded-full font-medium hover:bg-gray-600 transition duration-300 shadow-md hover:shadow-lg">
                        Annuler
                    </a>
                </div>
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

        // Toggle max_reservations field visibility based on is_available radio buttons
        const isAvailableYes = document.getElementById('is_available_yes');
        const isAvailableNo = document.getElementById('is_available_no');
        const maxReservationsContainer = document.getElementById('max_reservations_container');

        isAvailableYes.addEventListener('change', function() {
            if (this.checked) {
                maxReservationsContainer.classList.remove('hidden');
            }
        });

        isAvailableNo.addEventListener('change', function() {
            if (this.checked) {
                maxReservationsContainer.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
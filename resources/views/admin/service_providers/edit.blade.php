<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modifier un prestataire de services - Reservez-Moi">
    <meta name="keywords" content="admin, service provider, édition">
    <title>Modifier un Prestataire - Reservez-Moi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
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

    <!-- Main Content -->
    <main class="flex-grow pt-20 pb-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Modifier un Prestataire de Services</h2>
                    <p class="mt-1 text-sm text-gray-500">Modifiez les informations de {{ $user->name }}</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
                </a>
            </div>

            <!-- Formulaire d'édition -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Informations du prestataire</h3>
                    <p class="text-gray-500 text-sm mt-1">Tous les champs marqués d'un astérisque (*) sont obligatoires</p>
                </div>

                <form action="{{ route('admin.service_providers.update', $user->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-700 p-4 rounded-lg border-l-4 border-red-500">
                            <div class="font-medium">Des erreurs se sont produites :</div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Nom du prestataire -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                        <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            value="{{ old('name', $user->name) }}" required autofocus>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email *</label>
                        <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Mot de passe (optionnel lors de l'édition) -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            placeholder="Laissez vide pour conserver le mot de passe actuel">
                        <p class="mt-1 text-sm text-gray-500">Minimum 8 caractères. Laissez vide si vous ne souhaitez pas changer le mot de passe.</p>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            placeholder="Laissez vide pour conserver le mot de passe actuel">
                    </div>

                    <!-- Informations supplémentaires (facultatives) -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
                        <input type="text" name="phone" id="phone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            value="{{ old('phone', $user->phone ?? '') }}" placeholder="Facultatif">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse professionnelle</label>
                        <textarea name="address" id="address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            placeholder="Facultatif">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>

                    <!-- Services actuels -->
                    @if ($user->services->count() > 0)
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Services proposés</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <ul class="divide-y divide-gray-200">
                                    @foreach ($user->services as $service)
                                        <li class="py-2 flex justify-between items-center">
                                            <div>
                                                <p class="font-medium">{{ $service->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $service->price }} € - {{ $service->category ?? 'Non catégorisé' }}</p>
                                            </div>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $service->is_available ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $service->is_available ? 'Disponible' : 'Non disponible' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <i class="fas fa-calendar-check text-indigo-400 text-xl"></i>
                    <span class="text-xl font-bold text-white">Reservez-Moi</span>
                </div>
                <p class="text-sm">© {{ date('Y') }} Reservez-Moi. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const isOpen = !mobileMenu.classList.contains('hidden');
                menuBtn.setAttribute('aria-expanded', isOpen);
                menuBtn.innerHTML = isOpen ? '<i class="fas fa-times text-2xl"></i>' : '<i class="fas fa-bars text-2xl"></i>';
            });
        }
        
        // Add shadow to navbar on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>
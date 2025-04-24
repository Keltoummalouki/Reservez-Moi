<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modifier un prestataire de services">
    <meta name="keywords" content="prestataire, services, admin">
    <title>Modifier un Prestataire</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">
                                Admin Panel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Modifier un Prestataire</h1>
                        <a href="{{ route('admin.service_providers') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.service_providers.update', $provider) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informations personnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700">Informations personnelles</h2>
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $provider->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $provider->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $provider->phone) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse professionnelle *</label>
                                <textarea name="address" id="address" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $provider->address) }}</textarea>
                            </div>
                        </div>

                        <!-- Informations de connexion -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700">Informations de connexion</h2>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Laissez vide pour ne pas changer le mot de passe</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Informations professionnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700">Informations professionnelles</h2>
                            
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $provider->company_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="siret" class="block text-sm font-medium text-gray-700">Numéro SIRET</label>
                                <input type="text" name="siret" id="siret" value="{{ old('siret', $provider->siret) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $provider->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Compte actif
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.service_providers') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 
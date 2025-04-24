<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajouter un nouveau service">
    <meta name="keywords" content="service, admin">
    <title>Ajouter un Service</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">Ajouter un Service</h1>
                        <a href="{{ route('admin.services') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
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

                    <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Informations du service -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700">Informations du service</h2>
                            
                            <div>
                                <label for="provider_id" class="block text-sm font-medium text-gray-700">Prestataire *</label>
                                <select name="provider_id" id="provider_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez un prestataire</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Prix (€) *</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Durée (minutes) *</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie *</label>
                                <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Service actif
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.services') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                                Créer le service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 
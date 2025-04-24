@extends('layouts.admin')

@section('title', 'Gestion des Prestataires')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Gestion des Prestataires</h1>
            <a href="{{ route('admin.service_providers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i> Ajouter un prestataire
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse ($serviceProviders as $provider)
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-building text-gray-400 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-lg font-medium text-gray-900">{{ $provider->name }}</h2>
                                        <p class="text-sm text-gray-500">{{ $provider->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('admin.service_providers.show', $provider) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.service_providers.edit', $provider) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.service_providers.destroy', $provider) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce prestataire ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-phone mr-1.5"></i>
                                        {{ $provider->phone ?? 'Non renseigné' }}
                                    </p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <i class="fas fa-map-marker-alt mr-1.5"></i>
                                        {{ $provider->address ?? 'Non renseignée' }}
                                    </p>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                    <i class="fas fa-calendar-alt mr-1.5"></i>
                                    <p>Inscrit le {{ $provider->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6">
                        <div class="text-center text-gray-500">
                            Aucun prestataire n'a été trouvé.
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">
            {{ $serviceProviders->links() }}
        </div>
    </div>
</div>
@endsection 
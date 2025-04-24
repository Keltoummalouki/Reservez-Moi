@extends('layouts.admin')

@section('title', 'Détails du Prestataire')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Détails du Prestataire</h1>
                <p class="mt-1 text-sm text-gray-500">Informations complètes sur le prestataire</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.service_providers.edit', $provider) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('admin.service_providers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Informations du prestataire
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Nom complet
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->name }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->email }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Téléphone
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->phone ?? 'Non renseigné' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Adresse
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->address ?? 'Non renseignée' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date d'inscription
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->created_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Dernière mise à jour
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $provider->updated_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Services du prestataire -->
        <div class="mt-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Services proposés
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($provider->services as $service)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $service->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $service->description }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900">{{ $service->price }} €</p>
                                        <p class="text-sm text-gray-500">{{ $service->duration }} minutes</p>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6">
                                <div class="text-center text-gray-500">
                                    Aucun service n'a été trouvé.
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
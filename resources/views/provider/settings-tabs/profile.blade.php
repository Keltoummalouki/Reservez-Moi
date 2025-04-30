<div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
    <p class="mt-1 text-sm text-gray-500">Mettez à jour vos informations personnelles</p>
</div>
<form action="{{ route('provider.settings.update-profile') }}" method="POST" class="p-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="flex flex-col sm:flex-row gap-6">
        <!-- Profile Picture -->
        <div class="flex flex-col items-center space-y-4">
            <div class="relative">
                <div class="h-32 w-32 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 overflow-hidden">
                    @if(isset($provider) && $provider->profile_picture)
                        <img src="{{ asset('storage/' . $provider->profile_picture) }}" alt="Photo de profil" class="h-full w-full object-cover">
                    @else
                        <i class="fas fa-user text-5xl"></i>
                    @endif
                </div>
                <label for="profile_picture" class="absolute bottom-0 right-0 bg-primary-600 text-white p-2 rounded-full cursor-pointer hover:bg-primary-700 transition-colors">
                    <i class="fas fa-camera"></i>
                    <span class="sr-only">Changer la photo</span>
                </label>
                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
            </div>
            <p class="text-xs text-gray-500">Cliquez sur l'icône pour changer votre photo</p>
        </div>
        <!-- Personal Information -->
        <div class="flex-1 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $provider->first_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $provider->last_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $provider->phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                <textarea name="bio" id="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('bio', $provider->bio ?? '') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Brève description qui apparaîtra sur votre profil public</p>
            </div>
        </div>
    </div>
    <div class="pt-5 border-t border-gray-200 flex justify-end">
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Enregistrer les modifications
        </button>
    </div>
</form> 
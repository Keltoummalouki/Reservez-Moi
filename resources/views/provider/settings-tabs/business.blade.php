<div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900">Informations professionnelles</h2>
    <p class="mt-1 text-sm text-gray-500">Configurez les détails de votre activité professionnelle</p>
</div>
<form action="{{ route('provider.settings.update-business') }}" method="POST" class="p-6 space-y-6">
    @csrf
    @method('PATCH')
    <div class="space-y-4">
        <div>
            <label for="business_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
            <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $provider->business_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div>
            <label for="business_type" class="block text-sm font-medium text-gray-700">Type d'activité</label>
            <select name="business_type" id="business_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option value="">Sélectionnez un type</option>
                <option value="Médical" {{ old('business_type', $provider->business_type ?? '') == 'Médical' ? 'selected' : '' }}>Médical</option>
                <option value="Juridique" {{ old('business_type', $provider->business_type ?? '') == 'Juridique' ? 'selected' : '' }}>Juridique</option>
                <option value="Beauté & Spa" {{ old('business_type', $provider->business_type ?? '') == 'Beauté & Spa' ? 'selected' : '' }}>Beauté & Spa</option>
                <option value="Hôtel" {{ old('business_type', $provider->business_type ?? '') == 'Hôtel' ? 'selected' : '' }}>Hôtel</option>
                <option value="Restaurant" {{ old('business_type', $provider->business_type ?? '') == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                <option value="Autre" {{ old('business_type', $provider->business_type ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>
        <div>
            <label for="business_description" class="block text-sm font-medium text-gray-700">Description de l'activité</label>
            <textarea name="business_description" id="business_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('business_description', $provider->business_description ?? '') }}</textarea>
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $provider->address ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <input type="text" name="city" id="city" value="{{ old('city', $provider->city ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $provider->postal_code ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                <select name="country" id="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <option value="France" {{ old('country', $provider->country ?? '') == 'France' ? 'selected' : '' }}>France</option>
                    <option value="Belgique" {{ old('country', $provider->country ?? '') == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                    <option value="Suisse" {{ old('country', $provider->country ?? '') == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                    <option value="Canada" {{ old('country', $provider->country ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                    <option value="Autre" {{ old('country', $provider->country ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>
        </div>
        <div>
            <label for="website" class="block text-sm font-medium text-gray-700">Site web</label>
            <input type="url" name="website" id="website" value="{{ old('website', $provider->website ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="siret" class="block text-sm font-medium text-gray-700">Numéro SIRET</label>
                <input type="text" name="siret" id="siret" value="{{ old('siret', $provider->siret ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="vat_number" class="block text-sm font-medium text-gray-700">Numéro de TVA</label>
                <input type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', $provider->vat_number ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
        </div>
    </div>
    <div class="pt-5 border-t border-gray-200 flex justify-end">
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Enregistrer les modifications
        </button>
    </div>
</form> 
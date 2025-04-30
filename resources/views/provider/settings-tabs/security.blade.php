<div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900">Sécurité</h2>
    <p class="mt-1 text-sm text-gray-500">Gérez votre mot de passe et la sécurité de votre compte</p>
</div>
<div class="p-6 space-y-6">
    <!-- Change Password Form -->
    <form action="{{ route('provider.settings.update-security') }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')
        <h3 class="text-base font-medium text-gray-900">Changer le mot de passe</h3>
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
            <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Mettre à jour le mot de passe
            </button>
        </div>
    </form>
    <div class="pt-6 border-t border-gray-200">
        <h3 class="text-base font-medium text-gray-900 mb-4">Authentification à deux facteurs</h3>
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="two_factor" name="two_factor" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
            </div>
            <div class="ml-3 text-sm">
                <label for="two_factor" class="font-medium text-gray-700">Activer l'authentification à deux facteurs</label>
                <p class="text-gray-500">Ajoutez une couche de sécurité supplémentaire à votre compte en exigeant plus qu'un mot de passe pour vous connecter.</p>
            </div>
        </div>
        <div class="mt-4 pl-7 hidden" id="two-factor-setup">
            <p class="text-sm text-gray-500 mb-4">Scannez le code QR ci-dessous avec votre application d'authentification préférée (comme Google Authenticator, Authy, etc.).</p>
            <div class="bg-gray-100 p-4 rounded-md flex justify-center mb-4">
                <div class="h-40 w-40 bg-white p-2 rounded-md">
                    <!-- QR Code placeholder -->
                    <div class="h-full w-full border-2 border-dashed border-gray-300 rounded flex items-center justify-center text-gray-400">
                        <span>QR Code</span>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="verification_code" class="block text-sm font-medium text-gray-700">Code de vérification</label>
                <input type="text" name="verification_code" id="verification_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Entrez le code à 6 chiffres">
            </div>
            <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Vérifier et activer
            </button>
        </div>
    </div>
</div> 
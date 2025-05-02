<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte suspendu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2 text-gray-800">Votre profil est suspendu</h1>
        <p class="mb-4 text-gray-600">Votre compte prestataire a été suspendu par l'administration.<br>
        Pour toute question ou pour demander la réactivation, veuillez contacter le support.</p>
        <div class="mb-6">
            <a href="mailto:support@reservez-moi.com" class="text-blue-600 hover:underline font-semibold">support@reservez-moi.com</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-gray-800 text-white font-bold py-2 rounded hover:bg-gray-900 transition">Se déconnecter</button>
        </form>
    </div>
</body>
</html> 
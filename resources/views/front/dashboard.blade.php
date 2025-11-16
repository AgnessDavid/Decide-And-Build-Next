<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - CARTE-CIGN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Tableau de bord</h1>
                <form method="POST" action="{{ route('online.logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Déconnexion
                    </button>
                </form>
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-lg">Bienvenue, <strong>{{ Auth::guard('online')->user()->name }}</strong> !</p>
                <p class="text-gray-600">{{ Auth::guard('online')->user()->email }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Profil</h3>
                    <p class="text-gray-600">Gérez vos informations personnelles</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Commandes</h3>
                    <p class="text-gray-600">Consultez votre historique</p>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline">← Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>
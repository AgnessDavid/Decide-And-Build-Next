<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CARTE-CIGN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Connexion</h2>
        
        <form method="POST" action="{{ route('online.login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required autofocus>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-2">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
            </div>
            
            <div class="mb-6 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700">Se souvenir de moi</label>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                Se connecter
            </button>
        </form>
        
        <p class="mt-6 text-center text-gray-600">
            Pas de compte ? 
            <a href="{{ route('online.register') }}" class="text-blue-500 hover:underline">S'inscrire</a>
        </p>
        
        <p class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">← Retour à l'accueil</a>
        </p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Paiement Wave - Cartologue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navigation simplifiée -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('accueil') }}" class="text-2xl font-semibold text-gray-500">Cartologue</a>
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('accueil') }}" class="text-gray-500 hover:text-blue-500 transition">Accueil</a>
                    <a href="{{ route('boutique') }}" class="text-gray-500 hover:text-blue-500 transition">Boutique</a>
                    <a href="{{ route('panier') }}" class="text-gray-500 hover:text-blue-500 transition">Panier</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <section class="pt-32 pb-12">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">Paiement Wave confirmé !</h1>
            <p class="text-gray-700 mb-6">
                Nous avons bien reçu votre paiement pour la commande 
                <span class="font-semibold">{{ $commande->numero_commande ?? '-' }}</span>.
            </p>

            <p class="text-gray-700 mb-6">
                Montant payé : 
                <span class="font-semibold">{{ number_format($commande->total_ttc ?? 0, 2, ',', ' ') }} FCFA</span>
            </p>

            <a href="{{ route('accueil') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition">
               Retour à l'accueil
            </a>
        </div>
    </section>

    <!-- Footer simplifié -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">&copy; 2025 Cartologue. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>

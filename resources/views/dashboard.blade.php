<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bonjour, {{ auth()->user()->name }} !
            </h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 px-4 py-3 rounded bg-red-100 border border-red-400 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Dashboard Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Commandes</h3>
                    <p class="text-3xl mt-2 font-bold text-blue-600">{{ $commandesCount ?? 0 }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Panier total</h3>
                    <p class="text-3xl mt-2 font-bold text-blue-600">€{{ number_format($panierTotal ?? 0, 2) }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Dernier produit ajouté</h3>
                    <p class="text-gray-600 mt-2">{{ $dernierProduit->nom_produit ?? 'Aucun produit' }}</p>
                </div>
            </div>

            {{-- Section "Informations utilisateur" --}}
            <div class="mt-8 bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Informations de votre compte</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <p><span class="font-medium">Nom :</span> {{ auth()->user()->name }}</p>
                    <p><span class="font-medium">Email :</span> {{ auth()->user()->email }}</p>
                    <p><span class="font-medium">Date d'inscription :</span> {{ auth()->user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- Section "Dernières actions" --}}
            <div class="mt-8 bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Dernières actions</h2>
                <ul class="space-y-2 text-gray-600">
                    @forelse($derniersActions ?? [] as $action)
                        <li>{{ $action }}</li>
                    @empty
                        <li>Aucune action récente</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>

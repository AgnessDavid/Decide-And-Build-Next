<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - Cartologue</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Feather icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Alpine.js (utilisé pour x-data / x-show dans le template) -->
    <script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>

    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
        .transition-all { transition: all .25s ease; }
        /* flyout cart */
        .flyout-enter { transform: translateX(100%); }
        .flyout-enter-active { transform: translateX(0); transition: transform .28s ease-out;}
        .flyout-leave { transform: translateX(0); }
        .flyout-leave-active { transform: translateX(100%); transition: transform .22s ease-in;}
        /* simple badge */
        .badge-yellow { background: linear-gradient(90deg,#f6c84c,#f59e0b); }
    </style>
</head>
<body class="font-sans bg-gray-50">





<!-- HEADER / NAV -->
<header class="bg-white shadow fixed w-full z-50">
    <div class="mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('accueil') }}" class="flex items-center">
                    <span class="text-2xl font-semibold text-gray-700">Cartologue</span>
                </a>

                <!-- Main nav (desktop) -->
                <nav class="hidden md:flex items-center gap-3">
                    <a href="{{ route('accueil') }}" class="py-2 px-3 text-blue-600 border-b-2 border-blue-600 font-semibold">Accueil</a>
                    <a href="{{ route('boutique') }}" class="py-2 px-3 hover:text-blue-600">Boutique</a>
                    <a href="{{ route('panier') }}" class="py-2 px-3 hover:text-blue-600">Panier</a>
                    <a href="{{ route('contact') }}" class="py-2 px-3 hover:text-blue-600">Contact</a>
                </nav>
            </div>

       <!-- Search -->
        <div class="flex-1 max-w-xl px-4 hidden md:block">
          <div class="relative">
            <input id="searchInput" type="search" placeholder="Rechercher une carte, lieu, époque..." class="w-full rounded-full border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" />
            <button id="searchBtn" class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2">
              <i data-feather="search" class="w-4 h-4"></i>
            </button>

            <!-- search suggestions (simulated) -->
            <div id="searchSuggestions" class="hidden absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">
              <ul id="suggestList" class="divide-y"></ul>
            </div>
          </div>
        </div>




 <div class="flex items-center gap-3">
          <div class="hidden md:flex items-center gap-2">

@auth
    <div class="relative group">
        <button class="flex items-center space-x-2 px-3 py-1 text-gray-600 hover:bg-gray-100 rounded">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                     class="w-6 h-6 rounded-full" 
                     alt="{{ Auth::user()->name }}">
            @else
                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <span>{{ Auth::user()->name ?? 'Client' }}</span>
        </button>
        
        <!-- Menu déroulant -->
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Mon profil
            </a>
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Tableau de bord
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
@else

    <a href="{{ route('login') }}" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded">
        Connexion
    </a>
  <!-- <a href="{{ route('register') }}" class="px-3 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded ml-2">
        Inscription
    </a> -->
@endauth

          <!--  <a href="{{ route('register') }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Inscription</a> -->
          </div>


  

                <button id="cartToggle" aria-label="Ouvrir le panier" class="relative p-2 rounded-full hover:bg-gray-100">
    <i data-feather="shopping-cart" class="w-5 h-5 text-gray-700"></i>
    <span id="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">0</span>
</button>




                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobileBtn" class="p-2 rounded hover:bg-gray-100">
                        <i data-feather="menu" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>


            
        </div>
    </div>

    <!-- mobile menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-3 flex flex-col gap-2">
            <a href="{{ route('accueil') }}" class="py-2">Accueil</a>
            <a href="{{ route('boutique') }}" class="py-2">Boutique</a>
            <a href="{{ route('panier') }}" class="py-2">Panier</a>
            <a href="{{ route('contact') }}" class="py-2">Contact</a>
        </div>
    </div>
</header>

<!-- FLYOUT CART -->
<!-- 🛒 ASIDE PANIER (en dehors de la section) -->
<aside id="panier-aside"
       class="fixed top-0 right-0 w-80 h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-4 flex flex-col h-full">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="text-xl font-semibold">Mon panier</h3>
            <button id="fermer-panier" class="p-2 rounded hover:bg-gray-200">
                <i data-feather="x"></i>
            </button>
        </div>

        <div id="contenu-panier" class="flex-1 mt-4 overflow-auto">
            <p class="text-gray-500 text-center mt-12">Votre panier est vide.</p>
        </div>

        <div class="border-t pt-4">
            <a href="{{ route('panier') }}" class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition">Voir le panier</a>
        </div>
    </div>
</aside>
@if(session('success') || session('error'))
    @php
        $type = session('success') ? 'success' : 'error';
        $bg = $type === 'success' ? 'bg-green-500' : 'bg-red-500';
    @endphp
    <div id="flashMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 {{ $bg }} text-white px-6 py-3 rounded shadow-lg z-50">
        <i data-feather="{{ $type === 'success' ? 'check-circle' : 'alert-circle' }}" class="inline w-5 h-5 mr-2"></i>
        {{ session($type) }}
        <button onclick="document.getElementById('flashMessage').remove()" class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
    </div>
@endif






<section>

    <div class="bg-gray-800 text-white py-12 pt-20 mb-20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
        
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-4 md:mb-0" data-aos="fade-right">
          Notre collection de cartes
        </h1>
 
 


      </div>
    </div>


    
</section>
<!-- Shop Header -->


<!-- Products Grid -->

        <!-- Section filtre -->
<div class="min-h-screen ">
    <div class="flex flex-col lg:flex-row gap-8 w-full max-w-[100vw]">
        
        <!-- Barre latérale des filtres (petite partie à gauche) -->
        <div class="lg:w-1/4" data-aos="fade-right">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24 h-fit">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Filtres</h3>
                
                <form method="GET" action="{{ route('boutique') }}" class="space-y-6">
                    
                    <!-- Catégories -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catégories</label>
                        <select name="categorie" onchange="this.form.submit()"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-800 py-2 px-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->categorie }}" {{ request('categorie') == $categorie->categorie ? 'selected' : '' }}>
                                    {{ $categorie->categorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tri par prix -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Trier par prix</label>
                        <select name="tri" onchange="this.form.submit()"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-800 py-2 px-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <option value="">Aucun tri</option>
                            <option value="prix_croissant" {{ request('tri') == 'prix_croissant' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="prix_decroissant" {{ request('tri') == 'prix_decroissant' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>

                    <!-- Bouton Appliquer -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition transform hover:scale-105">
                            Appliquer les filtres
                        </button>
                    </div>

                    <!-- Bouton Réinitialiser -->
                    <div>
                        <a href="{{ route('boutique') }}" 
                           class="w-full bg-gray-200 text-gray-700 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition text-center block">
                            Réinitialiser
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- Section des produits (grande partie à droite) -->
        <div class="lg:w-3/4 w-full">
            <!-- En-tête mobile avec bouton filtre pour les petits écrans -->
            <div class="lg:hidden mb-6" data-aos="fade-left">
                <div class="relative" x-data="{ open: false }">
                    <!-- Bouton Filtre Mobile -->
                    <button @click="open = !open"
                            class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-base font-medium hover:bg-blue-700 transition transform hover:scale-105 w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        <span>Filtres</span>
                    </button>

                    <!-- Menu déroulant Mobile -->
                    <div x-show="open"
                         x-transition
                         @click.away="open = false"
                         class="absolute top-full left-0 right-0 mt-2 w-full bg-white text-gray-800 rounded-xl shadow-lg z-50 p-4 space-y-4">
                        <!-- Le même formulaire que dans la sidebar -->
                        <form method="GET" action="{{ route('boutique') }}" class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Catégories</label>
                                <select name="categorie" onchange="this.form.submit()"
                                        class="w-full bg-gray-100 border border-gray-300 text-gray-800 py-2 px-3 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->categorie }}" {{ request('categorie') == $categorie->categorie ? 'selected' : '' }}>
                                            {{ $categorie->categorie }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Trier par prix</label>
                                <select name="tri" onchange="this.form.submit()"
                                        class="w-full bg-gray-100 border border-gray-300 text-gray-800 py-2 px-3 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    <option value="">Aucun</option>
                                    <option value="prix_croissant" {{ request('tri') == 'prix_croissant' ? 'selected' : '' }}>Prix croissant</option>
                                    <option value="prix_decroissant" {{ request('tri') == 'prix_decroissant' ? 'selected' : '' }}>Prix décroissant</option>
                                </select>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                Appliquer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Grille des produits -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                @foreach($produits as $produit)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all card-hover w-full" data-aos="fade-up">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $produit->photo) }}" class="h-48 w-full object-cover" alt="{{ $produit->nom_produit }}">

                            @if($produit->est_en_promotion && $produit->prix_promotion)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    -{{ round(100 - ($produit->prix_promotion / $produit->prix_unitaire_ht * 100)) }}%
                                </div>
                            @elseif($produit->nouveau ?? false)
                                <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    Nouveau
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $produit->nom_produit }}</h3>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $produit->description }}</p>
                            
                            <p class="text-sm text-gray-600 mb-3">État : {{ $produit->etat_conservation }}</p>

                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    @php
                                        $prixAffiche = ($produit->est_en_promotion && $produit->prix_promotion) 
                                                      ? $produit->prix_promotion 
                                                      : $produit->prix_unitaire_ht;
                                    @endphp
                                    <span class="text-lg font-bold text-blue-600">{{ $prixAffiche }} FCFA</span>
                                    @if($produit->est_en_promotion && $produit->prix_promotion)
                                        <span class="text-sm text-gray-500 line-through ml-2">{{ $produit->prix_unitaire_ht }} FCFA</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-between items-center gap-2">
                                <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition duration-300 w-full flex items-center justify-center gap-2">
                                        <i data-feather="shopping-cart" class="w-4 h-4"></i>
                                        <span class="text-sm">Ajouter</span>
                                    </button>
                                </form>

                                <a href="{{ route('boutique.show', $produit->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition duration-300 flex items-center gap-2 text-sm">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                    <span>Détails</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12 w-full" data-aos="fade-up">
                {{ $produits->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Newsletter -->
<section class="py-12 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">Abonnez-vous à notre newsletter</h2>
        <p class="mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Recevez nos offres spéciales et découvrez nos nouvelles collections en avant-première</p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto" data-aos="fade-up" data-aos-delay="200">
            <input type="email" placeholder="Votre email" class="flex-grow px-4 py-2 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300">
            <button type="submit" class="bg-white text-blue-600 font-semibold px-6 py-2 rounded hover:bg-gray-100 transition duration-300">
                S'abonner
            </button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-semibold mb-4">Cartologue</h3>
                <p class="text-gray-400">Votre boutique en ligne de cartes anciennes, modernes et personnalisées.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('accueil') }}" class="text-gray-400 hover:text-white transition duration-300">Accueil</a></li>
                    <li><a href="{{ route('boutique') }}" class="text-gray-400 hover:text-white transition duration-300">Boutique</a></li>
                    <li><a href="{{ route('panier') }}" class="text-gray-400 hover:text-white transition duration-300">Panier</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition duration-300">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Compte</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition duration-300">Connexion</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition duration-300">Inscription</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Mon compte</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Suivi de commande</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2">
                    <li class="flex items-center"><i data-feather="mail" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">contact@decideandbuild.ci</span></li>
                    <li class="flex items-center"><i data-feather="phone" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">+225 07 17 41 74 60</span></li>
                    <li class="flex items-center"><i data-feather="phone" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">+225 27 33 75 90 20</span></li>
                    <li class="flex items-center"><i data-feather="map-pin" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">Cocody, Sipim 4</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2023 Cartologue. Tous droits réservés.</p>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i data-feather="facebook" class="w-5 h-5"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i data-feather="twitter" class="w-5 h-5"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i data-feather="instagram" class="w-5 h-5"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i data-feather="linkedin" class="w-5 h-5"></i></a>
            </div>
        </div>
    </div>
</footer>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function() {


    /* ================================
       FLYOUT PANIER
    =================================*/
    const cartToggle = document.getElementById('cartToggle');
    const flyoutCart = document.getElementById('flyoutCart');
    const closeCart = document.getElementById('closeCart');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartSubtotal = document.getElementById('cartSubtotal');

    // Ouvrir le flyout
    cartToggle?.addEventListener('click', () =>
        flyoutCart?.classList.remove('translate-x-full')
    );

    // Fermer le flyout
    closeCart?.addEventListener('click', () =>
        flyoutCart?.classList.add('translate-x-full')
    );

    // Fonction d’affichage du panier
    function renderCart(panier = {}) {
        if (!cartItemsContainer || !cartSubtotal) return;

        let html = '';
        let total = 0;

        if (Object.keys(panier).length === 0) {
            html = '<p class="text-center text-gray-500 mt-12">Votre panier est vide.</p>';
        } else {
            for (const id in panier) {
                const item = panier[id];
                total += item.prix * item.quantite;
                html += `
                    <div class="flex items-center gap-4 border-b py-2">
                        <img src="${item.photo}" alt="${item.nom}" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h4 class="font-semibold">${item.nom}</h4>
                            <p class="text-gray-600 text-sm">${item.quantite} × ${item.prix} FCFA</p>
                        </div>
                    </div>
                `;
            }
        }

        cartItemsContainer.innerHTML = html;
        cartSubtotal.textContent = total.toLocaleString() + ' FCFA';
    }

    // Charger le panier
    fetch('/panier/json')
        .then(res => res.json())
        .then(data => renderCart(data.panier))
        .catch(err => console.error('Erreur chargement panier:', err));

    /* ================================
       COMPTEUR DU PANIER
    =================================*/
    function updateCartCount() {
        fetch("{{ route('panier.count') }}")
            .then(res => res.json())
            .then(data => {
                const countElem = document.getElementById('cartCount');
                if (countElem) countElem.textContent = data.count;
            })
            .catch(err => console.error('Erreur compteur panier:', err));
    }

    updateCartCount();

    /* ================================
       AJOUT AU PANIER
    =================================*/
    document.querySelectorAll('form.add-to-cart').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new FormData(this)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    renderCart(data.panier);
                    alert('Produit ajouté au panier !');
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(err => {
                console.error('Erreur ajout panier:', err);
                alert('Une erreur est survenue');
            });
        });
    });

    /* ================================
       RECHERCHE DES PRODUITS
    =================================*/
    if (typeof jQuery !== 'undefined') {
        $('#searchInput').on('keyup', function () {
            let query = $(this).val();

            if (query.length >= 2) {
                $.ajax({
                    url: "{{ route('produits.recherche') }}",
                    type: "GET",
                    data: { q: query },
                    success: function (data) {
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(produit => {
                                html += `
                                    <a href="/produits/${produit.id}" class="block px-4 py-2 hover:bg-gray-100 border-b">
                                        ${produit.nom_produit}
                                    </a>`;
                            });
                        } else {
                            html = '<p class="px-4 py-2 text-gray-500">Aucun produit trouvé</p>';
                        }

                        $('#searchSuggestions').html(html).removeClass('hidden');
                    }
                });
            } else {
                $('#searchSuggestions').html('').addClass('hidden');
            }
        });

        // Cacher les résultats si clic extérieur
        $(document).click(function (e) {
            if (!$(e.target).closest('#searchInput, #searchSuggestions').length) {
                $('#searchSuggestions').addClass('hidden');
            }
        });

        $('#searchBtn').on('click', function () {
            $('#searchInput').trigger('keyup');
        });
    }

    /* ================================
       INIT AOS + FEATHER
    =================================*/
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }

    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Année automatique dans footer
    const yearElem = document.getElementById('year');
    if (yearElem) yearElem.textContent = new Date().getFullYear();

});

/* ================================
   MOBILE MENU
=================================*/
const mobileBtn = document.getElementById('mobileBtn');
const mobileMenu = document.getElementById('mobileMenu');

mobileBtn?.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});
</script>


</body>
</html>

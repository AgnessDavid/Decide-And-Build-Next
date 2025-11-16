<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produit->nom }} - Cartologue</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Feather icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <!-- CSRF Token pour les requêtes AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        /* Disabled button */
        .btn-disabled { opacity: 0.6; cursor: not-allowed; }
    </style>
</head>
<body class="font-sans bg-gray-50">

<!-- Header avec navigation -->
<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('accueil') }}" class="text-2xl font-bold text-blue-600">Cartologue</a>
            
            <!-- Navigation links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('accueil') }}" class="text-gray-700 hover:text-blue-600 transition duration-300">Accueil</a>
                <a href="{{ route('boutique') }}" class="text-gray-700 hover:text-blue-600 transition duration-300">Boutique</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 transition duration-300">Contact</a>
            </div>
            
            <!-- Cart and Auth -->
            <div class="flex items-center space-x-4">
                <!-- Panier avec compteur -->
                <div class="relative">
                    <button id="cartToggle" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300">
                        <i data-feather="shopping-cart" class="w-5 h-5"></i>
                        <span id="cartCount" class="ml-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </button>
                </div>
                
                <!-- Auth links -->
                @auth
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition duration-300">Mon compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition duration-300">Connexion</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- Flyout Panier -->
<div id="flyoutCart" class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="flex flex-col h-full">
        <!-- Header du panier -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Votre Panier</h3>
            <button id="closeCart" class="text-gray-500 hover:text-gray-700">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <!-- Contenu du panier -->
        <div id="cartItemsContainer" class="flex-1 overflow-y-auto p-4">
            <!-- Les articles du panier seront chargés ici par JavaScript -->
            <p id="emptyMsg" class="text-center text-gray-500 mt-12">Votre panier est vide.</p>
        </div>
        
        <!-- Footer du panier -->
        <div class="border-t p-4">
            <div class="flex justify-between mb-4">
                <span class="font-semibold">Sous-total:</span>
                <span id="cartSubtotal" class="font-semibold">0 FCFA</span>
            </div>
            <a href="{{ route('panier') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-300">
                Voir le panier
            </a>
        </div>
    </div>
</div>

<!-- Overlay pour le panier -->
<div id="cartOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<main class="container mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 gap-8">
        {{-- Image du produit --}}
        <div class="relative">
            @if($produit->photo)
                <img src="{{ asset('storage/' . $produit->photo) }}"
                     alt="{{ $produit->nom_produit }}"
                     class="w-full h-96 object-cover rounded-lg shadow-lg"
                     data-aos="fade-right">
            @else
                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-96 flex items-center justify-center"
                     data-aos="fade-right">
                    <i data-feather="image" class="w-16 h-16 text-gray-400"></i>
                </div>
            @endif

            {{-- Badges : Promotion ou Nouveau --}}
            @if($produit->est_en_promotion && $produit->prix_promotion)
                <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                    -{{ round(100 - ($produit->prix_promotion / $produit->prix_unitaire_ht * 100)) }}%
                </div>
            @elseif($produit->nouveau ?? false)
                <div class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                    Nouveau
                </div>
            @endif
        </div>

        {{-- Détails du produit --}}
        <div data-aos="fade-left">
            <h1 class="text-3xl font-bold mb-3 text-gray-800">{{ $produit->nom_produit }}</h1>

            {{-- Prix --}}
            <div class="mb-4">
                @php
                    $prixAffiche = ($produit->est_en_promotion && $produit->prix_promotion)
                                   ? $produit->prix_promotion
                                   : $produit->prix_unitaire_ht;
                @endphp

                <span class="text-3xl font-bold text-blue-600">
                    {{ number_format($prixAffiche, 0, ',', ' ') }} FCFA
                </span>

                @if($produit->est_en_promotion && $produit->prix_promotion)
                    <span class="text-lg text-gray-500 line-through ml-3">
                        {{ number_format($produit->prix_unitaire_ht, 0, ',', ' ') }} FCFA
                    </span>
                @endif
            </div>

            {{-- Stock --}}
            @php
                $stock = $produit->stock_actuel ?? 0;
                $stockMin = $produit->stock_minimum ?? 5;
            @endphp

            <div class="mb-5 flex items-center">
                @if($stock <= 0)
                    <i data-feather="x-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                    <span class="text-red-600 font-medium">Rupture de stock</span>
                @elseif($stock <= $stockMin)
                    <i data-feather="alert-triangle" class="w-5 h-5 text-orange-500 mr-2"></i>
                    <span class="text-orange-500 font-medium">
                        Plus que {{ $stock }} article{{ $stock > 1 ? 's' : '' }} en stock !
                    </span>
                @else
                    <i data-feather="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                    <span class="text-green-600 font-medium">
                        {{ $stock }} disponible{{ $stock > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>

            {{-- État de conservation --}}
            @if($produit->etat_conservation)
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">État :</span> {{ ucfirst($produit->etat_conservation) }}
                    </p>
                </div>
            @endif

            {{-- Description --}}
            @if($produit->description)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $produit->description }}</p>
                </div>
            @endif




@php
    $stock = $stock ?? $produit->stock_actuel ?? 0;
    $disabled = $stock <= 0;
    $max = $disabled ? 1 : $stock;
    $isCompact = $compact ?? false; // Valeur par défaut
@endphp

<form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="add-to-cart-form">
    @csrf

    <div class="flex items-center gap-3">
        {{-- Quantité : visible seulement en mode détaillé --}}
        @if(!$isCompact)
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Qté :</label>
                <input type="number"
                       name="quantite"
                       value="1"
                       min="1"
                       max="{{ $max }}"
                       class="quantity-input w-16 px-2 py-1 text-sm border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('quantite') border-red-500 @enderror"
                       {{ $disabled ? 'disabled' : '' }}>
            </div>
        @else
            <input type="hidden" name="quantite" value="1">
        @endif

        {{-- Bouton Ajouter --}}
        <button type="submit"
                class="add-to-cart-btn flex items-center gap-2 px-4 py-2 text-white font-medium rounded-md transition-all duration-200 shadow-sm
                       {{ $disabled 
                           ? 'bg-gray-400 cursor-not-allowed' 
                           : 'bg-blue-600 hover:bg-blue-700 active:scale-95' }}"
                {{ $disabled ? 'disabled' : '' }}>
            <i data-feather="shopping-cart" class="w-4 h-4"></i>
            @if(!$isCompact)
                <span class="hidden sm:inline">Ajouter</span>
            @endif
        </button>
    </div>

    {{-- Message stock --}}
    @if($stock <= 0)
        <p class="text-xs text-red-600 mt-1">Rupture de stock</p>
    @elseif($stock <= ($produit->stock_minimum ?? 5))
        <p class="text-xs text-orange-600 mt-1">Plus que {{ $stock }} en stock !</p>
    @endif
</form>

{{-- Section Produits Similaires --}}
@if($produitsSimilaires->count() > 0)
<section class="container mx-auto px-4 py-12">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Produits similaires</h2>
        <p class="text-gray-600">Découvrez d'autres cartes qui pourraient vous intéresser</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($produitsSimilaires as $similaire)
        <a href="{{ route('boutique.show', $similaire->id) }}" 
           class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
            
            {{-- Image --}}
            <div class="relative aspect-square overflow-hidden bg-gray-100">
                @if($similaire->photo)
                    <img src="{{ asset('storage/' . $similaire->photo) }}" 
                         alt="{{ $similaire->nom_produit }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i data-feather="image" class="w-12 h-12 text-gray-300"></i>
                    </div>
                @endif

                {{-- Badge promotion --}}
                @if($similaire->est_en_promotion && $similaire->prix_promotion)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                        -{{ round(100 - ($similaire->prix_promotion / $similaire->prix_unitaire_ht * 100)) }}%
                    </div>
                @endif
            </div>

            {{-- Informations --}}
            <div class="p-3">
                {{-- Nom du produit --}}
                <h3 class="text-sm font-medium text-gray-800 mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                    {{ $similaire->nom_produit }}
                </h3>

                {{-- Prix --}}
                <div class="flex items-center gap-2 mb-2">
                    @php
                        $prixSimilaire = ($similaire->est_en_promotion && $similaire->prix_promotion) 
                                       ? $similaire->prix_promotion 
                                       : $similaire->prix_unitaire_ht;
                    @endphp
                    
                    <span class="text-base font-bold text-blue-600">
                        {{ number_format($prixSimilaire, 0, ',', ' ') }} FCFA
                    </span>
                    
                    @if($similaire->est_en_promotion && $similaire->prix_promotion)
                        <span class="text-xs text-gray-500 line-through">
                            {{ number_format($similaire->prix_unitaire_ht, 0, ',', ' ') }}
                        </span>
                    @endif
                </div>

                {{-- Stock --}}
                @php
                    $stockSimilaire = $similaire->stock_actuel ?? 0;
                @endphp
                
                @if($stockSimilaire > 0 && $stockSimilaire <= ($similaire->stock_minimum ?? 5))
                    <div class="flex items-center gap-1 text-xs text-orange-600">
                        <i data-feather="alert-triangle" class="w-3 h-3"></i>
                        <span>Plus que {{ $stockSimilaire }}</span>
                    </div>
                @endif

                {{-- Bouton rapide --}}
                <form action="{{ route('panier.ajouter', $similaire->id) }}" 
                      method="POST" 
                      class="add-to-cart-similar mt-2"
                      onclick="event.stopPropagation();">
                    @csrf
                    <input type="hidden" name="quantite" value="1">
                    <button type="submit" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs py-2 rounded transition-colors duration-200 flex items-center justify-center gap-1"
                            {{ $stockSimilaire <= 0 ? 'disabled' : '' }}>
                        <i data-feather="shopping-cart" class="w-3 h-3"></i>
                        <span>Ajouter</span>
                    </button>
                </form>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

            {{-- Bouton retour --}}
            <a href="{{ route('boutique') }}"
               class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition duration-300 text-sm">
                <i data-feather="arrow-left" class="w-5 h-5"></i>
                Retour à la boutique
            </a>
        </div>
    </div>
</main>


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
                    <li class="flex items-center"><i data-feather="mail" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">contact@cartologue.com</span></li>
                    <li class="flex items-center"><i data-feather="phone" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">+33 1 23 45 67 89</span></li>
                    <li class="flex items-center"><i data-feather="map-pin" class="w-4 h-4 mr-2"></i> <span class="text-gray-400">123 Rue des Cartes, Paris</span></li>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ========== ÉLÉMENTS DOM ==========
    const cartToggle = document.getElementById('cartToggle');
    const flyoutCart = document.getElementById('flyoutCart');
    const closeCart = document.getElementById('closeCart');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartCount = document.getElementById('cartCount');

    // ========== FONCTIONS PANIER ==========
    
    // Ouvrir le panier
    function openCart() {
        if (flyoutCart) {
            flyoutCart.classList.remove('translate-x-full');
            if (cartOverlay) cartOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    // Fermer le panier
    function closeCartFunc() {
        if (flyoutCart) {
            flyoutCart.classList.add('translate-x-full');
            if (cartOverlay) cartOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Event listeners pour ouvrir/fermer
    if (cartToggle) {
        cartToggle.addEventListener('click', openCart);
    }
    
    if (closeCart) {
        closeCart.addEventListener('click', closeCartFunc);
    }

    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCartFunc);
    }

    // Fermer avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartFunc();
        }
    });

    // ========== AFFICHAGE DU PANIER ==========
    function renderCart(panier) {
        if (!cartItemsContainer || !cartSubtotal) return;
        
        let html = '';
        let total = 0;

        if (!panier || Object.keys(panier).length === 0) {
            html = '<p class="text-center text-gray-500 mt-12">Votre panier est vide.</p>';
        } else {
            for (const id in panier) {
                const item = panier[id];
                const prixUnitaire = parseFloat(item.prix) || 0;
                const quantite = parseInt(item.quantite) || 0;
                const sousTotal = prixUnitaire * quantite;
                total += sousTotal;
                
                html += `
                <div class="flex items-center gap-4 border-b py-4">
                    <img src="${item.photo ? '/storage/' + item.photo : '/placeholder-image.jpg'}" 
                         alt="${item.nom}" 
                         class="w-16 h-16 object-cover rounded">
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm">${item.nom}</h4>
                        <p class="text-gray-600 text-sm">${quantite} x ${prixUnitaire.toLocaleString('fr-FR')} FCFA</p>
                        <p class="text-gray-800 text-sm font-medium">${sousTotal.toLocaleString('fr-FR')} FCFA</p>
                    </div>
                </div>`;
            }
            
            html += `
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>Total:</span>
                    <span>${total.toLocaleString('fr-FR')} FCFA</span>
                </div>
            </div>`;
        }

        cartItemsContainer.innerHTML = html;
        cartSubtotal.textContent = total.toLocaleString('fr-FR') + ' FCFA';
    }

    // ========== CHARGER LE PANIER ==========
    function loadCart() {
        fetch("{{ route('panier.json') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const panier = data.panier && typeof data.panier === 'object' ? data.panier : {};
            renderCart(panier);
        })
        .catch(error => {
            console.error('Erreur lors du chargement du panier:', error);
        });
    }

    // ========== COMPTEUR DU PANIER ==========
    function updateCartCount() {
        fetch("{{ route('panier.count') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            if (cartCount) {
                cartCount.textContent = data.count || 0;
            }
        })
        .catch(err => console.error('Erreur compteur panier:', err));
    }

    // ========== NOTIFICATION ==========
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 
                       type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        
        notification.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${bgColor}`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i data-feather="${type === 'success' ? 'check-circle' : type === 'error' ? 'alert-circle' : 'info'}" class="w-5 h-5"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remplacer les icônes Feather
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Animation d'entrée
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        
        // Supprimer après 3 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // ========== AJOUT AU PANIER AVEC REDIRECTION ==========
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const url = this.action;
            const formData = new FormData(this);
            const submitBtn = this.querySelector('.add-to-cart-btn');
            const originalHTML = submitBtn.innerHTML;

            // Désactiver le bouton pendant la requête
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i> <span class="hidden sm:inline">Ajout...</span>';
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            fetch(url, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Affiche un message de succès
                    showNotification('Produit ajouté ! Redirection vers le panier...', 'success');
                    
                    // REDIRECTION VERS LA PAGE PANIER APRÈS 800ms
                    setTimeout(() => {
                        window.location.href = data.redirect || "{{ route('panier') }}";
                    }, 800);
                } else {
                    showNotification(data.message || 'Erreur lors de l\'ajout au panier', 'error');
                    // Réactiver le bouton en cas d'erreur
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }
            })
            .catch(err => {
                console.error('Erreur ajout panier:', err);
                showNotification('Une erreur est survenue', 'error');
                // Réactiver le bouton en cas d'erreur
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });
        });
    });

    // ========== VALIDATION QUANTITÉ ==========
    document.querySelectorAll('.quantity-input').forEach(input => {
        const maxStock = parseInt(input.getAttribute('max'));
        
        input.addEventListener('change', function() {
            const quantite = parseInt(this.value);
            
            if (quantite < 1) {
                this.value = 1;
                showNotification('La quantité minimum est 1', 'error');
            } else if (maxStock && quantite > maxStock) {
                this.value = maxStock;
                showNotification(`Quantité maximale: ${maxStock}`, 'error');
            }
        });
    });

    // ========== INITIALISATION ==========
    updateCartCount();
    loadCart();

    // AOS (animations au scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({ 
            once: true,
            duration: 800,
            offset: 100
        });
    }

    // Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Masquer le message flash après 5 secondes
    const flashMessage = document.getElementById('flashMessage');
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.style.opacity = '0';
            setTimeout(() => flashMessage.remove(), 300);
        }, 5000);
    }
 });


</script>


</body>
</html>
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

  <!-- HEADER / NAV with SEARCH + CART -->
  <header class="bg-white shadow fixed w-full z-50">
    <div class=" mx-10 px-4">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-6">
          <a href="{{ route('accueil') }}" class="flex  items-center">
               <img src="{{ asset('images/bnetd_logo.svg') }}" alt="Cartologue" class="h-8 m-5 w-auto">
           
          </a>

          <!-- Main nav (desktop) -->
          <nav class="hidden md:flex items-center gap-3">
            <a href="{{ route('accueil') }}" class="py-2 px-3 text-blue-600 border-b-2 border-blue-600 font-semibold">Accueil</a>
            <a href="{{ route('boutique') }}" class="py-2 px-3 hover:text-blue-600">Boutique</a>
           <!-- <a href="{{ route('panier') }}" class="py-2 px-3 hover:text-blue-600">Panier</a> --> 
            <a href="{{ route('contact') }}" class="py-2 px-3 hover:text-blue-600">Contact</a>
          </nav>
        </div>




        <!-- Right actions -->
  
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


     <!-- Mobile menu -->
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

    <!-- Section Résumé -->
    <section class="py-28 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8 space-y-6">

                <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Résumé de votre commande</h2>

                @if(isset($commande))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <!-- Client -->
                    <div class="bg-blue-50 p-4 rounded shadow" data-aos="fade-up">
                        <h3 class="text-lg font-semibold mb-2">Informations du client</h3>
                        <p><strong>Nom :</strong> {{ $commande->client->name ?? auth()->user()->name ?? '-' }}</p>
                        <p><strong>Email :</strong> {{ $commande->client->email ?? auth()->user()->email ?? '-' }}</p>
                    </div>

                    <!-- Livraison -->
                    <div class="bg-gray-100 p-4 rounded shadow" data-aos="fade-up">
                        <h3 class="text-lg font-semibold mb-2">Adresse de livraison</h3>
                        @if($commande->livraison)
                            <p><strong>Adresse :</strong> {{ $commande->livraison->adresse ?? '-' }}</p>
                            <p><strong>Téléphone :</strong> {{ $commande->livraison->numero_tel ?? '-' }}</p>
                            <p><strong>Ville :</strong> {{ $commande->livraison->ville ?? '-' }}</p>
                            <p><strong>Code postal :</strong> {{ $commande->livraison->code_postal ?? '-' }}</p>
                            <p><strong>Pays :</strong> {{ $commande->livraison->pays ?? '-' }}</p>
                        @else
                            <p class="text-gray-500">Aucune adresse définie</p>
                        @endif
                    </div>

                    <!-- Commande -->
                    <div class="bg-gray-50 p-4 rounded shadow" data-aos="fade-up">
                        <h3 class="text-lg font-semibold mb-2">Informations de la commande</h3>
                        <p><strong>Numéro :</strong> {{ $commande->numero_commande ?? '-' }}</p>
                        <p><strong>Date :</strong> {{ $commande->date_commande ? $commande->date_commande: '-' }}</p>
                        <p><strong>Total TTC :</strong> {{ number_format($commande->total_ttc ?? 0, 2, ',', ' ') }} FCFA</p>
                        <p><strong>État :</strong> 
                            <span class="px-2 py-1 rounded {{ $commande->etat == 'payée' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($commande->etat ?? 'en attente') }}
                            </span>
                        </p>
                    </div>


                    <!-- Paiement -->
                    <div class="bg-white p-4 rounded shadow" data-aos="fade-up">
                        <h3 class="text-lg font-semibold mb-2">Mode de paiement</h3>
                        @if($commande->paiement && $commande->paiement->mode)
                            <p>
                                <strong>Méthode :</strong>
                                @switch($commande->paiement->mode)
                                    @case('carte')
                                        Carte bancaire
                                        @break
                                    @case('mobile_money')
                                        Mobile Money
                                        @break
                                    @case('paypal')
                                        PayPal
                                        @break
                                    @case('stripe')
                                        Stripe
                                        @break
                                    @case('livraison')
                                        Paiement à la livraison
                                        @break
                                    @default
                                        Non renseigné
                                @endswitch
                            </p>
                            <p><strong>Référence :</strong> {{ $commande->paiement->reference ?? 'N/A' }}</p>
                        @else
                            <p><strong>Méthode :</strong> Non renseigné</p>
                        @endif
                    </div>
                </div>

           <!-- Produits -->
<div class="bg-white p-4 rounded shadow" data-aos="fade-up">
    <h3 class="text-lg font-semibold mb-4">Produits commandés</h3>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b bg-gray-100">
                <th class="py-2 px-2">Produit</th>
                <th class="py-2 px-2 text-center">Quantité</th>
                <th class="py-2 px-2 text-right">Prix unitaire HT</th>
                <th class="py-2 px-2 text-right">Montant HT</th>
                <th class="py-2 px-2 text-right">TVA (18%)</th>
                <th class="py-2 px-2 text-right">Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $total_ht = 0; 
                $total_tva = 0;
                $total_ttc = 0;
            @endphp

            @foreach($commande->produits as $produit)
                @php
                    $ligne = $produit->pivot;
                    $prix_ht = $ligne->prix_unitaire_ht;
                    $quantite = $ligne->quantite;
                    $montant_ht = $prix_ht * $quantite;
                    $tva = $montant_ht * 0.18;
                    $montant_ttc = $montant_ht + $tva;

                    $total_ht += $montant_ht;
                    $total_tva += $tva;
                    $total_ttc += $montant_ttc;
                @endphp
                <tr class="border-b">
                    <td class="py-2 px-2">{{ $produit->nom_produit }}</td>
                    <td class="py-2 px-2 text-center">{{ $quantite }}</td>
                    <td class="py-2 px-2 text-right">{{ number_format($prix_ht, 2, ',', ' ') }} FCFA</td>
                    <td class="py-2 px-2 text-right">{{ number_format($montant_ht, 2, ',', ' ') }} FCFA</td>
                    <td class="py-2 px-2 text-right">{{ number_format($tva, 2, ',', ' ') }} FCFA</td>
                    <td class="py-2 px-2 text-right">{{ number_format($montant_ttc, 2, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="font-semibold border-t">
            <tr>
                <td colspan="3" class="text-right py-2 px-2">Total HT</td>
                <td class="py-2 px-2 text-right">{{ number_format($total_ht, 2, ',', ' ') }} FCFA</td>
                <td class="py-2 px-2 text-right">{{ number_format($total_tva, 2, ',', ' ') }} FCFA</td>
                <td class="py-2 px-2 text-right">{{ number_format($total_ttc, 2, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>
</div>


             

                 <div class="text-center mt-8">
                   <a href="{{ route('afficher.paiement', ['commandeId' => $commande->id]) }}" class="btn btn-primary">
                 Payer maintenant
                 </a>
                </div>

                   <div class="text-center mt-8">
                    <a href="{{ route('accueil') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition">
                        Retour à vos achats
                    </a>
                </div>

                @else
                    <p class="text-center text-red-500">Aucune commande trouvée.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- NEWSLETTER (existing, kept) -->
    <section class="py-12 bg-blue-600 text-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl font-bold mb-3">Abonnez-vous à notre newsletter</h2>
        <p class="mb-6 text-gray-100">Recevez nos offres spéciales et découvrez nos nouvelles collections en avant-première</p>
        <form class="max-w-md mx-auto flex gap-2" onsubmit="event.preventDefault(); alert('Merci — formulaire simulateur');">
          <input type="email" placeholder="Votre email" class="flex-1 px-4 py-2 rounded" required />
          <button class="bg-white text-blue-600 px-4 py-2 rounded">S'abonner</button>
        </form>
      </div>
    </section>

    <!-- FOOTER (enrichi) -->
    <footer class="bg-gray-900 text-gray-300 py-12">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <img src="{{ asset('images/bnetd_logo.svg') }}" alt="Cartologue" class="h-8 w-auto">
          <p class="text-sm">Boutique en ligne de cartes anciennes, topographiques et personnalisées.</p>
          <div class="mt-4 flex gap-2">
            <img src="http://static.photos/travel/60x40/visa" alt="visa" class="h-20">
            <img src="http://static.photos/travel/60x40/mastercard" alt="mc" class="h-20">
            <img src="http://static.photos/travel/60x40/paypal" alt="pp" class="h-20">
          </div>
        </div>

        <div>
          <h5 class="text-white font-semibold mb-2">Navigation</h5>
          <ul class="space-y-2 text-sm">
            <li><a href="{{ route('boutique') }}" class="hover:underline">Boutique</a></li>
            <li><a href="{{ route('contact') }}" class="hover:underline">Contact</a></li>
            <li><a href="#" class="hover:underline">FAQ</a></li>
            <li><a href="#" class="hover:underline">Blog</a></li>
          </ul>
        </div>

        <div>
          <h5 class="text-white font-semibold mb-2">Entreprise</h5>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">À propos</a></li>
            <li><a href="#" class="hover:underline">Mentions légales</a></li>
            <li><a href="#" class="hover:underline">CGV</a></li>
            <li><a href="#" class="hover:underline">Politique de confidentialité</a></li>
          </ul>
        </div>

        <div>
          <h5 class="text-white font-semibold mb-2">Contact</h5>
          <p class="text-sm">contact@cartologue.com</p>
          <p class="text-sm mt-1">+33 1 23 45 67 89</p>
          <p class="text-sm mt-2">123 Rue des Cartes, Paris</p>
          <div class="mt-4 flex gap-3">
            <a href="#" class="text-gray-400 hover:text-white"><i data-feather="facebook" class="w-5 h-5"></i></a>
            <a href="#" class="text-gray-400 hover:text-white"><i data-feather="instagram" class="w-5 h-5"></i></a>
            <a href="#" class="text-gray-400 hover:text-white"><i data-feather="linkedin" class="w-5 h-5"></i></a>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-8 pt-6 text-center text-sm text-gray-500">
        © <span id="year"></span> Cartologue — Tous droits réservés.
      </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
            feather.replace();
        });





   // init AOS + feather
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({ duration: 700, once: true });
      feather.replace();
      document.getElementById('year').textContent = new Date().getFullYear();
    });

    /* MOBILE MENU */
    const mobileBtn = document.getElementById('mobileBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileBtn?.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    /* PROMO CAROUSEL (simple) */
    (function() {
      const track = document.getElementById('promoTrack');
      const prev = document.getElementById('prevPromo');
      const next = document.getElementById('nextPromo');
      let index = 0;
      const slides = track.children;
      const total = slides.length;

      function show(i) {
        const w = track.parentElement.clientWidth;
        // move track by index * parent width
        track.style.transform = `translateX(-${i * w}px)`;
      }

      prev?.addEventListener('click', () => { index = (index - 1 + total) % total; show(index); });
      next?.addEventListener('click', () => { index = (index + 1) % total; show(index); });
      window.addEventListener('resize', () => show(index));
      // auto rotate every 6s
      setInterval(() => { index = (index + 1) % total; show(index); }, 6000);
    })();

    /* SEARCH SUGGESTIONS (simulé) */
    (function() {
      const input = document.getElementById('searchInput');
      const suggestions = document.getElementById('searchSuggestions');
      const list = document.getElementById('suggestList');
      if (!input) return;
      const sample = ['Carte du monde', 'Paris 1900', 'Alpes françaises', 'Carte personnalisée', 'Carte topographique'];
      input.addEventListener('input', (e) => {
        const v = e.target.value.trim();
        if (!v) { suggestions.classList.add('hidden'); return; }
        const items = sample.filter(s => s.toLowerCase().includes(v.toLowerCase())).slice(0,5);
        list.innerHTML = items.map(it => `<li class="px-3 py-2 hover:bg-gray-100 cursor-pointer">${it}</li>`).join('') || `<li class="px-3 py-2 text-gray-500">Aucun résultat</li>`;
        suggestions.classList.remove('hidden');
      });
      // click suggestion
      list.addEventListener('click', (e) => {
        if (e.target.matches('li')) {
          input.value = e.target.textContent.trim();
          suggestions.classList.add('hidden');
        }
      });
      // hide on outside click
      document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !suggestions.contains(e.target)) suggestions.classList.add('hidden');
      });
    })();

    /* FLYOUT CART LOGIC (simple front-end mock) */
    (function() {
      const cartToggle = document.getElementById('cartToggle');
      const flyout = document.getElementById('flyoutCart');
      const closeCart = document.getElementById('closeCart');
      const cartCount = document.getElementById('cartCount');
      const cartItemsContainer = document.getElementById('cartItemsContainer');
      const cartSubtotal = document.getElementById('cartSubtotal');
      let cart = []; // {id,name,price,qty,image}

      function renderCart() {
        cartItemsContainer.innerHTML = '';
        if (cart.length === 0) {
          document.getElementById('emptyMsg').classList.remove('hidden');
        } else {
          document.getElementById('emptyMsg')?.classList.add('hidden');
          cart.forEach(item => {
            const node = document.createElement('div');
            node.className = 'flex items-center gap-3 mb-4';
            node.innerHTML = `
              <img src="${item.image}" alt="${item.name}" class="w-16 h-12 object-cover rounded">
              <div class="flex-1">
                <div class="font-semibold text-sm">${item.name}</div>
                <div class="text-xs text-gray-500">€${item.price.toFixed(2)}</div>
                <div class="mt-2 flex items-center gap-2">
                  <button data-action="dec" data-id="${item.id}" class="px-2 py-1 border rounded text-sm">-</button>
                  <span class="text-sm">${item.qty}</span>
                  <button data-action="inc" data-id="${item.id}" class="px-2 py-1 border rounded text-sm">+</button>
                  <button data-action="remove" data-id="${item.id}" class="ml-3 text-red-500 text-sm">Supprimer</button>
                </div>
              </div>
            `;
            cartItemsContainer.appendChild(node);
          });
        }

        // subtotal & count
        const subtotal = cart.reduce((s,i)=> s + i.price * i.qty, 0);
        cartSubtotal.textContent = `€${subtotal.toFixed(2)}`;
        cartCount.textContent = cart.reduce((s,i)=> s + i.qty, 0);
      }

      // open/close
      function openCart() {
        flyout.style.transform = 'translateX(0)';
        flyout.style.right = '0';
      }
      function close() {
        flyout.style.transform = 'translateX(100%)';
      }
      cartToggle?.addEventListener('click', openCart);
      closeCart?.addEventListener('click', close);

      // add to cart buttons (from product cards)
      document.querySelectorAll('.addToCartBtn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const article = btn.closest('article');
          if (!article) return;
          const product = JSON.parse(article.getAttribute('data-product'));
          const exist = cart.find(i => i.id === product.id);
          if (exist) exist.qty++;
          else cart.push({...product, qty:1});
          renderCart();
        });
      });

      // delegate cart item buttons
      cartItemsContainer.addEventListener('click', (e) => {
        const action = e.target.closest('button')?.dataset?.action;
        const id = +e.target.closest('button')?.dataset?.id;
        if (!action) return;
        const idx = cart.findIndex(i => i.id === id);
        if (idx === -1) return;
        if (action === 'inc') cart[idx].qty++;
        if (action === 'dec') { cart[idx].qty = Math.max(1, cart[idx].qty - 1); }
        if (action === 'remove') cart.splice(idx,1);
        renderCart();
      });

      // initial render
      renderCart();

      // allow opening cart programmatically when adding
      window.openCart = openCart;
    })();

    /* QUICK CHAT form simulated */

    (function() {
      const form = document.getElementById('quickChat');
      form?.addEventListener('submit', (e) => {
        e.preventDefault();
        document.getElementById('chatNotice').classList.remove('hidden');
        setTimeout(() => document.getElementById('chatNotice').classList.add('hidden'), 4500);
        form.reset();
      });

      document.getElementById('openWhatsapp')?.addEventListener('click', () => {
        window.open('https://wa.me/33123456789?text=Bonjour%20Cartologue%20-%20j%27ai%20une%20question', '_blank');
      });
    })();

    /* small accessibility: close flyout on Esc */
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') document.getElementById('flyoutCart').style.transform = 'translateX(100%)';
    });








    </script>

</body>
</html>

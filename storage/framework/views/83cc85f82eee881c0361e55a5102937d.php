<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Cartologue</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Feather icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

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
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-6">
                    <a href="<?php echo e(route('accueil')); ?>" class="flex items-center">
                        <span class="text-2xl font-semibold text-gray-700">Cartologue</span>
                    </a>

                    <!-- Main nav (desktop) -->
                    <nav class="hidden md:flex items-center gap-3">
                        <a href="<?php echo e(route('accueil')); ?>" class="py-2 px-3 text-blue-600 border-b-2 border-blue-600 font-semibold">Accueil</a>
                        <a href="<?php echo e(route('boutique')); ?>" class="py-2 px-3 hover:text-blue-600">Boutique</a>
                        <a href="<?php echo e(route('panier')); ?>" class="py-2 px-3 hover:text-blue-600">Panier</a>
                        <a href="<?php echo e(route('contact')); ?>" class="py-2 px-3 hover:text-blue-600">Contact</a>
                    </nav>
                </div>

                <!-- Search -->
                <div class="flex-1 max-w-xl px-4 hidden md:block">
                    <div class="relative">
                        <input id="searchInput" type="search" placeholder="Rechercher une carte, lieu, époque..." class="w-full rounded-full border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" />
                        <button id="searchBtn" class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2">
                            <i data-feather="search" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Right actions -->
           

<?php if(auth()->guard()->check()): ?>
    <div class="relative group">
        <button class="flex items-center space-x-2 px-3 py-1 text-gray-600 hover:bg-gray-100 rounded">
            <?php if(Auth::user()->avatar): ?>
                <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" 
                     class="w-6 h-6 rounded-full" 
                     alt="<?php echo e(Auth::user()->name); ?>">
            <?php else: ?>
                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs">
                    <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                </div>
            <?php endif; ?>
            <span><?php echo e(Auth::user()->name ?? 'Client'); ?></span>
        </button>
        
        <!-- Menu déroulant -->
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Mon profil
            </a>
            <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Tableau de bord
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
<?php else: ?>
<?php endif; ?>




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
                <a href="<?php echo e(route('accueil')); ?>" class="py-2">Accueil</a>
                <a href="<?php echo e(route('boutique')); ?>" class="py-2">Boutique</a>
                <a href="<?php echo e(route('panier')); ?>" class="py-2">Panier</a>
                <a href="<?php echo e(route('contact')); ?>" class="py-2">Contact</a>
            </div>
        </div>
    </header>

    <!-- FLYOUT CART -->
    <aside id="flyoutCart" class="fixed top-0 right-0 h-full w-full md:w-96 bg-white shadow-2xl z-60 transform translate-x-full transition-transform duration-300">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Panier</h3>
                <button id="closeCart" class="p-2 rounded hover:bg-gray-100"><i data-feather="x"></i></button>
            </div>

            <div class="p-4 flex-1 overflow-auto" id="cartItemsContainer">
                <p id="emptyMsg" class="text-center text-gray-500 mt-12">Votre panier est vide.</p>
            </div>

            <div class="p-4 border-t">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-gray-600">Sous-total</span>
                    <span id="cartSubtotal" class="font-semibold">€0.00</span>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('panier')); ?>" class="flex-1 text-center py-2 border border-gray-200 rounded hover:bg-gray-50">Voir le panier</a>
                    <a href="<?php echo e(route('panier')); ?>" class="flex-1 text-center py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Passer à la caisse</a>
                </div>
            </div>
        </div>
    </aside>


<?php if(session('success') || session('error')): ?>
    <?php
        $type = session('success') ? 'success' : 'error';
        $bg = $type === 'success' ? 'bg-green-500' : 'bg-red-500';
    ?>
    <div id="flashMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 <?php echo e($bg); ?> text-white px-6 py-3 rounded shadow-lg z-50">
        <i data-feather="<?php echo e($type === 'success' ? 'check-circle' : 'alert-circle'); ?>" class="inline w-5 h-5 mr-2"></i>
        <?php echo e(session($type)); ?>

        <button onclick="document.getElementById('flashMessage').remove()" class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
    </div>
<?php endif; ?>


    <!-- Cart Header -->
    <div class="bg-gray-800 text-white py-12 pt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold mb-4" data-aos="fade-down">Votre panier</h1>
            <p class="text-gray-300 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="100">
                Consultez et modifiez les articles de votre panier avant de passer commande
            </p>
        </div>
    </div>

    <!-- Cart Content -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Liste des produits -->
                <div class="lg:w-3/3" data-aos="fade-right">

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">

                        <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 hidden md:block">
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-6 font-semibold text-gray-700">Produit</div>
                                <div class="col-span-2 font-semibold text-gray-700 text-center">Prix</div>
                                <div class="col-span-2 font-semibold text-gray-700 text-center">Quantité</div>
                                <div class="col-span-2 font-semibold text-gray-700 text-right">Total</div>
                            </div>
                        </div>

                        <?php $total = 0; ?>
                        <?php $__currentLoopData = $commande->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $ligne = $produit->pivot;
                                $sousTotal = $ligne->quantite * $produit->prix_unitaire_ht;
                                $total += $sousTotal;
                            ?>

                            <div class="p-4 md:p-6 border-b border-gray-200">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                        <img src="<?php echo e(asset($produit->photo)); ?>" alt="<?php echo e($produit->nom_produit); ?>" class="w-20 h-20 object-cover rounded">
                                    </div>
                                    <div class="flex-grow md:grid md:grid-cols-12 md:gap-4">
                                        <div class="md:col-span-5 mb-2 md:mb-0">
                                            <h3 class="font-semibold text-gray-800"><?php echo e($produit->nom_produit); ?></h3>
                                            <p class="text-sm text-gray-600"><?php echo e($produit->description); ?></p>
                                        </div>
                                        <div class="md:col-span-2 flex items-center justify-center">
                                            <span class="text-gray-700">€<?php echo e(number_format($produit->prix_unitaire_ht, 2)); ?></span>
                                        </div>
                                        <div class="md:col-span-2 flex items-center justify-center">
                                            <div class="flex items-center border border-gray-300 rounded">
                                                <form action="<?php echo e(route('panier.reduire', ['produit' => $produit->id])); ?>" method="POST"><?php echo csrf_field(); ?>
                                                    <button type="submit" class="px-2 py-1 text-gray-600 hover:bg-gray-100"><i data-feather="minus" class="w-4 h-4"></i></button>
                                                </form>
                                                <span class="px-3 py-1"><?php echo e($ligne->quantite); ?></span>
                                                <form action="<?php echo e(route('panier.ajouter', ['produit' => $produit->id])); ?>" method="POST"><?php echo csrf_field(); ?>
                                                    <button type="submit" class="px-2 py-1 text-gray-600 hover:bg-gray-100"><i data-feather="plus" class="w-4 h-4"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2 flex items-center justify-end">
                                            <span class="font-semibold text-gray-800">€<?php echo e(number_format($sousTotal, 2)); ?></span>
                                        </div>
                                        <div class="md:col-span-1 flex items-center justify-end">
                                            <form action="<?php echo e(route('panier.supprimer', ['produit' => $produit->id])); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i data-feather="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>


       <div class="space-y-8 pt-5">
      
      <!-- Infos client -->
      <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-xl font-semibold mb-4">Informations du client</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
          <p><span class="font-medium">Nom :</span> <?php echo e(auth()->user()->name ?? 'Non renseigné'); ?></p>
          <p><span class="font-medium">Email :</span> <?php echo e(auth()->user()->email ?? 'Non renseigné'); ?></p>
        </div>
      </div>

      <!-- Formulaire Livraison / Paiement -->
      <form action="<?php echo e(route('panier.valider')); ?>" method="POST" class="space-y-6"><?php echo csrf_field(); ?>
        
        <!-- Livraison -->
        <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up" data-aos-delay="200">
          <h2 class="text-xl font-semibold mb-4">Détails de livraison</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Adresse de livraison</label>
              <textarea name="adresse_livraison" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm" placeholder="Entrez votre adresse complète" required><?php echo e($livraison->adresse ?? ''); ?></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
              <input type="text" name="ville" value="<?php echo e($livraison->ville ?? ''); ?>" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
              <input type="text" name="numero_tel" value="<?php echo e($livraison->numero_tel ?? ''); ?>" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
              <input type="text" name="code_postal" value="<?php echo e($livraison->code_postal ?? ''); ?>" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Instructions (optionnel)</label>
              <textarea name="instructions" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm" placeholder="Ex : Laisser le colis à la loge..."><?php echo e($livraison->instructions ?? ''); ?></textarea>
            </div>
          </div>
        </div>

        <!-- Paiement -->
        <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up" data-aos-delay="300">
          <h2 class="text-xl font-semibold mb-4">Mode de paiement</h2>
          <select name="mode_paiement" id="mode_paiement" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
            <?php
              $paiements = [
                  'Espèces' => [\App\Enums\MoyenPaiement::ESPECES],
                  'Mobile Money' => [
                      \App\Enums\MoyenPaiement::WAVE,
                      \App\Enums\MoyenPaiement::MOOV_MONEY,
                      \App\Enums\MoyenPaiement::MTN_MONEY,
                      \App\Enums\MoyenPaiement::ORANGE_MONEY,
                  ],
                  'Carte / en ligne' => [
                      \App\Enums\MoyenPaiement::PAYPAL,
                      \App\Enums\MoyenPaiement::STRIPE,
                      \App\Enums\MoyenPaiement::CARTE,
                  ],
                  'Crypto' => [
                      \App\Enums\MoyenPaiement::BITCOIN,
                      \App\Enums\MoyenPaiement::ETHEREUM,
                  ],
              ];
            ?>
            <?php $__currentLoopData = $paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie => $moyens): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <optgroup label="<?php echo e($categorie); ?>">
                <?php $__currentLoopData = $moyens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moyen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($moyen->value); ?>" <?php echo e(($paiement->mode_paiement ?? '') === $moyen->value ? 'selected' : ''); ?>>
                    <?php echo e(ucwords(str_replace('_', ' ', $moyen->value))); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </optgroup>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>

          <div class="mt-8">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
              Passer la commande
            </button>
          </div>
        </div>

      </form>

    </div>

                </div>


  <div class="container my-5">
 
    <div class="row g-4">
    <!-- Récapitulatif -->
    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
      <div class="bg-white rounded-lg shadow-md p-6 h-100">
        <h2 class="text-xl font-semibold mb-4">Récapitulatif de commande</h2>
        <div class="space-y-4 mb-6">
          <div class="d-flex justify-content-between">
            <span class="text-gray-600">Montant HT</span>
            <span class="fw-semibold"><?php echo e(number_format($total, 2)); ?> FCFA</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-gray-600">TVA (18%)</span>
            <span class="fw-semibold"><?php echo e(number_format($total * 0.18, 2)); ?></span>
          </div>
          <div class="d-flex justify-content-between border-top pt-3">
            <span class="fs-5 fw-semibold">Total TTC</span>
            <span class="fs-5 fw-bold text-primary"><?php echo e(number_format($total * 1.18, 2)); ?> FCFA</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Livraison -->
    <div class="col-lg-6 pt-5" data-aos="fade-up" data-aos-delay="200">
      <div class="bg-white border border-gray-200 rounded-3 shadow-md p-6 h-100">
        <h3 class="fs-5 fw-semibold text-dark mb-3">🚚 Livraison à domicile</h3>
        <div class="mb-3">
          <p class="small text-muted mb-1">
            Livraison prévue le <span class="fw-medium text-success">22 octobre</span>
          </p>
          <p class="small text-secondary">
            💡 Économisez jusqu’à 
            <span class="fw-semibold text-warning">700 FCFA</span>  
            en passant à un point relais à partir de 
            <span class="fw-semibold text-dark">300 FCFA</span>.
          </p>
        </div>

        <div class="text-center">
          <button class="btn btn-primary rounded-pill px-4 py-2">
            Choisir un point relais
          </button>
        </div>
      </div>
    </div>

   </div>

  </div>

            
        </div>

        
        
  


  </div>
        
        
   </section>

    





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
                        <li><a href="index.html" class="text-gray-400 hover:text-white transition duration-300">Accueil</a></li>
                        <li><a href="boutique.html" class="text-gray-400 hover:text-white transition duration-300">Boutique</a></li>
                        <li><a href="panier.html" class="text-gray-400 hover:text-white transition duration-300">Panier</a></li>
                        <li><a href="contact.html" class="text-gray-400 hover:text-white transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Compte</h4>
                    <ul class="space-y-2">
                        <li><a href="login.html" class="text-gray-400 hover:text-white transition duration-300">Connexion</a></li>
                        <li><a href="register.html" class="text-gray-400 hover:text-white transition duration-300">Inscription</a></li>
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
        // Mobile menu toggle
        const mobileBtn = document.getElementById("mobileBtn");
        const mobileMenu = document.getElementById("mobileMenu");
        mobileBtn.addEventListener("click", () => { mobileMenu.classList.toggle("hidden"); });

        // Initialize AOS and Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
            feather.replace();
        });

        // Flyout cart toggle
        const cartToggle = document.getElementById("cartToggle");
        const flyoutCart = document.getElementById("flyoutCart");
        const closeCart = document.getElementById("closeCart");
        cartToggle.addEventListener("click", () => flyoutCart.classList.remove("translate-x-full"));
        closeCart.addEventListener("click", () => flyoutCart.classList.add("translate-x-full"));





  document.addEventListener('DOMContentLoaded', function() {

    // Fonction pour mettre à jour le compteur du panier
    function updateCartCount() {
        fetch("<?php echo e(route('panier.count')); ?>")
            .then(response => response.json())
            .then(data => {
                const countElem = document.getElementById('cartCount');
                countElem.textContent = data.count;
            });
    }

    // Mettre à jour au chargement de la page
    updateCartCount();

    // Si tu utilises un formulaire "ajouter au panier" avec AJAX
    document.querySelectorAll('form.add-to-cart').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const url = this.action;
            const formData = new FormData(this);

            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Met à jour le compteur
                updateCartCount();
                alert('Produit ajouté au panier !');
            });
        });
    });
});



    </script>


</body>
</html>
<?php /**PATH D:\workspace\Projet1-main-main\Projet1-main-main\resources\views/panier.blade.php ENDPATH**/ ?>
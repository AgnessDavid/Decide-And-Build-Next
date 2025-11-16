<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Cartologue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="<?php echo e(route('accueil')); ?>" class="flex items-center py-4 px-2">
                            <span class="font-semibold text-gray-500 text-2xl">Cartologue</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-1">

                        <a href="<?php echo e(route('accueil')); ?>" class="py-4 px-2 text-blue-500 border-b-4 border-blue-500 font-semibold">Accueil</a>
                        <a href="<?php echo e(route('boutique')); ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Boutique</a>
                        <a href="<?php echo e(route('panier')); ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Panier</a>
                        <a href="<?php echo e(route('contact')); ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Contact</a>

                        
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    <a href="<?php echo e(route('login')); ?>" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-blue-500 hover:text-white transition duration-300">Connexion</a>
                    <a href="<?php echo e(route('register')); ?>" class="py-2 px-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition duration-300">Inscription</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <i data-feather="menu" class="w-6 h-6 text-gray-500"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden mobile-menu">
            <ul>
                <li><a href="<?php echo e(route('accueil')); ?>" class="block text-sm px-2 py-4 text-white bg-blue-500 font-semibold">Accueil</a></li>
                <li><a href="<?php echo e(route('boutique')); ?>" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Boutique</a></li>
                <li><a href="<?php echo e(route('panier')); ?>" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Panier</a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Contact</a></li>
                <li><a href="<?php echo e(route('register')); ?>" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Connexion</a></li>
                <li><a href="<?php echo e(route('login')); ?>" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Inscription</a></li>
            </ul>
        </div>
    </nav>


    <!-- Contact Header -->
    <div class="bg-gray-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold mb-4" data-aos="fade-down">Contactez-nous</h1>
            <p class="text-gray-300 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="100">
                Notre équipe est à votre écoute pour répondre à toutes vos questions
            </p>
        </div>
    </div>

    <!-- Contact Content -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Contact Info Card 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center" data-aos="fade-up">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="mail" class="w-8 h-8 text-blue-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Email</h3>
                    <p class="text-gray-600 mb-2">Écrivez-nous à tout moment</p>
                    <a href="mailto:contact@cartologue.com" class="text-blue-500 hover:text-blue-700 font-semibold">
                      contact@decideandbuild.ci
                    </a>
                </div>



                <!-- Contact Info Card 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="phone" class="w-8 h-8 text-blue-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Téléphone</h3>
                    <p class="text-gray-600 mb-2">Du lundi au vendredi, 9h-18h</p>
                    <a href="tel:+33123456789" class="text-blue-500 hover:text-blue-700 font-semibold">
                       +225 07 17 41 74 60 <br> +225 27 33 75 90 20
                    </a>
                </div>

                <!-- Contact Info Card 3 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="map-pin" class="w-8 h-8 text-blue-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Adresse</h3>
                    <p class="text-gray-600 mb-2">Venez nous rendre visite</p>
                    <p class="text-blue-500 font-semibold">
                       Cocody<br>, Sipim 4 
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-md p-8" data-aos="fade-right">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>
                    <form id="contactForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prénom
                                </label>
                                <input type="text" id="firstName" name="firstName" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Jean">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom
                                </label>
                                <input type="text" id="lastName" name="lastName" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Kouadio">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="votre.email@exemple.com">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone (optionnel)
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="+225 07 17 41 74 45">
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Sujet
                            </label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionnez un sujet</option>
                                <option value="commande">Question sur une commande</option>
                                <option value="produit">Information produit</option>
                                <option value="livraison">Livraison</option>
                                <option value="retour">Retour / Échange</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Décrivez votre demande..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded transition duration-300 flex items-center justify-center">
                            <i data-feather="send" class="w-5 h-5 mr-2"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>



                <div class="space-y-8" data-aos="fade-left">
                    <!-- Map -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-64 bg-gray-300 relative">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3972.2740559925514!2d-3.9581219999999995!3d5.3751169999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNcKwMjInMzAuNCJOIDPCsDU3JzI5LjIiVw!5e0!3m2!1sfr!2sci!4v1763018901236!5m2!1sfr!2sci"
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Notre boutique</h3>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <i data-feather="clock" class="w-5 h-5 text-blue-500 mr-3 mt-1"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">Horaires d'ouverture</p>
                                        <p class="text-gray-600 text-sm">Lundi - Vendredi : 9h00 - 18h00</p>
                                        <p class="text-gray-600 text-sm">Samedi : 8h00 - 17h00</p>
                                        <p class="text-gray-600 text-sm">Dimanche : Fermé</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Quick Links -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Questions fréquentes</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition duration-300">
                                    <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                                    Comment suivre ma commande ?
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition duration-300">
                                    <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                                    Quels sont les délais de livraison ?
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition duration-300">
                                    <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                                    Comment retourner un produit ?
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition duration-300">
                                    <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                                    Puis-je personnaliser une carte ?
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-blue-500 rounded-lg shadow-md p-6 text-white">
                        <h3 class="text-xl font-semibold mb-4">Suivez-nous</h3>
                        <p class="mb-4">Restez connecté avec nous sur les réseaux sociaux</p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition duration-300">
                                <i data-feather="facebook" class="w-5 h-5 text-blue-500"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition duration-300">
                                <i data-feather="twitter" class="w-5 h-5 text-blue-500"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition duration-300">
                                <i data-feather="instagram" class="w-5 h-5 text-blue-500"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition duration-300">
                                <i data-feather="linkedin" class="w-5 h-5 text-blue-500"></i>
                            </a>
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

    <script>
        // Mobile menu toggle
        const btn = document.querySelector(".mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });

        // Initialize AOS and Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            feather.replace();
        });

        // Handle form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Message envoyé avec succès ! Nous vous répondrons dans les plus brefs délais. (Démo)');
            this.reset();
        });
    </script>
</body>
</html><?php /**PATH D:\workspace\Projet1-main-main\Projet1-main-main\resources\views/contact.blade.php ENDPATH**/ ?>
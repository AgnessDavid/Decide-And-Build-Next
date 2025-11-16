<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Cartologue</title>
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
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="index.html" class="flex items-center py-4 px-2">
                            <span class="font-semibold text-gray-500 text-2xl">Cartologue</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="index.html" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Accueil</a>
                        <a href="boutique.html" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Boutique</a>
                        <a href="panier.html" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Panier</a>
                        <a href="contact.html" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Contact</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    <a href="login.html" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-blue-500 hover:text-white transition duration-300">Connexion</a>
                    <a href="register.html" class="py-2 px-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition duration-300">Inscription</a>
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
                <li><a href="index.html" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Accueil</a></li>
                <li><a href="boutique.html" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Boutique</a></li>
                <li><a href="panier.html" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Panier</a></li>
                <li><a href="contact.html" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Contact</a></li>
                <li><a href="login.html" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Connexion</a></li>
                <li><a href="register.html" class="block text-sm px-2 py-4 text-white bg-blue-500 font-semibold">Inscription</a></li>
            </ul>
        </div>
    </nav>

    <!-- Register Header -->
    <div class="bg-gray-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold mb-4" data-aos="fade-down">Créer un compte</h1>
            <p class="text-gray-300 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="100">
                Rejoignez Cartologue et profitez d'avantages exclusifs
            </p>
        </div>
    </div>

    <!-- Register Form -->
    <section class="py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8" data-aos="fade-up">
                <form id="registerForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-feather="user" class="w-4 h-4 inline mr-1"></i>
                                Prénom
                            </label>
                            <input type="text" id="firstName" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Jean">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-feather="user" class="w-4 h-4 inline mr-1"></i>
                                Nom
                            </label>
                            <input type="text" id="lastName" name="" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Dupont">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-feather="mail" class="w-4 h-4 inline mr-1"></i>
                            Adresse email
                        </label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="votre.email@exemple.com">
                    </div>

                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-feather="phone" class="w-4 h-4 inline mr-1"></i>
                            Téléphone (optionnel)
                        </label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="+33 6 12 34 56 78">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-feather="lock" class="w-4 h-4 inline mr-1"></i>
                            Mot de passe
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères avec majuscules, minuscules et chiffres</p>
                    </div>

                    <div class="mb-6">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-feather="lock" class="w-4 h-4 inline mr-1"></i>
                            Confirmer le mot de passe
                        </label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                    </div>

                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms" required
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                J'accepte les <a href="#" class="text-blue-500 hover:text-blue-700">conditions d'utilisation</a> 
                                et la <a href="#" class="text-blue-500 hover:text-blue-700">politique de confidentialité</a>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" id="newsletter" name="newsletter"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                            <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                                Je souhaite recevoir les offres spéciales et actualités par email
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded transition duration-300">
                        Créer mon compte
                    </button>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou s'inscrire avec</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 transition duration-300">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </button>
                        <button class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="#1877F2" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte ?
                        <a href="login.html" class="text-blue-500 hover:text-blue-700 font-semibold">
                            Connectez-vous
                        </a>
                    </p>
                </div>
            </div>

            <!-- Benefits -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <i data-feather="truck" class="w-8 h-8 mx-auto text-blue-500 mb-2"></i>
                    <h3 class="font-semibold text-gray-800 mb-1">Livraison gratuite</h3>
                    <p class="text-sm text-gray-600">Dès 50€ d'achat</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <i data-feather="gift" class="w-8 h-8 mx-auto text-blue-500 mb-2"></i>
                    <h3 class="font-semibold text-gray-800 mb-1">Offres exclusives</h3>
                    <p class="text-sm text-gray-600">Réductions membres</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <i data-feather="clock" class="w-8 h-8 mx-auto text-blue-500 mb-2"></i>
                    <h3 class="font-semibold text-gray-800 mb-1">Suivi en temps réel</h3>
                    <p class="text-sm text-gray-600">De vos commandes</p>
                </div>
            </div>
        </div>
    </section>

   

    

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
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Les mots de passe ne correspondent pas !');
                return;
            }
            
            if (password.length < 8) {
                alert('Le mot de passe doit contenir au moins 8 caractères !');
                return;
            }
            
            alert('Inscription réussie ! (Démo)');
        });
    </script>
</body>
</html>
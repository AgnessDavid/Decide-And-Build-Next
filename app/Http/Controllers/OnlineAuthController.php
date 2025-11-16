<?php

namespace App\Http\Controllers;

use App\Models\Online;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OnlineAuthController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('front.register'); // Crée ce fichier Blade
    }

    // Traite l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:onlines,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Online::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('online')->login($user);

        return redirect()->route('online.dashboard'); // à créer
    }

    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('front.login'); // Crée ce fichier Blade
    }

    // Traite la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('online')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('online.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::guard('online')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

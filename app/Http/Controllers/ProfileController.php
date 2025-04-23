<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de profil de l'utilisateur connecté.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Donne accès aux données de l'utilisateur connecté
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Remplit le modèle utilisateur avec les données validées
        $request->user()->fill($request->validated());

         // Si l'email a changé, il faut revérifier l'adresse
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null; // Réinitialise la date de vérification de l'email
        }

        $request->user()->save(); // Sauvegarde les modifications

        // Redirige vers la page de profil avec un message de confirmation
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprime le compte utilisateur après validation du mot de passe.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valide que le mot de passe fourni est correct
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user(); // Récupère l'utilisateur connecté

        Auth::logout(); // Déconnecte l'utilisateur

        $user->delete(); // Supprime le compte de l'utilisateur

        // Termine la session et régénère le token de session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

         // Redirige vers la page d'accueil
        return Redirect::to('/');
    }
}

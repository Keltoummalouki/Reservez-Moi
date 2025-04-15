<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Rediriger l'utilisateur vers le fournisseur d'authentification OAuth.
     *
     * @param string $provider Le fournisseur OAuth (google, facebook, etc.)
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtenir les informations utilisateur depuis le fournisseur OAuth.
     *
     * @param string $provider Le fournisseur OAuth (google, facebook, etc.)
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Vérifier si l'utilisateur existe déjà
            $user = $this->findOrCreateUser($socialUser, $provider);
            
            // Authentifier l'utilisateur
            Auth::login($user);
            
            // Marquer que l'authentification s'est faite via un réseau social
            Session::put('social_auth', $provider);
            
            // Rediriger en fonction du rôle de l'utilisateur
            return $this->redirectBasedOnRole($user);
            
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erreur lors de l\'authentification via ' . ucfirst($provider) . ': ' . $e->getMessage());
        }
    }
    
    /**
     * Trouver ou créer un utilisateur basé sur les informations OAuth.
     *
     * @param object $socialUser Les données utilisateur du fournisseur OAuth
     * @param string $provider Le fournisseur OAuth
     * @return \App\Models\User
     */
    protected function findOrCreateUser($socialUser, $provider)
    {
        // Vérifier si l'utilisateur existe avec l'ID du provider
        $user = User::where($provider . '_id', $socialUser->getId())->first();
        
        // Si l'utilisateur n'existe pas avec l'ID du provider, chercher par email
        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
            
            // Si l'utilisateur existe par email, mettre à jour son ID du provider
            if ($user) {
                $user->update([
                    $provider . '_id' => $socialUser->getId(),
                ]);
            }
        }
        
        // Si l'utilisateur n'existe toujours pas, le créer
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                $provider . '_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()), // Mot de passe aléatoire
            ]);
            
            // Attribuer le rôle Client par défaut
            $role = Role::where('name', 'Client')->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        }
        
        return $user;
    }
    
    /**
     * Rediriger l'utilisateur en fonction de son rôle.
     *
     * @param \App\Models\User $user L'utilisateur authentifié
     * @return \Illuminate\Http\Response
     */
    protected function redirectBasedOnRole($user)
    {
        $role = $user->roles->first();
        
        if (!$role) {
            Auth::logout();
            return redirect('/login')->withErrors('Erreur : aucun rôle attribué à cet utilisateur.');
        }
        
        switch ($role->name) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'ServiceProvider':
                return redirect()->route('provider.dashboard');
            case 'Client':
                return redirect()->route('client.services');
            default:
                Auth::logout();
                return redirect('/login')->withErrors('Erreur : rôle utilisateur inconnu.');
        }
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    public function attemptLogin(Request $request)
    {
        // Vérifier si la requête est bien une POST
        if ($request->isMethod('post')) {
            // Récupérer les informations du formulaire
            $identifiant = $request->input('username');
            $password = $request->input('password');

            // Vérifier si l'utilisateur existe
            $user = User::where('username', $identifiant)->first();
          
            if (!$user) {
                Log::warning("Tentative de connexion échouée : utilisateur inexistant ($identifiant)");
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiant ou mot de passe incorrect'
                ], 401);
            }

            // Vérifier le mot de passe
            if (!Hash::check($password, $user->password)) {
                Log::warning("Tentative de connexion échouée : mot de passe incorrect ($identifiant)");
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiant ou mot de passe incorrect'
                ], 401);
            }

            // Tentative d'authentification
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            // Tentative d'authentification
            if (Auth::attempt($credentials, true)) {
                $user = Auth::user();
                Log::info("Connexion réussie pour l'utilisateur ({$user->username})");
        
                return response()->json([
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email, // Ajoute d'autres champs si nécessaire
                    ],
                    'redirect' => route('app_habilitation_index'),
                ], 200);
            }
        
            // Échec de l'authentification
            Log::warning("Échec de connexion pour l'utilisateur ({$request->identifiant})");
        
            return response()->json([
                'success' => false,
                'message' => 'Identifiants incorrects'
            ], 401);

            // Dernier recours si Auth::attempt() échoue
            Log::error("Échec d'authentification pour l'utilisateur ($identifiant) malgré les vérifications.");
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la connexion'
            ], 500);
        }

        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->away('https://obj-app-04/utils/public/login');
    }


   
}

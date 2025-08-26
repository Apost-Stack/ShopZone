<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Base\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthentificateController extends Controller
{
    public function loginView()
    {
        return view("auth.login");
    }

    public function registerCustomerView()
    {
        $provinces = Province::all();
        return view("auth.register-customer", compact('provinces'));
    }
    /**
     * Login (session + optional API token if HasApiTokens)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('message', 'Authentifié avec succès');
        }

        return redirect()->back()->withErrors(['email' => 'Identifiants invalides'])->withInput();
    }


    /**
     * Logout — supprime le token (si présent) et invalide la session
     */
    public function logout(Request $request)
    {
        // Révoquer token API si présent (Sanctum/Passport)
        if ($request->user()?->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Déconnecté']);
    }

    /**
     * Envoi du lien de réinitialisation (forgot password)
     */
    public function forgotPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(['email' => $data['email']]);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Lien de réinitialisation envoyé']);
        }

        return response()->json(['message' => 'Impossible d\'envoyer le lien de réinitialisation'], 500);
    }

    /**
     * Reset password (avec token reçu par e-mail)
     */
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $data['token'],
            ],
            function (User $user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                // Optionnel : révoquer tous les tokens API
                if (method_exists($user, 'tokens')) {
                    $user->tokens()->delete();
                }
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Mot de passe réinitialisé']);
        }

        return response()->json(['message' => 'Impossible de réinitialiser le mot de passe'], 400);
    }

    /**
     * Redirige vers le provider OIDC / OAuth via Socialite.
     *
     * Exemple de $provider : 'google', 'github', 'azure'
     */
    public function redirectToProvider(string $provider)
    {
        // Utiliser redirect() pour flux web; stateless() possible côté API clients
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Callback du provider OIDC / OAuth.
     * - Crée l'utilisateur s'il n'existe pas (role = customer par défaut).
     * - Connecte l'utilisateur (session).
     * - Génère un token API si disponible.
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        DB::beginTransaction();
        try {
            // Utiliser stateless() si vous n'utilisez pas la session (API clients)
            $socialUser = Socialite::stateless()->driver($provider)->user();

            $email = $socialUser->getEmail();
            if (!$email) {
                return response()->json(['message' => 'Le provider n\'a pas fourni d\'email.'], 422);
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                // Créer un account minimal
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? explode('@', $email)[0],
                    'email' => $email,
                    'password' => Hash::make(Str::random(32)), // login via provider
                    'role' => RoleEnum::CUSTOMER->value,
                ]);

                // Si la relation customer existe, créer une fiche customer minimale (silently)
                if (method_exists($user, 'customer')) {
                    $first = $socialUser->user['given_name'] ?? null;
                    $last = $socialUser->user['family_name'] ?? null;
                    $user->customer()->create([
                        'first_name' => $first,
                        'last_name' => $last,
                        'phone' => null,
                        'user_id' => $user->id,
                    ]);
                }
            }

            // Log the user in (session)
            Auth::login($user, true);

            $token = null;
            if (method_exists($user, 'createToken')) {
                $token = $user->createToken($provider . '-token')->plainTextToken;
            }

            DB::commit();

            // Retour JSON (API). Si usage web, tu peux rediriger vers une route frontale.
            return response()->json([
                'message' => 'Authentifié via ' . $provider,
                'user' => $user->load('customer','employee'),
                'token' => $token,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du login via provider', 'error' => $e->getMessage()], 500);
        }
    }
}

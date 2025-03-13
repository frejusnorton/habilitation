<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use App\Models\portail\PortalUser;
use App\Models\User;
use App\Service\UserHisoryService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Portal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            
        if (!$request->session()->has('authUser')) {
            if (isset($_GET['token'])) {
                //récupérer et vérifier si le token est valide et qu'il ensuite renvoyer l'utilisateur courant
                if (PortalUser::where('token', '=', $_GET['token'])->exists()) {
                    $currenttt = PortalUser::where('token', '=', $_GET['token'])->first();
                    $exp = Carbon::parse($currenttt->exp);

                    if ($exp->gt(Carbon::now())) {
                        if ($currenttt->username) {
                            if (User::where('username', $currenttt->username)->where('statut', '=', 1)->where('statut_delete', '=', 0)->exists()) {
                                $user = User::where('username', $currenttt->username)->where('statut', '=', 1)->where('statut_delete', '=', 0)->first();
                                // if ($user->auth_type === 'ldap') {
                                //     dd('in');
                                //     return redirect('login')->with(['typeAnswer' => 'Veuillez vous connecter']);
                                // }
                                Session::put('authUser', $currenttt->username);
                                Session::put('userAction', buildUserAction($user->userRole->actions));
                                Auth::login($user);
                                Session::put('portal_authenticated', true);
                            } else {
                                return redirect('notautorized')
                                    ->with(['typeAnswer' => 'Vous n\'etes pas autorisé à utiliser cette application. Veuillez contater le support ']);
                            }
                        } else {
                            return redirect('notautorized')->with(['typeAnswer' => 'Vous n\'avez pas les accès nécessaires pour cette application']);
                        }
                    } else {
                        return redirect('notautorized')->with(['typeAnswer' => 'Votre session a expiré']);
                    }
                } else {
                    return redirect('notautorized')->with(['typeAnswer' => 'Vous ne disposez pas des accès nécessaires pour cette application']);
                }
            } else {
                return redirect('notautorized')->with(['typeAnswer' => 'Vous êtes actuellement déconnecté. Veuillez passer par le portail ']);
            }
        }
      
        $currentU = User::where('username', '=', session('authUser'))->where('statut', '=', 1)->where('statut_delete', '=', 0)->first();
        if ($currentU) {
            Session::put('userAction', buildUserAction($currentU->userRole->actions));
        } else {
            return redirect('notautorized')->with(['typeAnswer' => 'Vous ne disposez pas des accès nécessaires pour cette application']);
        }
        return $next($request);
    }
}

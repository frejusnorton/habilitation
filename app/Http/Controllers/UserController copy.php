<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Poste;
use App\Models\Entity;
use App\Helpers\Helper;
use App\Models\Employe;
use App\Models\Approbateur;
use Illuminate\Support\Str;
use App\Events\UserActivity;
use Illuminate\Http\Request;
use App\Models\ConfigPassword;
use Illuminate\Http\JsonResponse;
use App\Service\UserHisoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::filter($request->search, $request->role, $request->statut);
        $roles = Role::where('statut', 1)->get();

        if ($request->ajax()) {
            return view('user.datapart', ['users' => $users,  'roles' => $roles]);
        }
        UserHisoryService::logActivity('Consulte la liste des utilisateurs');
        return view('user.index', ['users' => $users,  'roles' => $roles]);
    }

    /**
     * Create
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        #Validation
        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|max:255',
                'prenom' => 'required|max:255',
                'email' => 'required|email|max:255',
                'username' => 'required|unique:users|max:255',
                'role' => 'required',
                'poste' => 'required'
            ]
        );
        
        if ($validator->fails()) {
            return response()->json(['message' => view('configuration.jour.error', ['errors' => $validator->errors()])->render(), 'statut' => 'error']);
        }

        $defaultPswd = ConfigPassword::first();
        if (!$defaultPswd) {
            return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Config non defini', 'code' => '00001'])->render(), 'statut' => 'error']);
        }

        # recuperation des donnees et formatage-------------
        $input = $request->all();

        # Recuperation du role
        $role = Role::where('role_name', 'EMPLOYE')->first();

        if ($role) {
            $roleId = $role->id;
        } else {
            return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Role non defini', 'code' => '00002'])->render(), 'statut' => 'error']);
        }

        # Enregistrement des users-----------------------
        $user = User::create([
            'id' => Str::uuid(),
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($defaultPswd->default_password),
            'role' => $roleId,
            'initiated_at' => Carbon::now()
        ]);

        # Fin------------------------------------------------
        event(new UserActivity(Auth::user()->username . " a cree l'utilisateur  " . $user->username));
        UserHisoryService::logActivity("Creer l'utilisateur " . $user->username);

        return response()->json(['message' => 'Utilsateur creer avec success', 'statut' => 'success']);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return false|JsonResponse
     */
    public function editUser(Request $request, User $user)
    {
        if ($request->method() == 'GET') {
            $entities = Entity::where('statut', 1)->get();
            $postes = Poste::where('statut', 1)->get();
            $approbateurs = User::with('employe')->where('statut', 0)->where('username', '<>', 'admin')->orderBy('created_at', 'desc')->get();
            return response()->json(['user' => $user]);
        }
        if ($request->method() == 'POST') {
            #Validation
            $validator = Validator::make($request->all(), ['matricule' => 'required|max:255|unique:app2.employes,matricule,' . $user->employe->id, 'nom' => 'required|max:255', 'prenom' => 'required|max:255', 'poste' => 'required|max:255', 'date_embauche' => 'required|date', 'username' => 'required|max:255|unique:app2.users,username,' . $user->id, 'email' => 'required|email|max:255|unique:app2.users,email,' . $user->id,]);

            if ($validator->fails()) {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => $validator->errors()])->render(), 'statut' => 'error']);
            }

            $defaultPswd = ConfigPassword::first();
            if (!$defaultPswd) {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Config non defini', 'code' => '00001'])->render(), 'statut' => 'error']);
            }

            # recuperation des donnees et formatage-------------
            $input = $request->all();

            if ($request->has('validation_rh')) {
                $validation_rh = true;
            } else {
                $validation_rh = false;
            }

            if ($request->has('manager')) {
                $manager = true;
            } else {
                $manager = false;
            }

            $employeData = ['matricule' => $input['matricule'], 'login' => $input['username'], 'nom' => $input['nom'], 'prenoms' => $input['prenom'], 'email' => $input['email'], 'date_embauche' => Carbon::parse($input['date_embauche']), 'poste' => $input['poste'], 'entite_id' => $input['entite'], 'validation_rh' => $validation_rh, 'manager' => $manager];

            # Enregistrement des users------------------------
            $user->update(['email' => $input['email'], 'username' => $input['username'], 'auth_type' => $input['auth_type'], 'updated_at' => Carbon::now()]);

            # Enregistrement de l'employe----------------------
            $user->employe->update($employeData);

            # Enregistrement des approbateurs-----------------

            Self::saveApprovale(1, $request, $user, $user->employe);

            # Fin------------------------------------------------
            event(new UserActivity(Auth::user()->username . " a modifie l'utilisateur  " . $user->username));
            UserHisoryService::logActivity("Modifier l'utilisateur " . $user->username);

            return response()->json(['message' => 'Utilsateur modifier avec success', 'statut' => 'success']);
        }
        return false;
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function Initdelete(User $user, Request $request)
    {
        $user->statut_delete = -1;
        $user->save();
        UserHisoryService::log($user->id, 'INIT_DELETE', $request->comment);
        UserHisoryService::logActivity("A initie la suppression de  l'utilisateur " . $user->username);
        return response()->json(['statut' => 'success', 'message' => 'Suppression initiee avec success']);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function CancelDelete(User $user, Request $request)
    {
        $user->statut = 1;
        $user->save();
        UserHisoryService::log($user->id, 'CANCEL_DELETE', $request->comment);
        UserHisoryService::logActivity("A annuler la suppression de  l'utilisateur " . $user->username);

        return response()->json(['statut' => 'success', 'message' => 'Suppression annulee avec success']);
    }

    public function delete(User $user, Request $request)
    {
        $user->statut_delete = 1;
        $user->save();
        UserHisoryService::log($user->id, 'VALIDATE_DELETE', $request->comment);
        UserHisoryService::logActivity("A confirme la suppression de  l'utilisateur " . $user->username);
        return response()->json(['statut' => 'success', 'message' => 'Suppression effectuee avec success']);
    }

    public function activateOrDisableUser(User $user, Request $request)
    {
        if ($user->statut == 0) {

            $user->statut = 1;
            $user->authorized_at = Carbon::now();
            $user->authorized_by = Auth::user()->id;

            $user->save();
            UserHisoryService::log($user->id, 'USER_ACTIVATED', $request->comment);
            UserHisoryService::logActivity("A confirme l'activation de  l'utilisateur " . $user->username);
            return response()->json(['statut' => 'success', 'message' => 'Activation effectuee avec succes']);
        }
        if ($user->statut == 1) {

            $user->statut = 0;
            $user->save();
            UserHisoryService::log($user->id, 'USER_DISABLED', $request->comment);
            UserHisoryService::logActivity("A confirme la desactivation de  l'utilisateur " . $user->username);
            return response()->json(['statut' => 'success', 'message' => 'Desactivation effectuee avec success']);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUniqueUsername(Request $request)
    {
        if (!empty($request->username)) {

            if (!empty($request->id)) {
                $users_count = Employe::where('login', $request->username)->where('id', $request->id)->count();
                if ($users_count == 1) {
                    return response()->json(['valid' => true]);
                }

                $users_count = Employe::where('login', $request->username)->count();
                if ($users_count == 1) {
                    return response()->json(['valid' => false]);
                }
            } else {
                $users_count = Employe::where('login', $request->username)->count();
            }

            if ($users_count == 0) {
                return response()->json(['valid' => true]);
            } else {
                return response()->json(['valid' => false]);
            }
        } else {
            return response()->json(['valid' => false]);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUniqueMatricule(Request $request)
    {
        if (!empty($request->matricule)) {

            if (!empty($request->id)) {
                $users_count = Employe::where('matricule', $request->matricule)->where('id', $request->id)->count();
                if ($users_count == 1) {
                    return response()->json(['valid' => true]);
                }

                $users_count = Employe::where('matricule', $request->matricule)->count();
                if ($users_count == 1) {
                    return response()->json(['valid' => false]);
                }
            } else {
                $users_count = Employe::where('matricule', $request->matricule)->count();
            }

            if ($users_count == 0) {
                return response()->json(['valid' => true]);
            } else {
                return response()->json(['valid' => false]);
            }
        } else {
            return response()->json(['valid' => false]);
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function getUserAppro(Request $request)
    {
        return view('user.appro', ['userAppros' => Helper::getApprobateurs($request->id), 'approbateurs' => User::with('employe')->where('statut', 0)->where('username', '<>', 'admin')->orderBy('created_at', 'desc')->get(),]);
    }


    /**
     * @param $type
     * @param $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse|void
     */
    public static function saveApprovale($type = 0, $request, $user, $employe)
    {

        if ($type == 1 && $user != null) { //Cas de modification
            Approbateur::where('users_id', $user->id)->delete();
        }

        if ($request->has('approbateur1') && $request->approbateur1 != null) {
            $userAppro = User::where('id', $request->approbateur1)->first();
            if ($userAppro) {
                $employe->approbateur1 = $userAppro->id;
                $approbateurs[] = ['id' => Str::uuid(), 'position' => 1, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
            } else {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
            }
        }

        if ($request->has('approbateur2') && $request->approbateur2 != null) {
            $userAppro = User::where('id', $request->approbateur2)->first();
            if ($userAppro) {
                $employe->approbateur2 = $userAppro->id;

                $approbateurs[] = ['id' => Str::uuid(), 'position' => 2, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
            } else {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
            }
        }

        if ($request->has('approbateur3') && $request->approbateur3 != null) {
            $userAppro = User::where('id', $request->approbateur3)->first();
            $employe->approbateur3 = $userAppro->id;

            if ($userAppro) {
                $approbateurs[] = ['id' => Str::uuid(), 'position' => 3, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
            } else {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
            }
        }

        if ($request->has('approbateur4') && $request->approbateur4 != null) {
            $userAppro = User::where('id', $request->approbateur4)->first();

            if ($userAppro) {
                $employe->approbateur4 = $userAppro->id;

                $approbateurs[] = ['id' => Str::uuid(), 'position' => 4, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
            } else {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
            }
        }

        if ($request->has('approbateur5') && $request->approbateur5 != null) {
            $userAppro = User::where('id', $request->approbateur5)->first();
            if ($userAppro) {
                $approbateurs[] = ['id' => Str::uuid(), 'position' => 5, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
            } else {
                return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
            }
        }

        Approbateur::insert($approbateurs);
        $employe->save();
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use App\Models\Direction;
use App\Models\Departement;
use App\Events\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Service\UserHisoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
      
        $users = User::with(['validateur1', 'validateur2', 'validateur3'])
            ->filter($request->search, $request->role, $request->statut)
            ->paginate(10);


        if ($request->ajax()) {
            return view('user.datapart', [
                'users' => $users
            ]);
        }
        $roles = Role::where('statut', 1)->get();
        $services = Service::all();
        $agences = Agence::all();
        $departements = Departement::all();
        $directions = Direction::all();


        if ($request->ajax()) {
            return view('user.datapart', ['users' => $users,  'roles' => $roles]);
        }

        // $columns = Schema::getColumnListing('users');
        // dd($columns);


        // try {
        //     $updated = User::where('username', 'fatoumata.konare')->update(['auth_type' => 'local']);

        //     if ($updated) {
        //         return response()->json(['message' => 'Mise à jour réussie'], 200);
        //     } else {
        //         return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        //     }
        // } catch (\Exception $e) {
        //     Log::error("Erreur lors de la mise à jour : " . $e->getMessage());
        //     return response()->json(['message' => 'Une erreur est survenue'], 500);
        // }
        UserHisoryService::logActivity('Consulte la liste des utilisateurs');
        return view(
            'user.index',
            [
                'users' => $users,
                'roles' => $roles,
                'services' => $services,
                'agences' => $agences,
                'departements' => $departements,
                'directions' => $directions,
            ]
        );
    }
    /**
     * Create
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|max:255',
                'prenom' => 'required|max:255',
                'email' => 'required|email|max:255',
                'username' => 'required|unique:users|max:255',
                'role' => 'required',
                'poste' => 'required',
                'agence' => 'required',
            ],
            [
                'nom.required' => 'Le champ nom est obligatoire.',
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',

                'prenom.required' => 'Le champ prénom est obligatoire.',
                'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

                'email.required' => 'Le champ email est obligatoire.',
                'email.email' => 'Le champ email doit être une adresse email valide.',
                'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',

                'username.required' => 'Le champ nom d\'utilisateur est obligatoire.',
                'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
                'username.max' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères.',

                'role.required' => 'Le rôle est obligatoire.',
                'agence.required' => 'L\'agence est obligatoire.',

                'poste.required' => 'Le poste est obligatoire.',

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $validatedRequest = $validator->getData();
            $user = new User();
            $user->poste = $validatedRequest['poste'];
            $user->email = $validatedRequest['email'];
            $user->username = $validatedRequest['username'];
            $user->nom = $validatedRequest['nom'];
            $user->prenom = $validatedRequest['prenom'];
            $user->agence_id = $validatedRequest['agence'];
            $user->direction_id = $validatedRequest['direction'];
            $user->service_id = $validatedRequest['service'];
            $user->auth_type = $validatedRequest['connexion'] ?? 'ldap';
            $user->superieur_id = $validatedRequest['superieur'] ?? null;
            $user->departement_id = $validatedRequest['departement'];
            $user->validateur_1 = $validatedRequest['validateur_1'] ?? null;
            $user->validateur_2 = $validatedRequest['validateur_2'] ?? null;
            $user->validateur_3 = $validatedRequest['validateur_2'] ?? null;
            $user->role = $validatedRequest['role'];
            $user->statut = 1;
            $user->password =  Hash::make('P@ssw0rd');

            $user->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return false|JsonResponse
     */
    public function modifier(Request $request, User $user)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|max:255',
                'prenom' => 'required|max:255',
                'email' => 'required|email|max:255',
                'username' => 'required|max:255|unique:users,username,' . $user->id . ',id',
                'role' => 'required',
                'poste' => 'required',
                'agence' => 'required',
                'direction' => 'required',
                // 'superieur' => 'required',

            ],
            [
                'nom.required' => 'Le  nom est obligatoire.',
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',

                'prenom.required' => 'Le  prénom est obligatoire.',
                'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'Email non valide',
                'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',

                'username.required' => 'L\'identifiant est obligatoire',
                'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
                'username.max' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères.',

                'role.required' => 'Le rôle est obligatoire.',
                'agence.required' => 'L\'agence est obligatoire.',
                'direction.required' => 'La direction est obligatoire.',

                'poste.required' => 'Le poste est obligatoire.',
                // 'superieur.required' => 'Veuillez choisir votre supérieur hiérachique.',


            ]
        );
        $validateur1 = $request->input('validateur_1');
        $validateur2 = $request->input('validateur_2');

        if (!empty($validateur1) && !empty($validateur2) && $validateur1 === $validateur2) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'validateur1' => ["Le premier validateur doit être différent du deuxième validateur"],
                    'validateur2' => ["Le premier validateur doit être différent du deuxième validateur"],
                ]
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // dd($request->all());
            $validatedRequest = $validator->getData();
            $user->nom = $validatedRequest['nom'];
            $user->prenom = $validatedRequest['prenom'];
            $user->email = $validatedRequest['email'];
            $user->username = $validatedRequest['username'];
            $user->role = $validatedRequest['role'];
            $user->poste = $validatedRequest['poste'];
            $user->agence_id = $validatedRequest['agence'];
            $user->service_id = $validatedRequest['service'];
            $user->direction_id = $validatedRequest['direction'];
            $user->departement_id = $validatedRequest['departement'];
            $user->auth_type = $validatedRequest['connexion'] ?? 'ldap';
            $user->superieur_id = $validatedRequest['superieur'] ?? null;
            $user->validateur_1 = $validatedRequest['validateur_1']  ?? null;
            $user->validateur_2 = $validatedRequest['validateur_2']  ?? null;
            $user->validateur_3 = $validatedRequest['validateur_3']  ?? null;
            $user->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
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
    // public function checkUniqueUsername(Request $request)
    // {
    //     if (!empty($request->username)) {

    //         if (!empty($request->id)) {
    //             $users_count = Employe::where('login', $request->username)->where('id', $request->id)->count();
    //             if ($users_count == 1) {
    //                 return response()->json(['valid' => true]);
    //             }

    //             $users_count = Employe::where('login', $request->username)->count();
    //             if ($users_count == 1) {
    //                 return response()->json(['valid' => false]);
    //             }
    //         } else {
    //             $users_count = Employe::where('login', $request->username)->count();
    //         }

    //         if ($users_count == 0) {
    //             return response()->json(['valid' => true]);
    //         } else {
    //             return response()->json(['valid' => false]);
    //         }
    //     } else {
    //         return response()->json(['valid' => false]);
    //     }
    // }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    // public function checkUniqueMatricule(Request $request)
    // {
    //     if (!empty($request->matricule)) {

    //         if (!empty($request->id)) {
    //             $users_count = Employe::where('matricule', $request->matricule)->where('id', $request->id)->count();
    //             if ($users_count == 1) {
    //                 return response()->json(['valid' => true]);
    //             }

    //             $users_count = Employe::where('matricule', $request->matricule)->count();
    //             if ($users_count == 1) {
    //                 return response()->json(['valid' => false]);
    //             }
    //         } else {
    //             $users_count = Employe::where('matricule', $request->matricule)->count();
    //         }

    //         if ($users_count == 0) {
    //             return response()->json(['valid' => true]);
    //         } else {
    //             return response()->json(['valid' => false]);
    //         }
    //     } else {
    //         return response()->json(['valid' => false]);
    //     }
    // }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    // public function getUserAppro(Request $request)
    // {
    //     return view('user.appro', ['userAppros' => Helper::getApprobateurs($request->id), 'approbateurs' => User::with('employe')->where('statut', 0)->where('username', '<>', 'admin')->orderBy('created_at', 'desc')->get(),]);
    // }


    /**
     * @param $type
     * @param $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse|void
     */
    // public static function saveApprovale($type = 0, $request, $user, $employe)
    // {

    //     if ($type == 1 && $user != null) { //Cas de modification
    //         Approbateur::where('users_id', $user->id)->delete();
    //     }

    //     if ($request->has('approbateur1') && $request->approbateur1 != null) {
    //         $userAppro = User::where('id', $request->approbateur1)->first();
    //         if ($userAppro) {
    //             $employe->approbateur1 = $userAppro->id;
    //             $approbateurs[] = ['id' => Str::uuid(), 'position' => 1, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
    //         } else {
    //             return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
    //         }
    //     }

    //     if ($request->has('approbateur2') && $request->approbateur2 != null) {
    //         $userAppro = User::where('id', $request->approbateur2)->first();
    //         if ($userAppro) {
    //             $employe->approbateur2 = $userAppro->id;

    //             $approbateurs[] = ['id' => Str::uuid(), 'position' => 2, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
    //         } else {
    //             return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
    //         }
    //     }

    //     if ($request->has('approbateur3') && $request->approbateur3 != null) {
    //         $userAppro = User::where('id', $request->approbateur3)->first();
    //         $employe->approbateur3 = $userAppro->id;

    //         if ($userAppro) {
    //             $approbateurs[] = ['id' => Str::uuid(), 'position' => 3, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
    //         } else {
    //             return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
    //         }
    //     }

    //     if ($request->has('approbateur4') && $request->approbateur4 != null) {
    //         $userAppro = User::where('id', $request->approbateur4)->first();

    //         if ($userAppro) {
    //             $employe->approbateur4 = $userAppro->id;

    //             $approbateurs[] = ['id' => Str::uuid(), 'position' => 4, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
    //         } else {
    //             return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
    //         }
    //     }

    //     if ($request->has('approbateur5') && $request->approbateur5 != null) {
    //         $userAppro = User::where('id', $request->approbateur5)->first();
    //         if ($userAppro) {
    //             $approbateurs[] = ['id' => Str::uuid(), 'position' => 5, 'approbateur' => $userAppro->id, 'users_id' => $user->id,];
    //         } else {
    //             return response()->json(['message' => view('configuration.jour.error', ['errors' => 'Approbateur non trouve'])->render(), 'statut' => 'error']);
    //         }
    //     }

    //     Approbateur::insert($approbateurs);
    //     $employe->save();
    // }
}

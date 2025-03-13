<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Agence;
use App\Models\Champs;
use App\Mail\NotifMail;
use App\Models\Demande;
use App\Models\Service;
use App\Models\Direction;
use App\Models\Application;
use App\Models\Departement;
use Illuminate\Support\Str;
use App\Models\DemandeField;
use Illuminate\Http\Request;
use App\Models\FluxHistorique;
use App\Models\ApplicationField;
use App\Models\DemandeApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class HblController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with(['champs', 'roles'])->orderBy('libelle', 'asc')->get();
        $user = auth()->user();

        $demandes = ($user->userRole->role_name === 'ALLTEST')
            ? Demande::filter($request->search, $request->statut)->paginate(10)
            : Demande::where('user_id', auth()->id())
            ->filter($request->search, $request->statut)
            ->with('application')
            ->paginate(10);
            // dd( $demandes);
        if ($request->ajax()) {
            return view('habilitation.datatable', [
                'demandes' => $demandes,
                'user' => $user
            ]);
        }
        return view('habilitation.index', [
            'demandes' => $demandes,
            'applications' =>    $applications,
            'user' => $user
        ]);
    }

    public function create(Request $request)
    {
        $agences = Agence::all();
        $directions = Direction::all();
        $services = Service::all();
        $departements = Departement::all();
        $userConnecte = auth()->user();

        $validateur1 =  $userConnecte->validateur_1;
        $validateur2 =  $userConnecte->validateur_2;
        $validateur3 =  $userConnecte->validateur_3;

        // $users = User::where('id', '!=', $userConnecte->id)->get();
        $users = User::where('id', '!=', $userConnecte->id)
            ->whereHas('userRole', function ($query) {
                $query->where('role_name', '!=', 'APPROBATEUR');
            })
            ->get();

        $applications = Application::with(['champs', 'roles'])->orderBy('libelle', 'asc')->get();

        if ($request->isMethod('post')) {
            // dd($request->all());
            $validator = Validator::make(
                $request->all(),
                [
                    "type_demande" => 'required',
                    "applications" => 'required',
                    "roles" => 'required',
                    "validateur_1" => 'required',
                ],
                [
                    'type_demande.required' => "Le type d'habilitation est obligatoire",
                    'applications.required' => "L'application est obligatoire",
                    'roles.required' => "Le rôle dans l'application est obligatoire",
                    'validateur_1.required' => "Le validateur 1 est obligatoire",
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            $validateur_1 = $request->input('validateur_1');
            $validateur_2 = $request->input('validateur_2');

            if ($validateur_1 === $validateur_2) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'validateur_1' => ["Le validateur 1 doit être différent du validateur 2"],
                        'validateur_2' => ["Le validateur 1 doit être différent du validateur 2"],
                    ]
                ], 422);
            }

            $user = Auth::user();
            DB::beginTransaction();
            try {
                // dd($request->all());
                $validatedRequest = $validator->getData();
                $demande = new Demande();
                $demande->type_demande = $validatedRequest['type_demande'];
                $demande->reference = 'REF-' . strtoupper(Str::random(8));
                $demande->user_id = Auth::user()->id;
                $demande->save();

                $validateurs = [
                    $request->input('validateur_1'),
                    $request->input('validateur_2'),
                ];
                //HISTORIQUE
                $historiques = [];
                foreach ($validateurs as $validateur) {
                    if ($validateur) {
                        $historique = new FluxHistorique();
                        $historique->demande_id = $demande->id;
                        $historique->validatedBy = $validateur;
                        $historique->commentaires = $request->input('commentaire') ?? null;
                        $historique->updated_at = now()->format('Y-m-d H:i:s');
                        $historique->created_at = now()->format('Y-m-d H:i:s');
                        $historiques[] = $historique;
                    }
                }
                foreach ($historiques as $historique) {
                    $historique->save();
                }
                //DEMANDE APPLICATION
                $applications = $request->input('applications');
                $roles = $request->input('roles');
                $demande_applications = [];
                foreach ($applications as $application) {
                    if ($application && isset($roles[$application])) {
                        $demande_application = new DemandeApplication();
                        $demande_application->application_id = $application;
                        $demande_application->profil_id = $roles[$application];
                        $demande_application->demande_id = $demande->id;
                        $demande_applications[] = $demande_application;
                    }
                }
                // dd($demande_applications);
                foreach ($demande_applications as $demande_application) {
                    $demande_application->save();
                }

                //CHAMPS 
                $selectedApplications = $request->input('applications');
                $demandeFields = [];
                foreach ($selectedApplications as $applicationId) {
                    $champs = collect(ApplicationField::where('application_id', $applicationId)->pluck('champs_id'));
                    if ($champs->isEmpty()) {
                        continue;
                    }
                    $champsDetails = Champs::whereIn('id', $champs)->get();
                    foreach ($champsDetails as $champ) {
                        $champCode = $champ->code;
                        $fieldValue = $request->input("champs.{$applicationId}.{$champCode}");

                        if ($fieldValue === null) {
                            continue;
                        }
                        // Créer un enregistrement pour chaque champ valide
                        $demandeField = new DemandeField();
                        $demandeField->demande_id = $demande->id;
                        $demandeField->application_id = $applicationId;
                        $demandeField->champs_id = $champ->id;
                        $demandeField->value = $fieldValue;
                        $demandeFields[] = $demandeField;
                    }
                }
                foreach ($demandeFields as $demandeField) {
                    $demandeField->save();
                }

                $validateur1 = User::find($request->input('validateur_1'));

                if ($validateur1) {
                    try {
                        Log::info("Envoi d'un email au validateur 1 : {$validateur1->email} pour la demande #{$demande->reference}");
                        Mail::send('mail.demande', ['demande' => $demande, 'validateur' => $validateur1], function ($message) use ($validateur1) {
                            $message->to($validateur1->email)
                                ->subject("Nouvelle demande d'habilitation à valider");
                        });
                        Log::info("Email envoyé avec succès au validateur 1 : {$validateur1->email}");
                    } catch (\Exception $e) {
                        Log::error("Échec de l'envoi de l'email au validateur 1 : {$validateur1->email}. Erreur : " . $e->getMessage());
                    }
                } else {
                    Log::warning("Aucun validateur 1 trouvé pour la demande #{$demande->reference}");
                }
                DB::commit();
                return response()->json(['message' => successMessage(), 'success' => true, "redirect" => route('app_habilitation_index')]);
            } catch (\Throwable $th) {
                Log::info($th);
                DB::rollBack();
                return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
            }
        }

        return view('habilitation.create', [
            'applications' => $applications,
            'users' => $users,
            'agences' => $agences,
            'services' => $services,
            'departements' => $departements,
            'directions' => $directions,
            'validateur1' =>  $validateur1,
            'validateur2' =>  $validateur2,
            'validateur3' =>  $validateur3,

        ]);
    }

    public function deleteDemande(Demande $demande)
    {
        // Vérifie si la demande existe
        if (!$demande) {
            return response()->json([
                'success' => false,
                'message' => 'Demande non trouvée'
            ], 404); // HTTP 404 Not Found
        }

        try {
            $demande->delete();

            return response()->json([
                'success' => true,
                'message' => 'Demande supprimée avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la demande',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function details(Demande $demande)
    {
        $demande->load(['fluxHistoriques', 'user.superieur', 'application.profil', 'field', 'application.fields']);
        // Récupérer les approbateurs
        $roleId = Role::where('role_name', 'APPROBATEUR')->first()->id;
        $user_approbateurs = User::where('role', $roleId)->get();

        $fluxHistorique = FluxHistorique::where('demande_id', $demande->id)->first();

        $approbationStatuses = [];

        if ($fluxHistorique) {
            foreach ($user_approbateurs as $approbateur) {
                for ($i = 1; $i <= 4; $i++) {
                    if ($fluxHistorique->{"approbateur$i"} == $approbateur->id) {
                        $approbationStatuses[$approbateur->id] = $fluxHistorique->{"approbateur{$i}_valide"} == 1;
                        break;
                    }
                }
            }
        }
        return view('habilitation.details.index', [
            'demande' => $demande,
            'approbateurs' => $user_approbateurs,
            'approbationStatuses' => $approbationStatuses,
        ]);
    }

    public function demandeAttente(Request $request)
    {
        $userConnecte = auth()->user();
        $demandes = Demande::whereHas('fluxHistoriques', function ($query) use ($userConnecte) {
            $query->where('validatedby', $userConnecte->id);
        })->get();
        // Filtrer les demandes pour s'assurer que les validateurs précédents ont validé
        $demandesFiltrees = $demandes->filter(function ($demande) use ($userConnecte) {
            // Récupérer les flux historiques triés par ID (ordre de validation)
            $fluxHistoriques = $demande->fluxHistoriques()->orderBy('id')->get();
            // Trouver le flux correspondant à l'utilisateur actuel
            $fluxUtilisateur = $fluxHistoriques->firstWhere('validatedby', $userConnecte->id);
            // Trouver l'index de l'utilisateur actuel
            $indexActuel = $fluxHistoriques->search($fluxUtilisateur);
            // Vérifier que tous les validateurs précédents ont validé
            for ($i = 0; $i < $indexActuel; $i++) {
                if ($fluxHistoriques[$i]->statut == 0 || $fluxHistoriques[$i]->statut == 3) {
                    return false; // Un validateur précédent n'a pas validé
                }
            }
            return true;
        });

        foreach ($demandesFiltrees as $demande) {
            try {
                // Vérifier et loguer les flux historiques associés à la demande
                Log::info('Traitement d\'une demande', ['demande_id' => $demande->id]);
                $fluxHistorique = $demande->fluxHistoriques()->where('validatedby', $userConnecte->id)->first();

                if (!$fluxHistorique) {
                    Log::warning('Aucun flux historique trouvé pour le validateur', [
                        'demande_id' => $demande->id,
                        'user_id' => $userConnecte->id,
                    ]);
                    continue;
                }

                $validateur = User::find($fluxHistorique->validatedby);
                if (!$validateur) {
                    Log::warning('Validateur introuvable', [
                        'demande_id' => $demande->id,
                        'validatedby' => $fluxHistorique->validatedby,
                    ]);
                    continue;
                }
                if ($validateur->email) {
                    Mail::to($validateur->email)->send(new NotifMail($demande, $validateur));
                    Log::info('Email envoyé avec succès', [
                        'demande_id' => $demande->id,
                        'validateur_id' => $validateur->id,
                        'email' => $validateur->email,
                    ]);
                } else {
                    Log::warning('Le validateur n\'a pas d\'adresse email', [
                        'validateur_id' => $validateur->id,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors du traitement ou de l\'envoi de l\'email', [
                    'demande_id' => $demande->id ?? null,
                    'erreur' => $e->getMessage(),
                ]);
            }
        }
        $demandesPaginees = $demandesFiltrees;
        return view('validateur.attente.index', [
            'demandes' => $demandesPaginees
        ]);
    }

    public function detailValidation(Demande $demande)
    {
        $userConnecte = auth()->user();
        $demande->load(['fluxHistoriques', 'application.profil', 'field']);
        $validationStatut = null;
        $approbateurs = User::whereHas('userRole', function ($query) {
            $query->where('role_name', 'APPROBATEUR');
        })->get();

        foreach ($demande->fluxHistoriques as $fluxHistorique) {
            if ($fluxHistorique->validatedby == $userConnecte->id) {
                $validationStatut = $fluxHistorique->statut;
                break;
            }
        }
        
        return view('validateur.index', [
            'demande' => $demande,
            'validationStatut' => $validationStatut,
            'approbateurs' =>  $approbateurs
        ]);
    }
    public function validerDemande(Demande $demande)
    {
        $utilisateur = auth()->user();
        $fluxHistoriques = $demande->fluxHistoriques()->get();
        $fluxHistorique = $fluxHistoriques->firstWhere('validatedby', $utilisateur->id);

        if (!$fluxHistorique) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un validateur pour cette demande.',
            ], 403);
        }

        if ($fluxHistorique->statut == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà validé cette demande.',
            ], 400);
        }

        if ($fluxHistorique && $fluxHistorique->statut == 3) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà rejeter cette demande.',
            ], 403);
        }

        $indexActuel = $fluxHistoriques->search(fn($flux) => $flux->validatedby == $utilisateur->id);
        $validateurSuivant = $fluxHistoriques->skip($indexActuel + 1)->firstWhere('statut', 0);

        if ($validateurSuivant) {
            $utilisateurSuivant = User::find($validateurSuivant->validatedby);
            if ($utilisateurSuivant) {
                try {
                    Log::info("Envoi d'un email au validateur suivant : {$utilisateurSuivant->email} pour la demande #{$demande->reference}");

                    Mail::send('mail.demande', ['demande' => $demande, 'validateur' => $utilisateurSuivant], function ($message) use ($utilisateurSuivant) {
                        $message->to($utilisateurSuivant->email)
                            ->subject("Nouvelle demande d'habilitation à valider");
                    });

                    Log::info("Email envoyé avec succès au validateur suivant : {$utilisateurSuivant->email}");
                } catch (\Exception $e) {
                    Log::error("Échec de l'envoi de l'email au validateur suivant : {$utilisateurSuivant->email}. Erreur : " . $e->getMessage());
                }
            }
        }
        $fluxHistorique->statut = 1;
        $fluxHistorique->save();

        $tousValides = $fluxHistoriques->every(fn($flux) => $flux->statut == 1);

        if ($tousValides) {
            $demande->statut = 1;
            $approbateurs = User::whereHas('userRole', function ($query) {
                $query->where('role_name', 'APPROBATEUR');
            })->get();
            //ENVOIS DE MAIL A TOUS LES APPROBATEURS 
            foreach ($approbateurs as $approbateur) {
                Mail::send('mail.demande', ['demande' => $demande, 'validateur' => $approbateur], function ($message) use ($approbateur) {
                    $message->to($approbateur->email)
                        ->subject("Nouvelle demande d'habilitation à approuver");
                });
            }
            $demande->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'Validation effectuée avec succès.',
            'canValidate' => true,
        ]);
    }
    public function rejeterDemande(Demande $demande)
    {
        $utilisateur = auth()->user();

        $fluxHistoriques = $demande->fluxHistoriques()->get();
        $fluxHistorique = $fluxHistoriques->firstWhere('validatedby', $utilisateur->id);

        if (!$fluxHistorique) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un validateur pour cette demande.',
                'canValidate' => false,
            ], 403);
        }

        if ($fluxHistorique->statut == 3) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà rejeter cette demande.',
                'canValidate' => false,
            ], 400);
        }
        if ($fluxHistorique->statut == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà valider cette demande. Impossible de la rejeter',
                'canValidate' => false,
            ], 400);
        }

        $fluxHistorique->statut  = 3;
        $demande->statut = 3;
        $fluxHistorique->save();
        $demande->save();

        return response()->json([
            'success' => true,
            'message' => 'La demande a été rejetée avec succès.',
        ]);
    }

    public function approbation(Demande $demande)
    {
        $demandes = Demande::where('statut', 1)->paginate(10);
        return view('approbation.index', [
            'demandes' => $demandes
        ]);
    }

    public function validerApprobation(Demande $demande)
    {
        try {
            $user = auth()->user();
            $fluxHistorique = $demande->fluxHistoriques()->first();

            if (!$fluxHistorique) {
                return response()->json(['error' => 'Aucun historique de flux trouvé pour cette demande.'], 404);
            }
            // Récupérer les approbateurs ayant le rôle "APPROBATEUR"
            $approbateurs = User::whereHas('userRole', function ($query) {
                $query->where('role_name', 'APPROBATEUR');
            })->pluck('id');

            if ($approbateurs->isEmpty()) {
                return response()->json(['error' => 'Aucun approbateur trouvé.'], 404);
            }
            // Mettre à jour les approbateurs dans la table flux_historiques
            $fluxHistorique->update([
                'approbateur1' => $approbateurs[0] ?? $fluxHistorique->approbateur1,
                'approbateur2' => $approbateurs[1] ?? $fluxHistorique->approbateur2,
                'approbateur3' => $approbateurs[2] ?? $fluxHistorique->approbateur3,
                'approbateur4' => $approbateurs[3] ?? $fluxHistorique->approbateur4,
            ]);

            // Créer un tableau avec les approbateurs et leur état de validation
            $approbateursData = [
                'approbateur1' => $fluxHistorique->approbateur1,
                'approbateur2' => $fluxHistorique->approbateur2,
                'approbateur3' => $fluxHistorique->approbateur3,
                'approbateur4' => $fluxHistorique->approbateur4,
            ];

            // Trouver la clé de l'approbateur actuel
            $approbateurKey = collect($approbateursData)->search(fn($value) => $value == $user->id);
            if ($approbateurKey === false) {
                return response()->json(['error' => 'Vous n\'êtes pas autorisé à approuver cette demande.'], 403);
            }
            // Vérifier si l'utilisateur a déjà validé
            if ($fluxHistorique->{$approbateurKey . '_valide'} == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous avez déjà approuver pour cette demande.',
                ], 400);
            }
            // Marquer cet approbateur comme validé
            $fluxHistorique->update([
                $approbateurKey . '_valide' => 1
            ]);

            // Vérifier si tous les approbateurs disponibles ont validé
            $tousValides = collect($approbateursData)
                ->filter() // Supprime les valeurs nulles (approbateurs inexistants)
                ->every(fn($value, $key) => $fluxHistorique->{$key . '_valide'} == 1);

            if ($tousValides) {
                $demande->update(['statut' => 2]);
                return response()->json([
                    'success' => true,
                    'message' => 'La demande a été approuver avec succès.',
                ], 400);
            }
            return response()->json([
                'success' => true,
                'message' => 'Votre approbation a été enregistrée avec succès.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
}

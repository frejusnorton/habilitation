<div class="d-flex align-items-center mb-10">
    <h3 class="text-primary mb-0">
        Récapitulatif de la demande
        <span class="text-muted">#{{ $demande->reference }}</span>
    </h3>

    @if ($demande->statut == 0)
    <span class="badge badge-warning text-dark fw-bold ms-3">En attente de validation</span>
    @elseif ($demande->statut == 1)
    <span class="badge badge-light-info fw-bold ms-3">En attente d'approbation</span>
    @elseif ($demande->statut == 2)
    <span class="badge badge-light-success fw-bold ms-3">Valider</span>
    @elseif ($demande->statut == 3)
    <span class="badge badge-light-danger fw-bold ms-3">Rejeter</span>
    @endif
</div>


<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">
                <img alt="Logo" src="{{ asset('assets/benin.png') }}" class="logo-default h-25px" />
            </th>
            <th class="w-75">
                <span class="fs-4">Fiche de demande d'autorisation de compte utilisateur </span>
            </th>
        </tr>
    </thead>
</table>

<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-6 text-center">
            <th class="w-50 py-3">Responsable Hiérarchique</th>
            <th class="w-50 py-3">Utilisateur</th>
        </tr>
    </thead>
    <tbody class="text-gray-700 border border-light fw-semibold fs-5">
        <tr>
            <td class="p-4">
                <table class="w-100">
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Nom :</td>
                        <td class="text-dark">{{ $demande->user->superieur->nom ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Prénom :</td>
                        <td class="text-dark">{{ $demande->user->superieur->prenom ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Poste :</td>
                        <td class="text-dark">{{ $demande->user->superieur->poste ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Email :</td>
                        <td class="text-dark">{{ $demande->user->superieur->email ?? 'Non renseigné' }}</td>
                    </tr>
                </table>
            </td>

            <td class="p-4">
                <table class="w-100">
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Nom :</td>
                        <td class="text-dark">{{ $demande->user->nom }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Prénom :</td>
                        <td class="text-dark">{{ $demande->user->prenom }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Poste :</td>
                        <td class="text-dark">{{ $demande->user->poste }}</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Email :</td>
                        <td class="text-dark">{{ $demande->user->email }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Informations sur la Filliale -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="py-3">Informations sur la Filiale</th>
        </tr>
    </thead>

    <tbody class="text-gray-700 border border-light fw-semibold fs-5">
        <tr>
            <td class="p-4">
                <table class="w-100">
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Code - Nom de Filiale :</td>
                        <td class="text-dark">ORABANK BENIN</td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Service - Département - Direction :</td>
                        <td class="text-dark">
                            {{ $demande->user->departement->libelle ?? 'Non renseigné' }} /
                            {{ $demande->user->service->libelle ?? 'Non renseigné' }} /
                            {{ $demande->user->direction->libelle ?? 'Non renseigné' }}
                        </td>
                    </tr>
                    <tr class="mb-3">
                        <td class="pe-3 fw-bold text-primary">Site (Agence - Holding) :</td>
                        <td class="text-dark">{{ $demande->user->agence->lib ?? 'Non renseigné' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Type de Demande -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="py-3">Type de demande</th>
        </tr>
    </thead>
    <tbody class="text-gray-700 fw-semibold fs-5">
        <tr>
            <td class="border border-light  p-4 text-dark">
                {{ $demande->type_demande }}
            </td>
        </tr>
    </tbody>
</table>

<!-- Applications et Rôles -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="py-3">Applications</th>
        </tr>
    </thead>
</table>

<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="w-25 py-3">Applications - Bases de données - Systèmes</th>
            <th class="w-25 py-3">Rôles</th>
            <th class="w-25 py-3">Champs et valeurs</th>
        </tr>
    </thead>

    <tbody class="text-gray-700 fw-semibold fs-6">
        @foreach ($demande->application as $application)
        <tr>
            <td class="py-3 px-4">{{ $application->application->libelle }}</td>
            <td class="py-3 px-4">{{ $application->profil->libelle }}</td>
            <td class="py-3 px-4">
                @php
                $fields = $demande->field->filter(function ($field) use ($application) {
                return $field->application_id == $application->id;
                });
                @endphp
                @if ($fields->isNotEmpty())
                <ul class="list-unstyled m-0">
                    @foreach ($fields as $field)
                    <li class="mb-2">
                        <strong>Champ ID :</strong> {{ $field->champs_id }} <br>
                        <strong>Valeur :</strong> {{ $field->value }}
                    </li>
                    @endforeach
                </ul>
                @else
                <span class="text-muted">Non renseigné</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


{{-- MES VALIDATEURS --}}
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="w-25 py-3">
                <span>Validateurs</span>
            </th>
        </tr>
    </thead>
</table>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead class="text-start text-muted fw-bold fs-6 text-uppercase gs-0">
        <tr>
            <th class="min-w-125px py-3">Nom</th>
            <th class="min-w-125px py-3">Prénom</th>
            <th class="min-w-125px py-3">Identifiant</th>
            <th class="min-w-125px py-3">E-mail</th>
            <th class="min-w-125px text-center py-3">Poste</th>
            <th class="text-end min-w-100px py-3">Statut</th>
        </tr>
    </thead>
    <tbody class="text-gray-700 fw-semibold">
        @forelse ($demande->fluxHistoriques as $index => $flux)
        <tr>
            <td class="py-3 px-4">
                <span class="badge badge-light-primary fw-bold me-2">
                    {{ $index == 0 ? '1' : ($index == 1 ? '2' : ($index == 2 ? '3' : 'Autre')) }}
                </span>
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->nom : 'Non défini' }}
                </div>
            </td>
            <td class="py-3 px-4">
                <div class="text-gray-800 text-hover-primary mb-1">
                    {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->prenom : 'Non défini' }}
                </div>
            </td>
            <td class="py-3 px-4">
                {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->username : 'Non défini' }}
            </td>
            <td class="py-3 px-4">
                {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->email : 'Non défini' }}
            </td>
            <td class="text-center py-3 px-4">
                {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->poste : 'Non défini' }}
            </td>
            <td class="text-end py-3 px-4">
                @if ($flux->statut == 1)
                <span class="badge badge-light-success fw-bold">Valider</span>
                @elseif ($flux->statut == 3)
                <span class="badge badge-light-danger fw-bold">Rejeter</span>
                @elseif ($flux->statut == 0)
                <span class="badge badge-warning text-dark fw-bold ">En attente de validation</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4">Aucun validateur disponible</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- LES APPROBATEURS --}}
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="w-25 py-3">
                <span>Approbateurs</span>
            </th>
        </tr>
    </thead>
</table>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead class="text-start text-muted fw-bold fs-6 text-uppercase gs-0">
        <tr>
            <th class="min-w-125px p-3">Nom</th>
            <th class="min-w-125px p-3">Prénom</th>
            <th class="min-w-125px p-3">Identifiant</th>
            <th class="min-w-125px p-3">E-mail</th>
            <th class="min-w-125px text-center p-3">Poste</th>
            <th class="min-w-125px text-center p-3">Statut</th>
            @if (auth()->user()->userRole->role_name == "APPROBATEUR" || auth()->user()->userRole->role_name ==
            "ALLTEST")
            <th class="text-end min-w-100px p-3">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ($approbateurs as $approbateur)
        <tr>
            <td class="p-3">
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $approbateur->nom ?? 'Non défini' }}
                </div>
            </td>
            <td class="p-3">
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $approbateur->prenom ?? 'Non défini' }}
                </div>
            </td>
            <td class="p-3">
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $approbateur->username ?? 'Non défini' }}
                </div>
            </td>
            <td class="p-3">
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $approbateur->email ?? 'Non défini' }}
                </div>
            </td>
            <td class="p-3 text-center">
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $approbateur->poste ?? 'Non défini' }}
                </div>
            </td>
            <td class="p-3 text-end">
                @if (isset($approbationStatuses[$approbateur->id]) && $approbationStatuses[$approbateur->id])
                <span class="badge badge-light-success fw-bold">Valider</span>
                @else
                <span class="badge badge-light-info fw-bold">En attente d'approbation</span>
                @endif
            </td>


            <td class="text-end">
                <div class="dropdown">
                    @if (Auth::check())
                    @php
                    $user = auth()->user();
                    $isApprobateur = $user->userRole->role_name === "APPROBATEUR";
                    $isCurrentUser = $user->id == $approbateur->id;
                    @endphp

                    <button class="btn btn-light btn-xs" type="button" id="actionDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" @if (!$isCurrentUser) disabled @endif>
                        Actions
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-id="{{ $demande->id }}" id="approuver_demande">
                                <i class="bi bi-check-circle-fill fs-1x mx-1 text-success"></i> Approuver
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="bi bi-x-circle-fill fs-1x mx-1 text-danger"></i> Rejeter
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>


            </td>


        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center p-3">Aucun approbateur disponible</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- COMMENTAIRES --}}
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-5 text-center">
            <th class="w-25 py-3">
                <span>Commentaires</span>
            </th>
        </tr>
    </thead>
</table>
<div class="mt-5">
    @php
    $commentairesUniques = collect($demande->fluxHistoriques)
    ->pluck('commentaires')
    ->flatten()
    ->unique();
    @endphp

    @foreach ($commentairesUniques as $commentaire)
    <p>{{ $commentaire }}</p>
    @endforeach
</div>

<div class="mb-10">
    <div>
        <h3 class="text-primary mb-4">
            Récapitulatif de la demande
            <span class="text-muted">#{{ $demande->reference }}</span>
            @if ($validationStatut == 0)
            <span class="badge badge-warning text-dark fw-bold ms-3">En attente de validation</span>
            @elseif ($validationStatut == 1)
            <span class="badge badge-light-info fw-bold">En attente d'approbation</span>
            @elseif ($validationStatut == 2)
            <span class="badge badge-light-success fw-bold">Vous avez validé cette demande</span>
            @elseif ($validationStatut == 3)
            <span class="badge badge-light-danger fw-bold">Vous avez rejeté cette demande</span>
            @else
            <span class="badge badge-light-secondary fw-bold">Statut inconnu ou non disponible</span>
            @endif
    </div>
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
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">Responsable Hiérarchique</th>
            <th class="w-25">Utilisateur</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 border border-light fw-semibold">
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td><strong>Nom:</strong></td>
                        <td>{{ $demande->hierachie->nom ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Prénom:</strong></td>
                        <td>{{ $demande->hierachie->prenom ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Poste:</strong></td>
                        <td>{{ $demande->hierachie->poste ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $demande->hierachie->email ?? 'Non renseigné' }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="w-100">
                    <tr>
                        <td><strong>Nom:</strong></td>
                        <td>{{ $demande->user->nom }}</td>
                    </tr>
                    <tr>
                        <td><strong>Prénom:</strong></td>
                        <td>{{ $demande->user->prenom }}</td>
                    </tr>
                    <tr>
                        <td><strong>Poste:</strong></td>
                        <td>{{ $demande->user->poste }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $demande->user->email }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Informations sur la Filliale -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">Informations sur la Filliale</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 border border-lightfw-semibold">
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td><strong>Code - Nom de Filliale :</strong></td>
                        <td>ORABANK BENIN</td>
                    </tr>
                    <tr>
                        <td><strong>Service - Département - Direction:</strong></td>
                        <td>{{ $demande->diection->nom ?? 'Non renseigné' }} /
                            {{ $demande->departement->nom ?? 'Non renseigné' }} /
                            {{ $demande->service->nom ?? 'Non renseigné' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Site (Agence - Holding):</strong></td>
                        <td>{{ $demande->departement->nom ?? 'Non renseigné' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- Type de Demande -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-100">Type de demande</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        <tr>
            <td class="border border-light">{{ $demande->type_demande }}</td>
        </tr>
    </tbody>
</table>

<!-- Applications et Rôles -->
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">Applications</th>
            <th class="w-25">Champs et valeurs</th>
            <th class="w-25">Rôles</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 border border-light fw-semibold divide-y divide-gray-200">
        @foreach ($demande->application as $application)
        <tr class="bg-gray-50 hover:bg-gray-100">
            <td class="py-3 px-4">{{ $application->application->libelle }}</td>
            <td class="py-3 px-4">
                {{-- {{ $demande->field }} --}}
            </td>
            <td class="py-3 px-4">{{ $application->profil->libelle }}</td>
        </tr>
        @endforeach
    </tbody>

</table>


{{-- LES VALIDATEURS --}}
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">
                <span>Les validateurs</span>
            </th>
        </tr>
    </thead>
</table>
<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bold fs-8 text-uppercase gs-0">
            <th class="min-w-125px ">Nom</th>
            <th class="min-w-125px">Prenom</th>
            <th class="min-w-125px">Identifiant</th>
            <th class="min-w-125px text-center">Poste</th>
            <th class="text-end min-w-100px">Statut</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @forelse ($demande->fluxHistoriques as $index => $flux)
        <tr>
            <td>
                <div class="text-gray-800 text-hover-primary mb-1 d-inline">
                    {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->nom : 'Non défini' }}
                </div>
                <span class="badge badge-light-primary fw-bold me-2">
                    {{ $index == 0 ? 'Validateur 1' : ($index == 1 ? 'Validateur 2' : ($index == 2 ? 'Validateur 3' :
                    'Autre')) }}
                </span>
            </td>
            <td>
                <div class="text-gray-800 text-hover-primary mb-1">
                    {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->prenom : 'Non défini' }}
                </div>
            </td>
            <td>
                {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->username : 'Non défini' }}
            </td>
            <td class="text-center">
                {{ $flux->validatedby ? \App\Models\User::find($flux->validatedby)->poste : 'Non défini' }}
            </td>
            <td class="text-end">
                @if ($flux->statut == 0)
                <span class="badge badge-warning text-dark fw-bold ms-3">En attente de validation</span>
                @elseif ($flux->statut == 1)
                <span class="badge badge-light-success fw-bold">Validé</span>
                @elseif ($flux->statut == 2)
                <span class="badge badge-light-success fw-bold">Validé</span>
                @elseif ($flux->statut == 3)
                <span class="badge badge-light-danger fw-bold">Rejeté</span>
                @endif
            </td>

            <td class="text-end">
                @if (Auth::check() && Auth::id() == $flux->validatedby)
                <a href="#" class="btn btn-light  btn-sm show menu-dropdown" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Actions
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"></path>
                        </svg>
                    </span>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" id="valider_demande" class="menu-link px-3 menu_edit_btn text-primary"
                            data-url="{{ route('validation.demande', ['demande' => $demande->id]) }}"
                            data-id="{{ $demande->id }}">
                            <i class="bi bi-pencil-square fs-1x mx-1 text-primary"></i> Valider
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                 
                    <div class="menu-item px-3">
                        <a href="javascript:;" id="rejeter_demande"
                            data-url="{{ route('validation.demande', ['demande' => $demande->id]) }}"
                            data-id="{{ $demande->id }}" class="menu-link px-3 text-danger"
                            data-kt-users-table-filter="delete_row">
                            <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Rejeter
                        </a>
                    </div>
             
                    <!--end::Menu item-->
                </div>
                @else
                <!-- Bouton désactivé pour les autres utilisateurs -->
                <button class="btn btn-light btn-sm" disabled>Actions
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"></path>
                        </svg>
                    </span>
                </button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Aucun validateur disponible</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- LES APPROBATEURS --}}
<table class="table-bordered w-100 mb-6">
    <thead class="table-light">
        <tr class="text-muted fw-bold fs-7 text-center">
            <th class="w-25">
                <span>Approbateurs</span>
            </th>
        </tr>
    </thead>
</table>

<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bold fs-8 text-uppercase gs-0">
            <th class="min-w-125px p-3">Nom</th>
            <th class="min-w-125px p-3">Prénom</th>
            <th class="min-w-125px p-3">Identifiant</th>
            <th class="min-w-125px p-3">E-mail</th>
            <th class="min-w-125px text-center p-3">Poste</th>
            {{-- <th class="text-end min-w-100px">Statut</th> --}}
            @if (auth()->user()->userRole->role_name == "APPROBATEUR" || auth()->user()->userRole->role_name ==
            "ALLTEST")
            <th class="text-end min-w-100px">Action</th>
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
            <td class="text-end" id="statut_{{ $approbateur->id }}">
                <span class="badge badge-light-info fw-bold">En attente d'approbation</span>
            </td>

            @if (auth()->user()->userRole->role_name == "APPROBATEUR" || auth()->user()->userRole->role_name ==
            "ALLTEST")
            <td class="text-end">
                <a href="#" class="btn btn-light btn-xs show menu-dropdown" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Actions
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"></path>
                        </svg>
                    </span>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a data-id="{{$demande->id}}" id="approuver_demande" href="#"
                            class="menu-link px-3 menu_edit_btn">
                            <i class="bi bi-check-lg fs-1x mx-1 text-success"></i> Approuver
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="bi bi-x-lg fs-1x mx-1"></i>Rejeter
                        </a>
                    </div>
                </div>
            </td>
            @endif


        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center p-3">Aucun validateur disponible</td>
        </tr>
        @endforelse
    </tbody>
</table> 




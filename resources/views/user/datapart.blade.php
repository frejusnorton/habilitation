{{-- @dump($users) --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                <th class="min-w-125px">Identifiant</th>
                <th class="min-w-125px">Nom & prenoms</th>
                <th class="min-w-125px">Role</th>
                <th class="min-w-125px">Poste</th>
                <th class="min-w-125px">Agence</th>
                <th class="min-w-125px">Direction</th>
                <th class="min-w-125px">Service</th>
                <th class="min-w-125px">Département</th>
                <th class="min-w-125px">Supérieur hiérachique</th>
                <th class="min-w-125px">Statut</th>
                <th class="min-w-125px">Type de connexion</th>
                <th class="min-w-125px">Création</th>
                <th class="min-w-125px">Validateur 1</th>
                <th class="min-w-125px">Validateur 2</th>
                <th class="min-w-125px">Validateur 3</th>
                <th class="text-end min-w-175px">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($users as $employe)
            <tr>
                <td class="d-flex align-items-center">
                    <div class="d-flex flex-column ">
                        <a href="{{ route('detail_user', ['user' => $employe->id]) }}"
                            class="text-gray-800 text-hover-primary mb-1">{{ $employe->username ? $employe->username :
                            '' }}</a>
                        <span>{{ $employe->email ? $employe->email : '' }}</span>
                    </div>
                </td>

                <td>{{ $employe ? $employe->nom . ' ' . $employe->prenom : '' }} </td>

                <td class="">
                    <div class="badge badge-primary fw-bold">
                        {{ $employe->userRole ? $employe->userRole->role_name : '' }}</div>
                </td>
                <td>
                    {{ $employe->poste ?? 'Poste non renseigné' }}
                </td>

                <td>
                    {{ $employe->agence->lib ?? 'Agence non renseigné' }}
                </td>
                <td>
                    {{ $employe->direction->libelle ?? 'Direction non renseigné' }}
                </td>
                <td>
                    {{ $employe->service->libelle ?? 'Service non renseigné' }}
                </td>
                <td>
                    {{ $employe->departement->libelle ?? 'Departement non renseigné' }}
                </td>

                <td>
                    @php
                    $superieur = \App\Models\User::find($employe->superieur_id);
                    @endphp
                    {{ $superieur ? $superieur->nom : '' }} {{ $superieur ? $superieur->prenom : 'Supérieur non
                    renseigné' }}
                </td>

                <td class="">
                    {!! \App\Helpers\Helper::getStatutHtml($employe->statut, $employe->statut_delete) !!}
                </td>
                <td class="">
                    {{ $employe->auth_type ?? 'Non renseigné' }}
                </td>
                <td class="">

                    {!! $employe->created_at != null
                    ? 'cree le <br>' . Carbon\carbon::parse($employe->created_at)->format('d-m-Y')
                    : '' !!}
                    <br />
                    {!! $employe->initiateur ? 'par ' . $employe->initiateur->username : '' !!}
                </td>
                <td>
                    {{ $employe->validateur1->username ?? "Non renseigné" }}
                </td>
                <td>
                    {{ $employe->validateur2->username ?? "Non renseigné" }}
                </td>
                <td>
                    {{ $employe->validateur3->username ?? "Non renseigné" }}
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!--begin::Menu item-->
                            <div class="menu-item ">
                                <a href="javascript:void(0)"
                                    data-url="{{ route('app_user_edit', ['user' => $employe->id]) }}" id="editUser"
                                    type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user"
                                    class="menu-link px-3 text-info" data-id="{{ $employe->id }}"
                                    data-username="{{ $employe->username }}" data-nom="{{ $employe->nom }}"
                                    data-prenom="{{ $employe->prenom }}" data-email="{{ $employe->email }}"
                                    data-poste="{{ $employe->poste }}" data-agence="{{ $employe->agence_id }}"
                                    data-role="{{ $employe->role }}" data-service="{{ $employe->service_id }}"
                                    data-superieur="{{ $employe->superieur_id }}" data-type="{{ $employe->auth_type}}"
                                    data-departement="{{ $employe->departement_id }}"
                                    data-direction="{{ $employe->direction_id }}"
                                    data-validateur1="{{ $employe->validateur_1 }}"
                                    data-validateur2="{{ $employe->validateur_2 }}"
                                    data-validateur2="{{ $employe->validateur_3 }}">
                                    <i class="bi bi-pencil-square text-info ml-1"></i> <span
                                        class="mx-1">Modifier</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            @if ($employe->statut_delete == 0)
                            <div class="menu-item">
                                <a href="javascript:void(0)" class="menu-link px-3 action" data-action="INIT_DELETE"
                                    data-url="{{ route('init_delete', ['user' => $employe->id]) }}">
                                    <i class="bi bi-trash text-danger"></i> <span class="mx-1 text-danger">Initier
                                        Suppression</span>
                                </a>
                            </div>
                            @endif

                            @if ($employe->statut_delete == -1)
                            <div class="menu-item ">
                                <a href="javascript:void(0)" class="menu-link action" data-action="DELETE"
                                    data-url="{{ route('delete', ['user' => $employe->id]) }}">
                                    <i class="bi bi-check text-success"></i> <span class="mx-1 text-success">Valider
                                        Suppression</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="javascript:void(0)" class="menu-link px-3 action" data-action="CANCEL_DELETE"
                                    data-url="{{ route('delete', ['user' => $employe->id]) }}">
                                    <i class="bi bi-x text-danger"></i> <span class="mx-1 text-danger">Rejeter
                                        Suppression</span>
                                </a>
                            </div>
                            @endif

                            @if ($employe->statut == 1)
                            <div class="menu-item">
                                <a href="javascript:void(0)" class="menu-link px-3 action" data-action="USER_DISABLED"
                                    data-url="{{ route('activateOrDisableUser', ['user' => $employe->id]) }}">
                                    <i class="bi bi-x text-danger"></i> <span class="mx-1 text-danger">Désactiver</span>
                                </a>
                            </div>
                            @endif
                            @if ($employe->statut == 0)
                            <div class="menu-item">
                                <a href="javascript:void(0)" class="menu-link px-3 action" data-action="USER_ACTIVATED"
                                    data-url="{{ route('activateOrDisableUser', ['user' => $employe->id]) }}">
                                    <i class="bi bi-check text-success"></i> <span
                                        class="mx-1 text-success">Activer</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Aucune donnée</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links('pagination.custom') }}

</div>
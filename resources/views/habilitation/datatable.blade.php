<!--begin::Table-->

<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px ">Référence</th>
                <th class="min-w-125px">Date de la demande</th>
                <th class="min-w-125px">Utilisateur </th>
                <th class="min-w-125px text-center">Statut</th>
                <th class="text-end min-w-100px">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($demandes as $demande)
            <tr>
                <td>
                    <div class="text-gray-800 text-hover-primary mb-1">{{ $demande->reference }}</div>
                </td>
                <td>
                    <div class="text-gray-800 text-hover-primary mb-1">
                        {{ \Carbon\Carbon::parse($demande->created_at)->format('Y-m-d H:i:s') }}</div>
                </td>
                <td>
                    <div class="text-gray-800 text-hover-primary mb-1">{{ $demande->user->username }}</div>
                </td>
                <td class="text-center">
                    @if ($demande->statut == 0)
                    <span class="badge badge-warning text-dark fw-bold ms-3">En attente de validation</span>
                    @elseif ($demande->statut == 1)
                    <span class="badge badge-light-info fw-bold">En attente d'approbation</span>
                    @elseif ($demande->statut == 2)
                    <span class="badge badge-light-success fw-bold">Valider</span>
                    @elseif ($demande->statut == 3)
                    <span class="badge badge-light-danger fw-bold">Rejeter</span>
                    @endif
                </td>

                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="menu-item px-3">
                                <a href="{{ route('habilitation.details', ['demande' => $demande->id]) }}"
                                    class="menu-link px-3 menu_edit_btn text-primary">
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-primary"></i> Details
                                </a>
                            </div>
                            <!--end::Menu item-->
                            @if ($demande->statut == 3)
                            <div class="menu-item px-1">
                                <a href="{{ route('habilitation.details', ['demande' => $demande->id]) }}"
                                    class="menu-link px-3  text-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="bi bi-eye-slash fs-1x mx-1 text-primary"></i>Voir la raison
                                </a>
                            </div>
                            @endif
                            <!--begin::Menu item-->
                            @if ($user->userRole->role_name === 'ALLTEST')
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="delete_demande" class="menu-link px-3 text-danger"
                                    data-kt-users-table-filter="delete_row" data-id="{{$demande->id}}">
                                    <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Supprimer
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- <a href="#" class="btn btn-light  btn-sm show menu-dropdown" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('habilitation.details', ['demande' => $demande->id]) }}"
                                class="menu-link px-3 menu_edit_btn text-primary">
                                <i class="bi bi-pencil-square fs-1x mx-1 text-primary"></i> Details
                            </a>
                        </div>
                        <!--end::Menu item-->
                        @if ($demande->statut == 3)
                        <div class="menu-item px-1">
                            <a href="{{ route('habilitation.details', ['demande' => $demande->id]) }}"
                                class="menu-link px-3  text-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="bi bi-eye-slash fs-1x mx-1 text-primary"></i>Voir la raison
                            </a>
                        </div>
                        @endif
                        <!--begin::Menu item-->
                        @if ($user->userRole->role_name === 'ALLTEST')
                        <div class="menu-item px-3">
                            <a href="javascript:;" id="delete_demande" class="menu-link px-3 text-danger"
                                data-kt-users-table-filter="delete_row" data-id="{{$demande->id}}">
                                <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Supprimer
                            </a>
                        </div>
                        @endif
                    </div> --}}
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="6" class="text-center">Aucune donnée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $demandes->links('pagination.custom') }}
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Raison de refus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Contenu
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
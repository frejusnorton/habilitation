<!--begin::Table-->
@if ($demandes->isEmpty())
<div class="d-flex justify-content-center align-items-center">
    <p class="text-center text-gray-600">Aucune demande en attente.</p>
</div>
@else
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
                    {!! $demande->statut == 0
                    ? ' <span class="badge badge-warning text-dark fw-bold ms-3">En attente de validation</span>'
                    : ($demande->statut == 1
                    ? '<div class="badge badge-light-info fw-bold">En attente d\'approbation</div>'
                    : ($demande->statut == 2
                    ? '<div class="badge badge-light-success fw-bold">Validé</div>'
                    : ($demande->statut == 3
                    ? '<div class="badge badge-light-danger fw-bold">Rejeté</div>'
                    : '<div class="badge badge-light-secondary fw-bold">Statut inconnu</div>'
                    )
                    )
                    )
                    !!}
                </td>
                <td class="text-end">
                    <a href="#" class="btn btn-light  btn-sm show menu-dropdown" data-kt-menu-trigger="click"
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
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('hbl_validation.details', ['demande' => $demande->id]) }}"
                                class="menu-link px-3 menu_edit_btn text-primary">
                                <i class="bi bi-pencil-square fs-1x mx-1 text-primary"></i> Details
                            </a>
                        </div>
                        <!--end::Menu item-->
                        {{-- @if (auth()->user()->userRole->role_name == 'USERS')
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="javascript:;" id="deleteBtn" class="menu-link px-3 text-danger"
                                data-kt-users-table-filter="delete_row">
                                <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Supprimer
                            </a>
                        </div>
                        <!--end::Menu item-->
                        @endif --}}


                    </div>
                    <!--end::Menu-->
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="6" class="text-center">Aucune donnée</td>
            </tr>
            @endforelse



        </tbody>
    </table>
    {{-- {{ $demandes->links('pagination.custom') }} --}}
</div>
@endif
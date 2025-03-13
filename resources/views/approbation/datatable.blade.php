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
                            <span class="badge badge-light-warning fw-bold">En attente de validation</span>
                        @elseif ($demande->statut == 1)
                            <span class="badge badge-light-info fw-bold">En attente d'approbation</span>
                        @elseif ($demande->statut == 2)
                            <span class="badge badge-light-success fw-bold">Valider</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-light  btn-sm show menu-dropdown" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">Actions
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
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
                                <a href="{{ route('habilitation.details', ['demande' => $demande->id]) }}"
                                    class="menu-link px-3 menu_edit_btn text-primary">
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-primary"></i> Details
                                </a>
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
    {{ $demandes->links('pagination.custom') }}
</div>

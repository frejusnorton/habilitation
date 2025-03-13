<!--begin::Table-->
{{-- @dump($apkRoles) --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            
                <th class="min-w-125px">Libelle</th>
                <th class="min-w-125px text-center">Statut</th>
                <th class="min-w-100px text-end">Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-semibold">
            @forelse ($apkRoles as $apkRole)
                <tr>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $apkRole->libelle }}</div>
                    </td>
                    <td class="text-center">
                        {!! $apkRole->statut == 0
                            ? '<div class="badge badge-light-danger fw-bold">Inactif</div>'
                            : '<div class="badge badge-light-success fw-bold">Active</div>' !!}
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
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn text-warning"
                                    data-bs-toggle="modal" id="editRole" data-id="{{ $apkRole->id }}"
                                    data-url="{{ route('application_role.update', $apkRole->id) }}"
                                    data-statut="{{ $apkRole->statut }}" data-bs-target="#kt_modal_edit_role"
                                    data-code={{ $apkRole->code }} data-libelle={{ $apkRole->libelle }}>
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-warning"></i> Modifier
                                </a>
                            </div>
                            @if ($apkRole->statut == 0)
                                <div class="menu-item px-3">
                                    <a href="javascript:;" id="activateBtn" class="menu-link px-3 text-success "
                                        data-url="{{ route('application_role.activate', $apkRole->id) }}">
                                        <i class="bi bi-trash fs-1x mx-1 text-success"></i> Activer
                                    </a>
                                </div>
                            @else
                                <div class="menu-item px-3">
                                    <a href="javascript:;" id="activateBtn"
                                        class="menu-link px-3 text-danger activateBtn"
                                        data-url="{{ route('application_role.activate', $apkRole->id) }}">
                                        <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Désactiver
                                    </a>
                                </div>
                            @endif

                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn text-danger" id="deleteRole"
                                    data-id="{{ $apkRole->id }}"
                                    data-url="{{ route('application_role.delete', $apkRole->id) }}">
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-danger"></i> Supprimer
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
    {{ $apkRoles->links('pagination.custom') }}
</div>

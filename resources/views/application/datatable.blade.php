<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Applications</th>
                <th class="min-w-125px text-center">Statut</th>
                <th class="min-w-100px text-end">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($applications as $application)
            <tr>
                <td>
                    <div class="text-gray-800 text-hover-primary mb-1">{{ $application->libelle }}</div>
                </td>
                <td class="text-center">
                    {!! $application->statut == 0
                    ? '<div class="badge badge-light-danger fw-bold">Inactif</div>'
                    : '<div class="badge badge-light-success fw-bold">Active</div>' !!}
                </td>

                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn text-warning"
                                    data-bs-toggle="modal" id="editBtn" data-id="{{ $application->id }}"
                                    data-url="{{ route('application.update', ['application' => $application->id]) }}"
                                    data-bs-target="#kt_modal_edit_apk" data-libelle={{ $application->libelle }}
                                    >
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-warning"></i> Modifier
                                </a>
                            </div>
    
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn -bottom-3 text-primary "
                                    data-bs-toggle="modal" id="role_menu" data-id="{{ $application->id }}"
                                    data-url="{{ route('application.update',['application' => $application->id]) }}"
                                    data-bs-target="#kt_modal_add_menu_role" data-libelle={{ $application->libelle }}
                                    >
                                    <i class="fas fa-key fs-1x mx-1 text-primary"></i> Profils
                                </a>
                            </div>
    
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn -bottom-3 text-primary "
                                    data-bs-toggle="modal" id="champ_menu" data-id="{{ $application->id }}"
                                    data-url="{{ route('application_champ.create') }}" data-bs-target="#kt_modal_champ">
                                    <i class="fas fa-key fs-1x mx-1 text-primary"></i> Configurer champs
                                </a>
                            </div>
    
                            @if ($application->statut == 0)
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="activateBtn" class="menu-link px-3 text-success"
                                    data-url="{{ route('application.activate', $application->id) }}">
                                    <i class="bi bi-trash fs-1x mx-1 text-success"></i> Activer
                                </a>
                            </div>
                            <!--end::Menu item-->
                            @else
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="activateBtn" class="menu-link px-3 text-danger"
                                    data-url="{{ route('application.activate', $application->id) }}">
                                    <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Désactiver
                                </a>
                            </div>
                            <!--end::Menu item-->
                            @endif
                            <!--end::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn text-danger" id="deleteRole"
                                    data-id="{{ $application->id }}"
                                    data-url="{{ route('application.delete', $application->id) }}">
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-danger"></i> Supprimer
                                </a>
                            </div>
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
    {{ $applications->links('pagination.custom') }}
</div>
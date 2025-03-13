<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                <th class="min-w-125px">Titre</th>
                <th class="min-w-125px">Nom de la route </th>
                <th class="min-w-125px text-center">Icone</th>
                <th class="min-w-125px text-center">Statut</th>
                <th class="min-w-125px text-center">Sous menu</th>
                <th class="text-end min-w-100px">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($menus as $menu)
                <tr>
                    <td class="d-flex align-items-center">
                        <div class="d-flex flex-column ">
                            <a href="view.html"
                                class="text-gray-800 text-hover-primary mb-1">{{ $menu->titre ? $menu->titre : '' }}</a>
                            <span>{{ $menu->titresecondaire ? $menu->titresecondaire : '' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="badge badge-light fw-bold">{{ $menu->routename ? $menu->routename : '#' }}</div>
                    </td>
                    <td class="text-center">
                        <div class="badge badge-light fw-bold">  {!! $menu->icone ? $menu->icone : '' !!}</div>
                    </td>
                    <td class="text-center">
                        {!! $menu->statut == 0
                            ? '<div class="badge badge-light-danger fw-bold">Non active</div>'
                            : '<div class="badge badge-light-success fw-bold">Active</div>' !!}
                    </td>
                    <td class="text-center">
                        {!! $menu->issubmenu == true
                            ? '<div class="badge badge-light-primary fw-bold">Sous menu</div>'
                            : '<div class="badge badge-light-primary fw-bold">Menu</div>' !!}
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
                                <a href="javascript:;" class="menu-link px-3 menu_edit_btn text-warning"
                                    data-bs-toggle="modal" id="editBtn" data-id="{{ $menu->id }}"
                                    data-titre="{{ $menu->titre }}" data-titresecondaire="{{ $menu->titresecondaire }}"
                                    data-routename="{{ $menu->routename }}" data-icone="{{ $menu->icone }}"
                                    data-issubmenu="{{ $menu->issubmenu }}" data-parent="{{ $menu->parent }}"
                                    data-hassubmenu="{{ $menu->hassubmenu }}" data-position="{{ $menu->position }}"
                                    data-statut="{{ $menu->statut }}" data-url="{{ route('menu.update', $menu->id) }}"
                                    data-bs-target="#kt_modal_add_menu">
                                    <i class="bi bi-pencil-square fs-1x mx-1 text-warning"></i> Modifier
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="deleteBtn" class="menu-link px-3 text-danger"
                                    data-url="{{ route('menu.delete', $menu->id) }}"
                                    data-kt-users-table-filter="delete_row">
                                    <i class="bi bi-trash fs-1x mx-1 text-danger"></i> Supprimer
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="permissionBtn" data-bs-toggle="modal"
                                    data-bs-target="#permission" class="menu-link px-3 text-info"
                                    data-url="{{ route('app_acl_index', $menu->id) }}">
                                    <i class="bi bi-shield-lock mx-1 text-info"></i> Permissions
                                </a>
                            </div>
                            <!--end::Menu item-->
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

    {{ $menus->links('pagination.custom') }}
</div>

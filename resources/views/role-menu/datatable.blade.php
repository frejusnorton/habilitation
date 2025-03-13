<!--begin::Table-->
{{-- @dump($rolemenus) --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                <th class="min-w-125px">Role</th>
                <th class="min-w-125px">Menu </th>
                <th class="text-end min-w-100px">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ($rolemenus as $rolemenu)
                <tr>
                    <td class="d-flex align-items-center">
                        <div class="d-flex flex-column ">
                            <a href="view.html"
                                class="text-gray-800 text-hover-primary mb-1">{{ $rolemenu->role->role_name ? $rolemenu->role->role_name : '' }}</a>
                        </div>
                    </td>
                    <td>
                        <div class="badge badge-light fw-bold">{{ $rolemenu->menu->titre ? $rolemenu->menu->titre : '' }}</div>
                    </td>

                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" class="menu-link px-3" data-bs-toggle="modal" id="editBtn"
                                data-menu="{{ $rolemenu->menu_id }}" data-role="{{ $rolemenu->role_id }}"
                                data-url="{{ route('app_role_menu_update', $rolemenu->id) }}"
                                data-bs-target="#kt_modal_update_role_menu">
                                <i class="bi bi-pencil-square fs-1x mx-1 text-info"></i> Modifier
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:;" id="deleteBtn" class="menu-link px-3"
                                data-url="{{ route('app_role_menu_delete', $rolemenu->id) }}"  data-kt-users-table-filter="delete_row">
                                <i class="bi bi-trash3 fs-1x mx-1 text-danger"></i> Supprimer
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                </tr>

            @empty
            @endforelse
        </tbody>
    </table>
    <!--end::Table-->
    {{ $rolemenus->links('pagination.custom') }}
</div>
{{-- <div class="" style="display: none">
    <form action="" method="POST" id="formId">
        @csrf
        <button id="" type="submit">submit</button>
    </form>
</div> --}}


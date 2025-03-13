<div class="modal fade" id="kt_modal_add_role_menu" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Attribution d'un menu</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_update_role_form" class="form" action="{{ route('app_role_menu_new') }}" method="POST">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                        data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->


                        <div class="">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-semibold form-label mb-5">Role</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select name="role1" id="role1" data-control="select2" data-placeholder="Selectionner le parent" data-hide-search="true" class="form-select form-select-solid">
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-semibold form-label mb-5">Menu</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select name="menu1" id="menu1" data-control="select2" data-placeholder="Selectionner le parent" data-hide-search="true" class="form-select form-select-solid">
                                            @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->titre }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!--end::Permissions-->
            </div>
            <!--end::Scroll-->

            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" id="cancelModal1" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">
                    Annuler
                </button>

                <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                    <span class="indicator-label">
                        Enregistrer
                    </span>
                </button>
            </div><br><br>
            <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>

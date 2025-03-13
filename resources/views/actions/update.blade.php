<div class="modal fade" id="kt_modal_update_action" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Modification d'une action</h2>
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
                <form id="editForm" class="form" action="" method="POST">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                        data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Titre</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="Entrer le titre"
                                        name="libelle1" id="libelle1" value="" type="text" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Identifiant</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid"
                                        placeholder="Entrer l'identifiant" name="identifiant1" id="identifiant1"
                                        value=""  type="text"/>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <div class="" id="blocParent" style="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-semibold form-label mb-5">Menu</label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select name="menu1" id="menu1" data-placeholder="Selectionner le menu" data-hide-search="true" class="form-select form-select-solid">
                                            @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->titre }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-7">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold">Voulez-vous activer l'action ?</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            {{-- <div class="fs-7 fw-semibold text-muted">Permet de savoir si le menu a des sous-menu</div> --}}
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input" name="statut1" type="checkbox" value="1" id="statut1" />
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--begin::Wrapper-->
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

<div class="modal fade" id="kt_modal_add_menu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold " id="modalTitle">Ajout d'un menu</h2>

                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body scroll-y mx-5 my-7">
                <!--begin::Form-->
                <form id="addForm" class="form" method="POST">
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
                                        name="titre" id="titre" value="" type="text" required />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Titre secondaire</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="Titre secondaire"
                                        name="titreSecondaire" id="titreSecondaire" value="" type="text"
                                        required />
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Nom de la route</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="Nom de la route"
                                        name="routeName" id="routeName" value="" type="text" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Icone</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="Entrer l'icone"
                                        name="icone" id="icone" value="" type="text" />
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Position</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" type="number"
                                        placeholder="Entrer la position" name="position" id="position"
                                        value="" />
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Parent</span>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-select" data-control="select2"
                                        data-placeholder="Choisir le parent" name="parent" id="parent">
                                        <option></option>
                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">
                                                {{ $menu->titre }}</option>
                                        @endforeach
                                    </select>
                                    <!--begin::Input-->


                                    <!--end::Input-->
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
                                            <label class="fs-6 fw-semibold">Est-il un sous-menu ?</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            {{-- <div class="fs-7 fw-semibold text-muted">Permet de savoir si c'est un menu ou un sous-menu</div> --}}
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <label
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input" name="isSubMenu" type="checkbox"
                                                value="1" id="isSubMenu" />
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--begin::Wrapper-->
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
                                            <label class="fs-6 fw-semibold">A un sous-menu ?</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            {{-- <div class="fs-7 fw-semibold text-muted">Permet de savoir si le menu a des sous-menu</div> --}}
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Switch-->
                                        <label
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input" name="hasSubMenu" type="checkbox"
                                                value="1" id="hasSubMenu" />
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--begin::Wrapper-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-7">

                                    <div class="d-flex flex-stack">

                                        <div class="me-5">

                                            <label class="fs-6 fw-semibold">Voulez-vous activer le menu ?</label>

                                        </div>

                                        <label
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">

                                            <input class="form-check-input" name="statut" type="checkbox"
                                                value="1" id="statut" />
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
            </div>

            <div class="text-center pt-15">
                <button type="reset" id="cancelModal1" class="btn btn-light me-3 btn-sm" data-bs-dismiss="modal">
                    Annuler
                </button>

                <button id="save" class="btn btn-primary btn-sm">
                    <span class="indicator-label">
                        Enregistrer
                    </span>
                </button>
            </div>
            
            <br><br>
            <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->

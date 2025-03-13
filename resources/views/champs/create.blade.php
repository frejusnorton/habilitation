<div class="modal fade " id="kt_modal_add_champ" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold " id="modalTitle">Ajouter un champ</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body scroll-y mx-5">
                <!--begin::Form-->
                <form id="addChamp" class="form" method="POST" action=" {{ route('champ.create') }}">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                        data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-12 mb-5">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Code</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control " placeholder="Entrer le code" name="code"
                                        id="code" value="" type="text" />
                                    <!--end::Input-->
                                </div>

                                <div class="col-12 mb-5">
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Libelle</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input class="form-control " placeholder="Libelle" name="libelle" id="libelle"
                                            value="" type="text" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-12 mb-5">
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Type</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input class="form-control " placeholder="Type" name="type" id="type"
                                            value="" type="text" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="col-12 mb-5">
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Query</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control " placeholder="Query" name="query" id="query"
                                            value="" type="text" />
                                        <!--end::Input-->
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class=" pt-15">
                        <button type="reset" id="cancelModal1" class="btn btn-light me-3 btn-sm"
                            data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <button id="save" class="btn btn-primary btn-sm">
                            <span class="indicator-label">
                                Enregistrer
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>

    </div>

</div>

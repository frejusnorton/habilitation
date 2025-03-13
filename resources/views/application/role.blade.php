<div class="modal fade " id="kt_modal_add_menu_role" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold " id="modalTitle">Ajouter un profil</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body scroll-y mx-5">
                <form id="add_role_menu" class="form" method="POST" action=" {{ route('application_role.create') }}">
                    @csrf
                    <input type="hidden" name="application_id">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                        data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-12 mb-5">
                                <div class="col-12 mb-5">
                                    <div class="fv-row">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Libelle</span>
                                        </label>
                                        <input class="form-control " placeholder="Libelle" name="libelle" id="libelle"
                                            value="" type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class=" pt-5">
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
                    <div id="permdata">

                    </div>
                </form>
            

            </div>
        </div>

    </div>

</div>
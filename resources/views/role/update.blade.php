<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Modification du rôle</h2>
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
                <form id="kt_modal_update_role_form" class="form" action="#">
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
                                        <span class="required">Nom du rôle</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="Entrer le nom du rôle"
                                        name="role_name" id="role_name" value="" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Description du rôle</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid"
                                        placeholder="Entrer la description du rôle" name="role_description"
                                        id="role_description" value="" />
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Permissions-->
                        {{-- <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Listes des menus</label>
                            <!--end::Label-->
                            <div class="">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="control-group">
                                            <div class="row" id="blocMenu">
                                                <div class="col-md-6 px-5 py-2 " id="">
                                                    <label class="form-check form-check-custom form-check-solid me-9">
                                                        <input class="form-check-input checkSingle" type="checkbox"
                                                            data-id="" value=""
                                                            id="kt_roles_select_all" name="menus[]" />
                                                        <span class="form-check-label"
                                                            for="kt_roles_select_all"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!--end::Permissions-->
                        </div> --}}

                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Listes des menus avec leur actions</label>
                            <!--end::Label-->

                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold" id="blocMenu">
                                        @foreach ($menus as $item)
                                            <tr>
                                                <!--begin::Label-->
                                                <td class=" text-gray-800">{{ $item->titre ? $item->titre : '' }}</td>
                                                <!--end::Label-->

                                                <!--begin::Options-->
                                                <td>
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex">
                                                        <!--begin::Checkbox-->
                                                        @foreach (\App\Helpers\Helper::getActionsMenu($item->id) as $action)
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" data-id="{{ $item->id }}" value="{{ $item->id }}"
                                                                    id="kt_roles_select_all" name="actions[]" />
                                                                <span class="form-check-label">
                                                                    {{ $action->libelle ? $action->libelle : '' }}
                                                                </span>
                                                            </label>
                                                        @endforeach


                                                    </div>
                                                    <!--end::Wrapper-->
                                                </td>
                                                <!--end::Options-->
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" id="cancelModal" class="btn btn-light me-3">
                                Annuler
                            </button>

                            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                <span class="indicator-label">
                                    Modifier
                                </span>

                            </button>
                        </div>
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

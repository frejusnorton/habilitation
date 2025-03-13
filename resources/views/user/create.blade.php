<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 id="user_title">Creer un utilisateur</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <!--begin::Modal body-->
            <div class="modal-body py-lg-10 px-lg-10" id="datapart">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                     id="kt_modal_create_app_stepper">
                    <!--begin::Aside-->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <!--begin::Nav-->
                        <div class="stepper-nav ps-lg-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Information personnelles
                                        </h3>

                                        <div class="stepper-desc">
                                            Information sur l'employe
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Approbateurs
                                        </h3>

                                        <div class="stepper-desc">
                                            Validateurs des actions
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Configuration
                                        </h3>

                                        <div class="stepper-desc">
                                            Configuration des options de connexion
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 3-->


                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--begin::Aside-->

                    <!--begin::Content-->
                    <div class="flex-row-fluid py-lg-5 px-lg-15" id="addPart">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_modal_create_app_form">

                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <input type="hidden" name="id" id="id">
                                    @csrf
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Matricule</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm form-control-solid"
                                               name="matricule" id="matricule" placeholder="" value=""/>
                                    </div>
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Nom</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid"
                                               name="nom" id="nom" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">prenoms</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid"
                                               name="prenom" placeholder="" value="" id="prenom"/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Date d'embauche</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid  date" name="date_embauche"
                                               placeholder="" id="dateEmbauche"/>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Poste</span>
                                        </label>
                                        {{--                                        <input type="text" class="form-control form-control-sm form-control-solid"--}}
                                        {{--                                               name="poste" placeholder="" value=""/>--}}
                                        <select class="form-select form-select-sm form-control-solid"
                                                data-control="select2" data-placeholder="Selectionner un poste"
                                                name="poste" id="poste">
                                            <option></option>
                                            @foreach ($postes as $poste)
                                                <option value={{ $poste->id  }} > {{ $poste->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Email</span>
                                        </label>
                                        <input type="email" class="form-control form-control-sm form-control-solid"
                                               id="email" name="email" placeholder="" value=""/>
                                    </div>
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Entite</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select class="form-select form-select-sm form-control-solid"
                                                data-control="select2" data-placeholder="Selectionner une entite"
                                                name="entite" id="entite">
                                            <option></option>
                                            @foreach ($entities as $entite)
                                                <option value={{ $entite->id }}> {{ $entite->libelle }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        {{-- Approbateur 1 --}}
                                        <div class="input-group input-group-solid flex-nowrap p-3">
                                            <span class="input-group-text index-label">Approbateur 1</span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select  rounded-start-0 border-start form-select-solid" data-control="select2"
                                                        data-placeholder="Selectionner un approbateur" name="approbateur1" id="apb1">
                                                    <option></option>
                                                    @foreach ($approbateurs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>{{-- Approbateur 1 --}}
                                        <div class="input-group input-group-solid flex-nowrap p-3">
                                            <span class="input-group-text index-label">Approbateur 2</span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select  rounded-start-0 border-start form-select-solid" data-control="select2"
                                                        data-placeholder="Selectionner un approbateur" name="approbateur2" id="apb2">
                                                    <option></option>
                                                    @foreach ($approbateurs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-solid flex-nowrap p-3">
                                            <span class="input-group-text index-label">Approbateur 3</span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select  rounded-start-0 border-start form-select-solid" data-control="select2"
                                                        data-placeholder="Selectionner un approbateur" name="approbateur3" id="apb3">
                                                    <option></option>
                                                    @foreach ($approbateurs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-solid flex-nowrap p-3">
                                            <span class="input-group-text index-label">Approbateur 4</span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select  rounded-start-0 border-start form-select-solid" data-control="select2"
                                                        data-placeholder="Selectionner un approbateur" name="approbateur4" id="apb4">
                                                    <option></option>
                                                    @foreach ($approbateurs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-solid flex-nowrap p-3">
                                            <span class="input-group-text index-label">Approbateur 5</span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select  rounded-start-0 border-start form-select-solid" data-control="select2"
                                                        data-placeholder="Selectionner un approbateur" name="approbateur5" id="apb5">
                                                    <option></option>
                                                    @foreach ($approbateurs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Login</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-sm form-control-solid"
                                               name="username" id="username" placeholder="" value=""/>
                                        <!--end::Input-->
                                    </div>
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Type d'authentification</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select class="form-select form-select-sm" data-control="select2"
                                                data-placeholder="Select an option" id="auth_type" name="auth_type">
                                            <option></option>
                                            <option value="0">Basique</option>
                                            <option value="1">Active directory</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>

                                </div>
                            </div>
                            <!--end::Step 3-->


                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-10">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            data-kt-stepper-action="previous">
                                        <i class="ki-duotone ki-arrow-left fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Precedent
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-lg btn-primary"
                                            data-url="{{ route('app_user_create') }}" id="saveUser"
                                            data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Enregistrer
                                            <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="indicator-progress">
                                            Patientez...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-lg btn-primary"
                                            data-kt-stepper-action="next">
                                        Suivant
                                        <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

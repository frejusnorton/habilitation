<div class="modal fade" id="kt_modal_add_menu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold " id="modalTitle">Ajout d'un utilisateur</h2>

                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body scroll-y mx-5 my-7">
                <form id="addForm" action="{{ route('app_user_create') }}" class="form" method="POST">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-max-height="auto">
                        <div class="row">
                            <!-- Nom d'utilisateur -->
                            <div class="col-md-12">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Nom d'utilisateur</span>
                                    </label>
                                    <input class="form-control " type="text"
                                        placeholder="Entrer le nom d'utilisateur" name="username" id="username"
                                        value="" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nom -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Nom</span>
                                    </label>
                                    <input class="form-control " placeholder="Entrer le nom"
                                        name="nom" id="nom" value="" type="text" required />
                                </div>
                            </div>

                            <!-- Prénoms -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Prénoms</span>
                                    </label>
                                    <input class="form-control " placeholder="Entrer les prénoms"
                                        name="prenom" id="prenom" value="" type="text" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Poste -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Poste</span>
                                    </label>
                                    <input class="form-control " placeholder="Entrer le poste"
                                        name="poste" id="poste" value="" type="text" required />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Email</span>
                                    </label>
                                    <input class="form-control " placeholder="Entrer l'email"
                                        name="email" id="email" value="" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Rôle -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Rôle</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir le rôle" name="role">
                                        <option></option>
                                        @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Agence -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Agence</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir l'agence" name="agence" id="agence">
                                        <option value="">Sélectionner une agence</option>
                                        @foreach ($agences as $agence)
                                        <option value="{{ $agence->age }}">{{ $agence->lib }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Direction -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Direction</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir la direction" name="direction" id="direction">
                                        <option value="">Sélectionner une direction</option>
                                        @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Service -->
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span>Service</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir le service" name="service" id="service">
                                        <option value="">Sélectionner un service</option>
                                        @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span>Département</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir le département" name="departement" id="departement">
                                        <option value="">Sélectionner un département</option>
                                        @foreach ($departements as $departement)
                                        <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Supérieur hiérachique</span>
                                </label>
                                <select class="form-select superieur " data-control="select2"
                                    data-placeholder="Choisir le supérieur" name="superieur" id="superieur">
                                    <option value="">Selectionner un superieur</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }} ({{
                                        $user->poste }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Type de connexion</span>
                                </label>
                                <select class="form-select type_conn " data-control="select2"
                                    data-placeholder="Choisir le type" name="connexion" id="connexion">
                                    <option value="">Sélectionner un type</option>
                                    <option value="ldap">LDAP</option>
                                    <option value="local">Local</option>
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="fv-row mb-10">
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">Validateur 1</span>
                                    </label>
                                    <select class="form-select " data-control="select2"
                                        data-placeholder="Choisir Validateur 1" name="validateur_1" id="validateur_1">
                                        <option value="">Sélectionner le validateur</option>
                                        @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }} ({{
                                        $user->poste }})</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Validateur 2</span>
                                </label>
                                <select class="form-select " data-control="select2"
                                    data-placeholder="Choisir Validateur 2" name="validateur_2" id="validateur_2">
                                    <option value="">Sélectionner le validateur</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }} ({{
                                        $user->poste }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Validateur 3</span>
                                </label>
                                <select class="form-select " data-control="select2"
                                    data-placeholder="Choisir Validateur 3" name="validateur_3" id="validateur_3">
                                    <option value="">Sélectionner le validateur</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }} ({{
                                        $user->poste }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
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
            </div><br><br>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_edit_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold " id="modalTitle">Modifier un utilisateur</h2>

                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 my-7">
                <form id="edit_user" class="form" method="POST">
                    @csrf
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-max-height="auto">
                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-12 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Identifiant</span>
                                </label>
                                <input class="form-control username " type="text"
                                    placeholder="Entrer le nom d'utilisateur" name="username" id="username" value="" />
                            </div>
                        </div>

                        <!--begin::Name and Surname Fields-->
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Nom</span>
                                </label>
                                <input class="form-control nom " placeholder="Entrer le nom" name="nom" id="nom"
                                    value="" type="text" />
                            </div>
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Prénoms</span>
                                </label>
                                <input class="form-control prenom " placeholder="Entrer le prénom" name="prenom"
                                    id="prenom" value="" type="text" />
                            </div>
                        </div>

                        <!--begin::Poste, Agence and Direction Fields-->
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Poste</span>
                                </label>
                                <input class="form-control poste " placeholder="Entrer le poste" name="poste" id="poste"
                                    value="" type="text" />
                            </div>
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Agence</span>
                                </label>
                                <select class="form-select agence " data-control="select2"
                                    data-placeholder="Choisir l'agence" name="agence" id="agence">
                                    <option value="">Selectionner une agence</option>
                                    @foreach ($agences as $agence)
                                    <option value="{{ $agence->age }}">{{ $agence->lib }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--begin::Direction, Service and Departement Fields-->
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>Direction</span>
                                </label>
                                <select class="form-select direction " data-control="select2"
                                    data-placeholder="Choisir la direction" name="direction" id="direction">
                                    <option value="">Selectionner une direction</option>
                                    @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>Service</span>
                                </label>
                                <select class="form-select service " data-control="select2"
                                    data-placeholder="Choisir le service" name="service" id="service">
                                    <option value="">Selectionner un service</option>
                                    @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>Departement</span>
                                </label>
                                <select class="form-select departement " data-control="select2"
                                    data-placeholder="Choisir le departement" name="departement" id="departement">
                                    <option value="">Selectionner un departement</option>
                                    @foreach ($departements as $departement)
                                    <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Email</span>
                                </label>
                                <input class="form-control email " placeholder="Entrer l'email" name="email" id="email"
                                    value="" type="email" />
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
                                <select class="form-select connexion " data-control="select2"
                                    data-placeholder="Choisir le type" name="connexion" id="connexion">
                                    <option value="">Sélectionner un type</option>
                                    <option value="ldap">LDAP</option>
                                    <option value="local">Local</option>
                                </select>
                            </div>


                        </div>

                        <div class="d-flex gap-5">
                            @for ($i = 1; $i <= 3; $i++) <div class="fv-row mb-10 col-3 mx-5">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Validateur {{ $i }}</span>
                                </label>
                                <div class="row mb-5">
                                    <select class="form-select form-select-sm validateur{{ $i }}" data-control="select2"
                                        data-placeholder="Choisir Validateur {{ $i }}" name="validateur_{{ $i }}"
                                        id="validateur_{{ $i }}">

                                        <option value="" selected>Selectionner un validateur</option>

                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ isset($demande) && $demande->
                                            {'validateur_'.$i} == $user->id ? 'selected' : '' }}>
                                            {{ $user->nom }} {{ $user->prenom }} ({{ $user->poste }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Rôle</span>
                            </label>
                            <select class="form-select role  form-select-sm" data-control="select2"
                                data-placeholder="Choisir le rôle" name="role">
                                <option></option>
                                @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" id="cancelModal1" class="btn btn-light me-3 btn-sm"
                            data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary btn-sm">
                            <span class="indicator-label">Enregistrer</span>
                        </button>
                    </div><br><br>
                </form>
            </div>
        </div>



    </div>
</div>
</div>
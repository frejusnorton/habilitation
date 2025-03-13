 <!--begin::Container-->
 <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
     <!--begin::Post-->
     <div class="content flex-row-fluid" id="kt_content">
         <!--begin::Card-->
         <div class="card">
             <!--begin::Card body-->
             <div class="card-body">
                 <!--begin::Stepper-->
                 <div class="stepper stepper-links d-flex flex-column pt-15" id="kt_create_account_stepper">
                     <!--begin::Nav-->
                     <div class="stepper-nav mb-5">
                         <!--begin::Step 1-->
                         <div class="stepper-item current" data-kt-stepper-element="nav">
                             <h3 class="stepper-title">Responsable</h3>
                         </div>
                         <!--end::Step 1-->
                         <!--begin::Step 2-->
                         <div class="stepper-item" data-kt-stepper-element="nav">
                             <h3 class="stepper-title">Utilisateur</h3>
                         </div>
                         <!--end::Step 2-->
                         <!--begin::Step 3-->
                         <div class="stepper-item" data-kt-stepper-element="nav">
                             <h3 class="stepper-title">Filiale | Contrat</h3>
                         </div>
                         <!--end::Step 3-->
                         <!--begin::Step 4-->
                         <div class="stepper-item" data-kt-stepper-element="nav">
                             <h3 class="stepper-title">Demande</h3>
                         </div>
                         <!--end::Step 4-->
                         <!--begin::Step 5-->
                         {{-- <div class="stepper-item" data-kt-stepper-element="nav">
                             <h3 class="stepper-title">Applications</h3>
                         </div> --}}
                         <!--end::Step 5-->
                     </div>
                     <!--end::Nav-->
                     <!--begin::Form-->
                     <div class="mx-auto mw-600px w-100 pt-15 pb-10">
                         <form action="{{ route('derogation.create') }}" method="POST" id="addDerogation">
                            @csrf
                             <!--begin::Step 1-->
                             <div class="current" data-kt-stepper-element="content">
                                 <!--begin::Wrapper-->
                                 <div class="w-100">
                                     <div class="fv-row mb-10"> 
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Nom</span>
                                         </label>
                                         <!--end::Label-->
                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="Nom" name="nom" id="nom"
                                             value="" type="text" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Prenom</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="Prenom" name="prenom" id="prenom"
                                             value="" type="text" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">E-mail</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="E-mail" name="email" id="email"
                                             value="" type="email" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Poste</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control" placeholder="Poste" name="poste" id="poste"
                                             value="" type="text" />
                                         <!--end::Input-->
                                     </div>

                                 </div>
                                 <!--end::Wrapper-->
                             </div>
                             <!--end::Step 1-->
                             <!--begin::Step 2-->
                             <div data-kt-stepper-element="content">
                                 <!--begin::Wrapper-->
                                 <div class="w-100">

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Nom</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="Nom" name="nomUti" id="nomUti"
                                             value="" type="text" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Prenom</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="Prenom" name="prenomUti"
                                             id="prenomUti" value="" type="text" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">E-mail</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control " placeholder="E-mail" name="emailUti"
                                             id="emailUti" value="" type="email" />
                                         <!--end::Input-->
                                     </div>

                                     <div class="fv-row mb-10">
                                         <!--begin::Label-->
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="required">Poste</span>
                                         </label>
                                         <!--end::Label-->

                                         <!--begin::Input-->
                                         <input class="form-control" placeholder="Poste" name="posteUti" id="posteUti"
                                             value="" type="text" />
                                         <!--end::Input-->
                                     </div>


                                 </div>
                                 <!--end::Wrapper-->
                             </div>
                             <!--end::Step 2-->
                             <!--begin::Step 3-->
                             <div data-kt-stepper-element="content">
                                 <!--begin::Wrapper-->
                                 <div class="w-100">

                                     <div class="mb-10">
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="">Filiale</span>
                                         </label>
                                         <input type="text" class="form-control form-control-lg" name="filiale"
                                             placeholder="" value="ORABANK BENIN"
                                             data-gtm-form-interact-field-id="0">
                                     </div>

                                     <div class="mb-10">
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="">Agence</span>
                                         </label>
                                         <select class="form-select" data-control="select2" name="agence"
                                             id="agence">
                                             <option value="" selected disabled>Choisir une agence</option>
                                             @foreach ($agences as $agence)
                                                 <option value="{{ $agence->id }}">{{ $agence->lib }}</option>
                                             @endforeach
                                         </select>
                                     </div>

                                     <div class="mb-10">
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="">Service</span>
                                         </label>
                                         <select class="form-select" data-control="select2" name="service"
                                             id="service">
                                             <option value="" selected disabled>Choisir un service</option>
                                             @foreach ($services as $service)
                                                 <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                             @endforeach
                                         </select>
                                     </div>

                                     <div class="mb-10">
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="">Direction</span>
                                         </label>
                                         <select class="form-select" data-control="select2" name="direction"
                                             id="direction">
                                             <option value="" selected disabled>Choisir une direction</option>
                                             @foreach ($directions as $direction)
                                                 <option value="{{ $direction->id }}">{{ $direction->libelle }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>

                                     <div class="mb-10">
                                         <label class="fs-5 fw-bold form-label mb-2">
                                             <span class="">Departement</span>
                                         </label>
                                         <select class="form-select" data-control="select2" name="departement"
                                             id="departement">
                                             <option value="" selected disabled>Choisir un département</option>
                                             @foreach ($departements as $departement)
                                                 <option value="{{ $departement->id }}">{{ $departement->libelle }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>


                                 </div>
                                 <!--end::Wrapper-->
                             </div>
                             <!--end::Step 3-->
                             <!--begin::Step 4-->
                             <div data-kt-stepper-element="content">
                                 <div class="d-flex gap-10 flex-wrap ">
                                     <div class="w-100 ">
                                         <div class="mb-5">
                                             <label class="fs-5 fw-bold form-label mb-2">
                                                 <span>Type de demande</span>
                                             </label>
                                             <select class="form-select" data-control="select2" name="type_demande"
                                                 id="type_demande">
                                                 <option value="" selected disabled>Choisir le type de demande
                                                 </option>
                                                 <option value="création">Création</option>
                                                 <option value="modification">Modification</option>
                                                 <option value="réactivation">Réactivation</option>
                                                 <option value="suspension">Suspension</option>
                                             </select>
                                         </div>
                                     </div>


                                     <div class="w-100">
                                         <div class="mb-5">
                                             <label class="fs-5 fw-bold form-label mb-2">
                                                 <span>Applications et rôles</span>
                                             </label>
                                             @foreach ($applications as $application)
                                                 <div class="mb-4">
                                                     <!-- Application sous forme de checkbox -->
                                                     <div class="form-check my-2">
                                                         <input class="form-check-input" type="checkbox"
                                                             name="applications[]" value="{{ $application->id }}"
                                                             id="application_{{ $application->id }}">
                                                         <label class="form-check-label fs-5 fw-bold"
                                                             for="application_{{ $application->id }}">
                                                             {{ $application->libelle }}
                                                         </label>
                                                     </div>
                                                     <!-- Rôles de l'application sous forme de checkboxes -->
                                                     <div class="ms-4">
                                                         @foreach ($application->roles as $role)
                                                             <div class="form-check my-2">
                                                                 <input class="form-check-input" type="checkbox"
                                                                     name="roles[{{ $application->id }}][]"
                                                                     value="{{ $role->id }}"
                                                                     id="role_{{ $application->id }}_{{ $role->id }}">
                                                                 <label class="form-check-label fs-5 fw-bold"
                                                                     for="role_{{ $application->id }}_{{ $role->id }}">
                                                                     {{ $role->libelle }}
                                                                 </label>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>

                                     <div class="w-100">
                                         <label for="end_date" class="fs-5 fw-bold form-label mb-2">Date de fin de
                                             contrat</label>
                                         <input type="text" id="end_date" name="end_date" class="form-control"
                                             placeholder="Sélectionnez une date" />
                                     </div>
                                 </div>
                             </div>
                             <!--end::Step 4-->
                             <!--begin::Step 5-->
                          
                             <!--end::Step 5-->
                             <!--begin::Actions-->
                             <div class="d-flex flex-stack pt-15">
                                 <!--begin::Wrapper-->
                                 <div class="mr-2">
                                     <button type="button" class="btn btn-lg btn-light-primary me-3"
                                         data-kt-stepper-action="previous">
                                         <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                         <span class="svg-icon svg-icon-4 me-1">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                                 <rect opacity="0.5" x="6" y="11" width="13" height="2"
                                                     rx="1" fill="black" />
                                                 <path
                                                     d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                     fill="black" />
                                             </svg>
                                         </span>
                                         <!--end::Svg Icon-->Back</button>
                                 </div>
                                 <!--end::Wrapper-->
                                 <!--begin::Wrapper-->
                                 <div>
                                     <button type="button" class="btn btn-lg btn-primary me-3"
                                         data-kt-stepper-action="submit">
                                         <span class="indicator-label">Submit
                                             <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                             <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                     height="24" viewBox="0 0 24 24" fill="none">
                                                     <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                         rx="1" transform="rotate(-180 18 13)"
                                                         fill="black" />
                                                     <path
                                                         d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                         fill="black" />
                                                 </svg>
                                             </span>
                                             <!--end::Svg Icon--></span>
                                         <span class="indicator-progress">Please wait...
                                             <span
                                                 class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                     </button>
                                     <button type="button" class="btn btn-lg btn-primary"
                                         data-kt-stepper-action="next" id="btn-continue">Continue
                                         <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                         <span class="svg-icon svg-icon-4 ms-1 me-0">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                                 <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                     rx="1" transform="rotate(-180 18 13)" fill="black" />
                                                 <path
                                                     d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                     fill="black" />
                                             </svg>
                                         </span>
                                         <!--end::Svg Icon--></button>
                                 </div>
                                 <!--end::Wrapper-->
                             </div>
                             <!--end::Actions-->
                         </form>
                     </div>
                     <!--end::Form-->
                 </div>
                 <!--end::Stepper-->
             </div>
             <!--end::Card body-->
         </div>
         <!--end::Card-->
     </div>
     <!--end::Post-->
 </div>
 <!--end::Container-->

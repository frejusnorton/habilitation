@extends('layouts.main')
{{-- @dump($validateur1) --}}
@section('page-title')
<div class="page-title d-flex flex-column me-3">
    <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des demandes</h1>

    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

        <li class="breadcrumb-item text-white opacity-75">
            <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-white opacity-75">Enregistrement d'une demande</li>
    </ul>
</div>
@endsection

@section('content')

<div class="card  py-5 ">
    <h1 class="text-center mt-5">Enregistrement d'une demande</h1>
    <div class="card-body py-4">
        <form id="add_demande" action="{{ route('habilitation.create') }}" method="post">
            @csrf
            <div class="col-md-12">
                <div class="fv-row flex-col mb-10">
                    <div class="fs-5 fw-bold form-label mb-2">
                        <span class="required">Type d'habilitation</span>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="type_demande" id="creation" value="creation">
                        <label class="form-check-label fw-bold mb-2" for="creation">
                            Création
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="type_demande" id="modification"
                            value="modification">
                        <label class="form-check-label fw-bold mb-2" for="modification">
                            Modification
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="type_demande" id="reactivation"
                            value="reactivation">
                        <label class="form-check-label fw-bold mb-2" for="reactivation">
                            Réactivation
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="type_demande" id="suspension"
                            value="suspension">
                        <label class="form-check-label fw-bold mb-2" for="suspension">
                            Suspension
                        </label>
                    </div>
                </div>

            </div>
            <div class="">
                {{-- <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1 ">
                        <!--begin::Content-->
                        <div class=" fw-semibold">
                            <div class="fs-6 text-gray-700 "><strong class="me-1">Warning!</strong> By editing
                                the permission name, you might break the system permissions functionality.
                                Please ensure you're absolutely certain before proceeding.</div>
                        </div>
                        <!--end::Content-->

                    </div>
                    <!--end::Wrapper-->
                </div> --}}
                <div class="d-flex gap-5">
                    <div class="fv-row mb-10 col-2 mx-5">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Choisir les applications
                        </button>
                        <div id="application-container">
                            <input type="hidden" name="applications[]" id="application" />
                        </div>
                    </div>
                    <div>

                    </div>
                    <div class="fv-row mb-10 col-4 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Validateur 1</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir Validateur 1" name="validateur_1" id="validateur_1">
                                <option value="">-- Choisir un validateur --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if (!is_null($validateur1) && $user->id ==
                                    $validateur1) selected @endif>
                                   <strong>{{ $user->nom }} {{ $user->prenom }}</strong> ({{ $user->poste }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-10 col-4 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Validateur 2</span>
                        </label>
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir Validateur 2" name="validateur_2" id="validateur_2">
                                <option value="">-- Choisir un validateur --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if (!is_null($validateur2) && $user->id ==
                                    $validateur2) selected @endif>
                                    {{ $user->nom}} {{ $user->prenom}} ({{ $user->poste}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="fv-row mb-10 col-2 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Superieur Hiérachqique</span>
                        </label>
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir son supérieur" name="hierachqiue" id="hierachqiue">
                                <option value="">-- Choisir un supérieur --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->nom}} {{ $user->prenom}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <hr>
                </div>
                {{-- <div class="d-flex gap-5">
                    <div class="fv-row mb-10 col-2 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Agence</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir l'agence" name="agence" id="agence">
                                <option value="">-- Choisir une agence --</option>
                                @foreach ($agences as $agence)
                                <option value="{{ $agence->age }}">
                                    {{$agence->lib }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-10 col-2 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="">Direction</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir la direction" name="direction" id="direction">
                                <option value="">-- Choisir une direction --</option>
                                @foreach ($directions as $direction)
                                <option value="{{ $direction->id }}">
                                    {{$direction->libelle }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-10 col-2 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="">Departement</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir le departement" name="departement" id="departement">
                                <option value="">-- Choisir un departement --</option>
                                @foreach ($departements as $departement)
                                <option value="{{ $departement->id }}">
                                    {{$departement->libelle }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-10 col-2 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="">Service</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir le service" name="service" id="service">
                                <option value="">-- Choisir un service --</option>
                                @foreach ($services as $service)
                                <option value="{{ $service->id }}">
                                    {{$service->libelle }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div> --}}
                <hr>
                <div id="formPart">
                </div>
            </div>
            <div class="text-center pt-15">
                <button id="submitBtn" class="btn btn-primary btn-sm">
                    <span class="indicator-label">
                        Enregistrer
                    </span>
                </button>
            </div>
        </form>
        @include('habilitation.choix')
    </div>
</div>

</form>
</div>
</div>

@endsection

@section('js')
@include('habilitation.js')
@endsection
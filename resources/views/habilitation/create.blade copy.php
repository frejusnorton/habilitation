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
                <div class="d-flex gap-5">
                    <div class="fv-row mb-10 col-3 mx-5">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">Applications</span>
                        </label>
                        <!--end::Label-->
                        <div class="row mb-5">
                            <select class="form-select form-select-sm" data-control="select2"
                                data-placeholder="Choisir l'application" name="applications" id="appli">
                                <option></option>
                                @foreach ($applications as $application)
                                @foreach ($application->champs as $champ)
                                <p>{{$champ}}</p>
                                @endforeach
                                <option value="{{ $application->id }}"
                                    data-url="{{route('loadField',['application' => $application->id])}}">
                                    {{ $application->libelle }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>

                    </div>
                    <div class="fv-row mb-10 col-3 mx-5">
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
                                    {{ $user->username }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fv-row mb-10 col-3 mx-5">
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
                                    {{ $user->username }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <hr>
                <div id="formPart">
                </div>
            </div>
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
</div>
</div>
@endsection

@section('js')
@include('habilitation.js')
@endsection
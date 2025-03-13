@extends('layouts.main')

@section('page-title')
    <div class="page-title d-flex flex-column me-3">

        <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des roles</h1>

        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
            </li>

            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-white opacity-75">Nouveau Role</li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="card  py-5 ">
        <h1 class="text-center mt-5">Enregistrement d'un rôle </h1>
        <div class="card-body py-4">
            <form action="{{ isset($role) ? route('role.update', ['role' => $role->id]) : route('role.create') }}"
                method="post" id="addForm">
                @csrf
                <div class="d-flex justify-content-center">
                    <div class="col-8">

                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Nom du rôle</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Entrer le nom du rôle"
                                name="role_name" value="{{ isset($role) && $role ? $role->role_name : '' }}" />
                            <!--end::Input-->
                        </div>

                        <div class="">
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">Description du rôle</span>
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Entrer la description du rôle"
                                    name="role_description" value="{{ isset($role) && $role ? $role->description : '' }}" />
                                <!--end::Input-->
                            </div>
                        </div>

                        {{-- <div class="col-12 mb-5">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="fw-semibold fs-6 mb-2">Statut</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="statut" name="statut"
                                        value="1" {{ isset($role) && $role->statut ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div> --}}

                        <h3 class=''>Liste des menus et des actions</h3>
                        <div class="form-check my-5">
                            <input class="form-check-input " id="checkAllToggle" type="checkbox" value="">
                            <label class="form-check-label fs-5 fw-bold ">Tout sélectionné</label>
                        </div>

                        @foreach ($menus as $menu)
                            <div class="form-check my-2">
                                <input class="form-check-input ckeck" type="checkbox" name="menu[]"
                                    value="{{ $menu->id }}"
                                    {{ isset($role) && in_array($menu->id, $role->selectedMenu()) == true ? 'checked' : '' }}>
                             
                                <label class="form-check-label fs-5 fw-bold ">{{ $menu->titre }}</label>
                            </div>
                            @foreach (\App\Helpers\Helper::getActionsMenu($menu->id) as $action)
                                <div class='d-flex pl-5 my-3' style='margin-left:30px'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-arrow-90deg-up ml-5" viewbox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.854 1.146a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L4 2.707V12.5A2.5 2.5 0 0 0 6.5 15h8a.5.5 0 0 0 0-1h-8A1.5 1.5 0 0 1 5 12.5V2.707l3.146 3.147a.5.5 0 1 0 .708-.708l-4-4z" />
                                    </svg>
                                    <div class="form-check">
                                        <input class="form-check-input  ckeck" type="checkbox" name="actions[]"
                                            value="{{ $action->id }}"

                                            {{ isset($role) && in_array($action->id, $role->selectedAction()) ? 'checked' : '' }}>
                                        {{-- {{ $action->id }} --}} 
                                        <label class="form-check-label  fs-5 "
                                            name='actions[]'>{{ $action->libelle }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                        <button class="btn btn-primary mt-5" id="save">Enregistrer</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
 
@endsection

@section('js')
    @include('role.js')
@endsection

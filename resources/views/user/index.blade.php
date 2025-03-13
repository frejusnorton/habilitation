@extends('layouts.main')

@section('page-title')
<div class="page-title d-flex flex-column me-3">

    <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des utilisateurs</h1>

    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

        <li class="breadcrumb-item text-white opacity-75">
            <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-white opacity-75">Utilisateurs</li>
    </ul>
</div>
<!--begin::Actions-->

<div class="d-flex align-items-center gap-5 py-3 py-md-1 btn-sm">
    <!-- Bouton d'exportation avec Dropdown -->
    <div class="dropdown">
        <button class="btn btn-success btn-sm dropdown-toggle text-white d-flex align-items-center px-3 py-2"
            type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-download me-2 fs-5"></i>
            <span>Exporter</span>
        </button>
        <ul class="dropdown-menu p-4 shadow-lg" style="min-width: 280px;">
            <li class="mb-3">
                <label for="start_date" class="form-label fw-semibold">📅 Date de début</label>
                <input type="date" id="start_date" class="form-control form-control-sm">
            </li>
            <li class="mb-3">
                <label for="end_date" class="form-label fw-semibold">📅 Date de fin</label>
                <input type="date" id="end_date" class="form-control form-control-sm">
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li class="d-flex flex-column gap-2">
                <a class="dropdown-item export-option d-flex align-items-center" data-type="pdf"
                    href="{{route('export-users-pdf')}}">
                    <i class="bi bi-file-earmark-pdf text-danger me-2 fs-5"></i> Exporter en PDF
                </a>
                <a class="dropdown-item export-option d-flex align-items-center" data-type="excel"
                    href="{{route('export-users-excel')}}">
                    <i class="bi bi-file-earmark-excel text-success me-2 fs-5"></i> Exporter en Excel
                </a>
            </li>
        </ul>
    </div>

    <!-- Bouton Nouvelle Demande -->
    <a href="#" class="btn btn-primary btn-sm d-flex align-items-center px-3 py-3 ms-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_menu">
        <i class="bi bi-plus fs-5 mx-1"></i> <span>Nouvel utilisateur</span>
    </a>
</div>

<!--end::Actions-->
@endsection
@section('content')

<div id="kt_app_content_container" class="app-container  container-fluid ">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="searchUser" class="form-control form-control-sm w-250px ps-10 filter"
                        placeholder="Rechercher un utilisateur..." />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                    <!--begin::Filter-->
                    <button type="button" class="btn btn-sm btn-light-primary " data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="bi bi-funnel fs-2x mx-1"></i> Filtrer
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filtrer la liste</div>
                        </div>
                        <!--end::Header-->

                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->

                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-user-table-filter="form">

                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Role:</label>
                                <select class="form-select form-select-solid fw-bold filter" data-kt-select2="true"
                                    id="SearchRole" data-placeholder="Selectioner une option" data-allow-clear="true"
                                    data-hide-search="true">
                                    <option></option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Statut :</label>
                                <select class="form-select form-select-solid fw-bold filter" data-kt-select2="true"
                                    id="searchStatut" data-placeholder="Selectionner une option" data-hide-search="true"
                                    data-allow-clear="true">
                                    <option></option>
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset"
                                    class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Annuler
                                </button>

                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->



                </div>
                <!--end::Toolbar-->


            </div>
            <!--end::Card toolbar-->
        </div>

        <div class="card-body py-4" id="datapart">
            @include('user.datapart')
        </div>

    </div>
    <!--end::Card-->
</div>

@include('user.add')
@include('user.edit')
@endsection

@section('js')
@include('user.user-js')
@include('user.edit-js')
@endsection
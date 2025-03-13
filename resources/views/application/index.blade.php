@extends('layouts.main')

@section('page-title')

    <div class="page-title d-flex flex-column me-3">

        <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des applications</h1>

        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
            </li>

            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-white opacity-75">Applications</li>
        </ul>
    </div>
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-3 py-md-1 gap-5">
        <div class="dropdown">
            <button class="btn btn-success btn-sm dropdown-toggle text-white d-flex align-items-center px-4 py-3"
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
                        href="{{route('export-application-pdf')}}">
                        <i class="bi bi-file-earmark-pdf text-danger me-2 fs-5"></i> Exporter en PDF
                    </a>
                    <a class="dropdown-item export-option d-flex align-items-center" data-type="excel"
                        href="{{route('export-application-excel')}}">
                        <i class="bi bi-file-earmark-excel text-success me-2 fs-5"></i> Exporter en Excel
                    </a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn btn-primary btn-sm d-flex align-items-center px-3 py-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_menu"
            id="kt_toolbar_primary_button">
            <i class="bi bi-plus fs-2x "></i>
            Nouvelle application
        </a>

    </div>
    <!--end::Actions-->
@endsection

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form action="" method="post" id="sortForm">
                    @csrf
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="bi bi-search fs-3 position-absolute ms-5"></i>
                        <input type="text" data-kt-user-table-filter="search" id="search" name="search"
                            class="form-control form-control-solid w-250px ps-13 filter" placeholder="Rechercher" />
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body py-4" id="datapart">
            @include('application.datatable')
        </div>
    </div>
    @include('application.create')
    @include('application.edit')
    @include('application.role')
    @include('application.champs')
@endsection

@section('js')
    @include('application.js')
@endsection

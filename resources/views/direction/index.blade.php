@extends('layouts.main')

@section('page-title')
    <div class="page-title d-flex flex-column me-3">

        <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des directions</h1>

        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
            </li>

            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-white opacity-75">Direction</li>
        </ul>
    </div>
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-3 py-md-1">

        <button type="button" id="export" class="btn btn-success me-3 btn-sm text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                    transform="rotate(90 12.75 4.25)" fill="black" />
                <path
                    d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                    fill="black" />
                <path
                    d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                    fill="#fff" />
            </svg>

            Exporter
        </button>
        <a href="#" class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#kt_modal_add_menu"
            id="kt_toolbar_primary_button"> <i class="bi bi-plus fs-2x mx-1"></i> Nouvelle direction</a>

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
            @include('direction.datatable')
        </div>
    </div>
    @include('direction.create')
    @include('direction.edit')
@endsection

@section('js')
    @include('direction.js')
@endsection
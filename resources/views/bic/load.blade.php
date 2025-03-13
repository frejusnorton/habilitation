@extends('layouts.main')

@section('toolbar')
    <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-white fw-bolder my-1 fs-3">Chargement de déclaration</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-white opacity-75">
                        <a href="" class="text-white text-hover-primary">Accueil</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                    </li>
                 
                    <li class="breadcrumb-item text-white opacity-75">Chargement</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-3 py-md-1">
                <!--begin::Wrapper-->
                <div class="me-4">
                    <!--begin::Menu-->

                </div>

                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <form action="{{ route('bic.chargement') }}" method="POST" enctype="multipart/form-data" class="mt-5">
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card shadow p-4 text-center">

                        <h4 class="mb-10 mt-5">Chargement des déclarations BIC</h4>
                        <div class="d-flex justify-content-center mb-3 align-items-center">
                            <div class="mx-3">
                                <input name="excel_file" type="file" accept=".xlsx, .xml"
                                    class="form-control form-control-sm me-2" aria-label="Upload" required>
                            </div>
                            <div class="mx-3">
                                <input class="form-control form-control-sm date me-2" name="date"
                                    placeholder="Date de déclaration" />
                            </div>
                            <div class="mx-3">
                                <button class="btn btn-success btn-sm me-2" type="submit">Charger</button>
                            </div>
                        </div>

                        <small class="mt-3 d-block text-success">Seuls les fichiers Excel (.xlsx) et (.xml) sont
                            acceptés.</small>

                        <div class="">
                            <a href="{{ url('BIC/Model.xlsx') }}" class=" mt-3 text-primary">
                                <i class="bi bi-box-arrow-down text-primary"></i> Télécharger le fichier model
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(".date").flatpickr({
            dateFormat: "d-m-Y",
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection

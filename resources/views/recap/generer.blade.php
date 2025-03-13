@extends('layouts.main')

@section('toolbar')
    <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-white fw-bolder my-1 fs-3">Chargement de déclaration</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-white opacity-75">
                        <a href="" class="text-white text-hover-primary">Accueil</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-white opacity-75">Chargement</li>
                </ul>
            </div>
            <div class="d-flex align-items-center py-3 py-md-1">
                <div class="me-4">

                </div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    <form action="" method="POST" enctype="multipart/form-data" class="">
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card shadow p-4 text-center">

                        <h4 class="mb-10 ">Géneration de relevé de frais et commissions</h4>
                        <div class="d-flex justify-content-center mb-3 align-items-center">
                            <div class="mx-3">

                                <select id="remote" class="form-select form-select-solid" name="cli" required
                                    data-placeholder="Saisir le nom ou le code client">Z
                                    <option value="{{ $cli != null ? $cli : '' }}" selected="selected">{{ $cli != null ? $cli : '' }}
                                    </option>
                                </select>
                            </div>

                            <div class="mx-3">
                                <button class="btn btn-success btn-sm me-2" type="submit">Genérer</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function formatRepoSelection(repo) {
            if (repo.cli != null && repo.cli != '') {
                console.log(repo.cli);
            }
            return repo.cli || repo.nomrest;
        }

        //Section select2
        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +

                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.cli + "| " + repo.nomrest);

            return $container;
        }

        function formatRepoSelection(repo) {
            if (repo.cli != null && repo.cli != '') {
                return repo.cli + "| " + repo.nomrest
            }

            return repo.cli || repo.text;
        }

        $('#remote').select2({
            language: "fr",
            ajax: {
                url: "{{ route('getClient') }}",
                dataType: 'json',
                processResults: function(data, params) {

                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Search for a repository',
            minimumInputLength: 4,
            id: function(repo) {
                return (repo.nomrest); // use slug field for id
            },
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        //Fin Section select2
    </script>
@endsection

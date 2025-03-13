@extends('layouts.main')

@section('toolbar')
    <div class="toolbar py-5 py-lg-15" id="">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex  fw-bolder my-1 fs-3">Monitoring d'envoi des rlv comm </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item  opacity-75">
                        <a href="" class=" text-hover-primary">Accueil</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item  opacity-75">Récapitulatif Annuel</li>
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

    <div class="card card-flush h-lg-100">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">{{\App\Helpers\Helper::getYear()}}</span>
            </h3>

            <div class="card-toolbar">
                {{-- <span class="badge badge-light-danger fs-base mt-n3">
                    <i class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1"><span class="path1"></span><span
                            class="path2"></span></i>

                </span> --}}
            </div>
        </div>

        <div class="card-body d-flex align-items-end pt-6">
            <div class="row align-items-center mx-0 w-100">
                <div class="col-7 px-0">
                    <div class="d-flex flex-column content-justify-center">
                        <div class="d-flex fs-6 fw-semibold align-items-center">
                            <div class="bullet bg-gray-700 me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>

                            <div class="fs-5 fw-bold text-gray-600 me-5">Nombre total de relevé:</div>

                            <div class="ms-auto fw-bolder text-gray-700 text-end">{{ $total != null ? $total->nb : 0 }}
                            </div>
                        </div>
                        <div class="d-flex fs-6 fw-semibold align-items-center my-4">
                            <div class="bullet me-3 bg-warning" style="border-radius: 3px;width: 12px;height: 12px"></div>

                            <div class="fs-5 fw-bold text-warning me-5">Relevé en attente:</div>

                            <div class="ms-auto fw-bolder text-warning text-end">
                                {{ $enAttente != null ? $enAttente->nb : 0 }}</div>
                        </div>
                        <div class="d-flex fs-6 fw-semibold align-items-center my-4">
                            <div class="bullet bg-success me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>

                            <div class="fs-5 fw-bold text-success me-5">Relevé envoyé:</div>

                            <div class="ms-auto fw-bolder text-success text-end">{{ $success != null ? $success->nb : 0 }}
                            </div>
                        </div>
                        <div class="d-flex fs-6 fw-semibold align-items-center my-4">
                            <div class="bullet bg-danger me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>

                            <div class="fs-5 fw-bold text-danger me-5">Relevé non envoyé:</div>

                            <div class="ms-auto fw-bolder text-danger text-end">{{ $echec != null ? $echec->nb : 0 }}</div>
                        </div>
                    </div>
                </div>

                @php
                    $taux = 0;
                    $all = $total != null ? $total->nb : 0;
                    $success = $success != null ? $success->nb : 0;
                    $echec = $echec != null ? $echec->nb : 0;
                    $att = $success + $echec;

                    $taux = round(($att / $all) * 100);
                    switch ($taux ) {
                        case $taux > 0 && $taux <= 50:
                            $color = '#f1416c';
                            break;

                        case $taux > 50 && $taux <= 70:
                            $color = '#ffc700';
                            break;

                        case $taux > 70:
                            $color = '#20E647';
                            break;

                        default:
                            $color = '#7e8299';
                            break;
                    }

                @endphp
                <div class="col-5 d-flex justify-content-end px-0">
                    <div id="chart" data-val="{{ $taux }}" data-color="{{ $color }}"
                        data-kt-chart-color="success" style="height: 300px">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('assets/plugins/easypie.min.js') }}" type="text/javascript"></script>

    <script>
        console.log($('#chart').data('color'));
        let color = $('#chart').data('color');
        var options = {
            chart: {
                height: 280,
                type: "radialBar"
            },

            series: [$('#chart').data('val')],
            colors: [`${color}`],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 15,
                        size: "70%"
                    },

                    dataLabels: {
                        showOn: "always",
                        name: {
                            offsetY: -10,
                            show: true,
                            color: "#888",
                            fontSize: "13px"
                        },
                        value: {
                            color: "#111",
                            fontSize: "30px",
                            show: true
                        }
                    }
                }
            },

            stroke: {
                lineCap: "round",
            },
            labels: ["Taux d'envoi"]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();

        setInterval(function () {
            location.reload(); // Recharge la page
        }, 600000); // 600000 ms = 10 minutes
    </script>

@stop

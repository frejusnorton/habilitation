@extends('monitoring.layout')

@section('title', 'Tableau de bord')

@section('content')

    <div class="card mt-6">


        <h1 class=" text-center my-2 font-bold">MONITORING DES TRANSACTIONS</h1>


        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center   p-4 mb-5 gap-5">
            {{-- MTN BANQUE TO WALLET  --}}
            <div class="">
                <div class="d-flex justify-content-center align-items-center border-2">
                    <canvas id="myChart" style="width:100%;max-width:400px"></canvas>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mt-1 text-bold">
                        <thead class="">
                            <tr>
                                <th>Statut</th>
                                <th class="">Date dern. trans.</th>
                                <th class="">Nombre</th>
                                <th class="">Montant total</th>
                            </tr>
                        </thead>
                        <tbody class="text-bold">
                            <tr>
                                <td class="text-success text-bold"><b><b>Réussies</b></b></td>
                                <td class="text-success text-center text-bold" id="datetime_b2w_ok">
                                    <b>{{ $data['datetime_b2w_ok'] }}</b>
                                </td>
                                <td class="text-success text-end" id="mtn_b2w_ok"><b>{{ $data['mtn_b2w_ok'] }}</b></td>
                                <td class="text-success text-end" id="montant_b2w_ok"><b>{{ $data['montant_b2w_ok'] }}</b>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="text-danger text-bold"><b>Echouées</b></td>
                                <td class="text-danger text-center" id="datetime_b2w_ko">{{ $data['datetime_b2w_ko'] }}</td>
                                <td class="text-danger text-end" id="mtn_b2w_ko">{{ $data['mtn_b2w_ko'] }}</td>
                                <td class="text-danger text-end" id="montant_b2w_ko">{{ $data['montant_b2w_ko'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MTN  WALLET TO  BANQUE  --}}
            <div class="">
                <div class="flex justify-center items-center border-2">
                    <canvas id="myChart1" style="width:100%;max-width:400px"></canvas>
                </div>
                <div class="table-responsive">
                    <table class=" table table-bordered mt-1 ">
                        <thead class="">
                            <tr>
                            <tr>
                                <th>Statut</th>
                                <th class="">Date dern. trans.</th>
                                <th class="">Nombre</th>
                                <th class="">Montant total</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td class="text-success text-bold"><b>Réussies</b></td>
                                <td class="text-success text-center " id="datetime_w2b_ok">{{ $data['datetime_w2b_ok'] }}
                                </td>
                                <td class="text-success text-end" id="mtn_w2b_ok">{{ $data['mtn_w2b_ok'] }}</td>
                                <td class="text-success text-end" id="montant_w2b_ok">{{ $data['montant_w2b_ok'] }}</td>
                            </tr>
                            <tr class="">
                                <td class="text-danger text-bold"><b>Echouées</b></td>
                                <td class="text-danger text-center" id="datetime_w2b_ko">{{ $data['datetime_w2b_ko'] }}</td>
                                <td class="text-danger text-end" id="mtn_w2b_ko">{{ $data['mtn_w2b_ko'] }}</td>
                                <td class="text-danger text-end" id="montant_w2b_ko">{{ $data['montant_w2b_ko'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="alert" class="container d-flex justify-content-center d-none" style="color: red;">
            <h3>
                Attention ! : La dernière transaction de MTN réussie date de 30 minutes déjà
            </h3>
        </div>

        <div id="alertMv" class="container d-flex justify-content-center d-none" style="color: red;">
            <h3>
                Attention ! : La dernière transaction de Moov réussie date de 30 minutes déjà
            </h3>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center mt-1  p-4 mb-2 gap-5">
            {{-- MOOV BANQUE TO WALLET  --}}
            <div class="">

                <div class="d-flex justify-content-center align-items-center border-2">
                    <canvas id="myChart2" style="width:100%;max-width:400px"></canvas>
                </div>

                <div class="table-responsive">
                    <table class=" table table-bordered mt-1 ">
                        <thead class="">
                            <tr>
                                <th>Statut</th>
                                <th class="">Date dern. trans.</th>
                                <th class="">Nombre</th>
                                <th class="">Montant total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="">
                                <td class="text-success text-bold"><b>Réussies</b></td>
                                <td class="text-success text-center " id="datetime_b2w_ok2">
                                    {{ $dataMoov['datetime_b2w_ok'] }}</td>
                                <td class="text-success text-end" id="mtn_b2w_ok2">{{ $dataMoov['mtn_b2w_ok'] }}</td>
                                <td class="text-success text-end" id="montant_b2w_ok2">{{ $dataMoov['montant_b2w_ok'] }}
                                </td>
                            </tr>
                            <tr class="">
                                <td class="text-danger text-bold"><b>Echouées</b></td>
                                <td class="text-danger text-center " id="datetime_b2w_ko2">
                                    {{ $dataMoov['datetime_b2w_ok'] }}</td>
                                <td class="text-danger text-end" id="mtn_b2w_ko2">{{ $dataMoov['mtn_b2w_ko'] }}</td>
                                <td class="text-danger text-end" id="montant_b2w_ko2">{{ $dataMoov['montant_b2w_ko'] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- MOOV  WALLET TO  BANQUE  --}}
            <div class="">
                <div class="flex justify-center items-center border-2">

                    <canvas id="myChart3" style="width:100%;max-width:400px"></canvas>
                </div>
                <div class="table-responsive">
                    <table class=" table table-bordered mt-1 ">
                        <thead class="">
                            <tr>
                                <th class="">Statut</th>
                                <th class="">Date dern. trans.</th>
                                <th class="">Nombre</th>
                                <th class="">Montant total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td class="text-success text-bold"><b>Réussies</b></td>
                                <td class="text-success text-center " id="datetime_w2b_ok2">
                                    {{ $dataMoov['datetime_w2b_ok'] }}</td>
                                <td class="text-success text-end" id="mtn_w2b_ok2">{{ $dataMoov['mtn_w2b_ok'] }}</td>
                                <td class="text-success text-end" id="montant_w2b_ok2">{{ $dataMoov['montant_w2b_ok'] }}
                                </td>
                            </tr>
                            <tr class="">
                                <td class="text-danger text-bold"><b>Echouées</b></td>
                                <td class="text-danger text-center" id="datetime_w2b_ko2">
                                    {{ $dataMoov['datetime_w2b_ko'] }}</td>
                                <td class="text-danger text-end" id="mtn_w2b_ko2">{{ $dataMoov['mtn_w2b_ko'] }}</td>
                                <td class="text-danger text-end" id="montant_w2b_ko2">{{ $dataMoov['montant_w2b_ko'] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class=" d-flex justify-content-center align-items-center">
            <h4>Recapitulatif des erreurs</h4>
        </div>


        <div class="d-flex flex-column flex-md-row justify-content-center align-items-start  p-4 mb-5 gap-5">
            {{-- ERREUR MTN --}}
            <div class="table-responsive flex-fill">
                <table class="table table-bordered table-sm mt-5">
                    <thead class="bg-light">
                        <tr>
                            <th class="">ETAT</th>
                            <th class="">Motif MTN</th>
                            <th class="">Nb</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mtnErrors as $error)
                            <tr>
                                <td class="text-danger">{{ $error['etat_mtn_errors'] ?? 'N/A' }}</td>
                                <td class="text-danger">{{ $error['motif_mtn_errors'] ?? 'N/A' }}</td>
                                <td class="text-center text-danger"> {{ $error['errors_mtn'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ERREUR MOOV --}}
            <div class="table-responsive flex-fill">
                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <th class="">Etat</th>
                            <th class="">Motif MOOV</th>
                            <th class="">Nb</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($moovErrors as $errormoov)
                            <tr>
                                <td class="small text-danger">
                                   {{ $errormoov['etat_moov_errors'] ?? 'N/A' }}
                                </td>
                                <td class="small text-danger">
                                   {{ $errormoov['motif_moov_errors'] ?? 'N/A' }}
                                </td>
                                <td class="text-center text-danger">
                                    {{ $errormoov['errors_moov'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('scripts')

    <script>
        var myChart, myChart1, myChart2, myChart3;

        function fetchData() {
            // MTN BANQUE TO WALLET
            var barColors = ["red", "green"];

            if (!myChart) {
                myChart = new Chart("myChart", {
                    type: "doughnut",
                    data: {
                        labels: ["Echec", "Reussie"],
                        datasets: [{
                            backgroundColor: barColors,
                            data: [{{ $data['mtn_b2w_ko'] }}, {{ $data['mtn_b2w_ok'] }}]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "MTN BANQUE TO WALLET"
                        }
                    }
                });
            }

            // MTN WALLET TO BANQUE
            if (!myChart1) {
                myChart1 = new Chart("myChart1", {
                    type: "doughnut",
                    data: {
                        labels: ["Echec", "Reussie"],
                        datasets: [{
                            backgroundColor: barColors,
                            data: [{{ $data['mtn_w2b_ko'] }}, {{ $data['mtn_w2b_ok'] }}]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "MTN WALLET TO BANQUE"
                        }
                    }
                });
            }

            // MOOV BANQUE TO WALLET

            if (!myChart2) {
                myChart2 = new Chart("myChart2", {
                    type: "doughnut",
                    data: {
                        labels: ["Echec", "Reussie"],
                        datasets: [{
                            backgroundColor: barColors,
                            data: [{{ $dataMoov['mtn_b2w_ko'] }}, {{ $dataMoov['mtn_b2w_ok'] }}]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "MOOV BANQUE TO WALLET"
                        }
                    }
                });
            }


            // MOOV WALLET TO BANQUE
            if (!myChart3) {
                myChart3 = new Chart("myChart3", {
                    type: "doughnut",
                    data: {
                        labels: ["Echec", "Reussie"],
                        datasets: [{
                            backgroundColor: barColors,
                            data: [{{ $dataMoov['mtn_b2w_ko'] }}, {{ $dataMoov['mtn_b2w_ok'] }}]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "MOOV WALLET TO BANQUE"
                        }
                    }
                });
            }

            $.ajax({
                url: 'monitoring-momo',
                method: 'GET',
                success: function(response) {

                    if (response.hasOwnProperty('is_b2w_ok_exceeded')) {
                        if ((response.is_b2w_ok_exceeded)) {
                            $('#alert').removeClass('d-none');
                            let interval = setInterval(() => {
                                $('#alert').toggleClass('invisible');
                            }, 3000);

                        } else {
                            $('#alert').addClass('d-none');
                        }
                    }
                    if (response.hasOwnProperty('is_b2w_ok_exceededMoov')) {
                        if ((response.is_b2w_ok_exceededMoov)) {
                            $('#alertMv').removeClass('d-none');
                            let interval = setInterval(() => {
                                $('#alertMv').toggleClass('invisible');
                            }, 3000);

                        } else {
                            $('#alertMv').addClass('d-none');
                        }
                    }

                    if (response.data && typeof response.data === 'object') {
                        if (response.data.hasOwnProperty('mtn_b2w_ko') && response.data.hasOwnProperty(
                                'mtn_b2w_ok')) {
                            var newValuesb2w = [response.data.mtn_b2w_ko, response.data.mtn_b2w_ok];

                            myChart.data.datasets[0].data = newValuesb2w;
                            myChart.update();
                            $('#mtn_b2w_ok').text(response.data.mtn_b2w_ok);
                            $('#montant_b2w_ok').text(response.data.montant_b2w_ok);
                            $('#datetime_b2w_ok').text(response.data.datetime_b2w_ok);

                            $('#mtn_b2w_ko').text(response.data.mtn_b2w_ko);
                            $('#montant_b2w_ko').text(response.data.montant_b2w_ko);
                            $('#datetime_b2w_ko').text(response.data.datetime_b2w_ko);
                        } else {
                            console.error(
                                "Les propriétés 'mtn_b2w_ko' ou 'mtn_b2w_ok' sont indéfinies dans 'data'."
                            );
                        }

                        if (response.data.hasOwnProperty('mtn_w2b_ko') && response.data.hasOwnProperty(
                                'mtn_w2b_ok')) {
                            var newValuesw2b = [response.data.mtn_w2b_ko, response.data.mtn_w2b_ok];
                            myChart1.data.datasets[0].data = newValuesw2b;
                            myChart1.update();
                            $('#mtn_w2b_ok').text(response.data.mtn_w2b_ok);
                            $('#montant_w2b_ok').text(response.data.montant_w2b_ok);
                            $('#datetime_w2b_ok').text(response.data.datetime_w2b_ok);

                            $('#mtn_w2b_ko').text(response.data.mtn_w2b_ko);
                            $('#montant_w2b_ko').text(response.data.montant_w2b_ko);
                            $('#datetime_w2b_ko').text(response.data.datetime_w2b_ko);
                        } else {
                            console.error(
                                "Les propriétés 'mtn_w2b_ko' ou 'mtn_w2b_ok' sont indéfinies dans 'data'."
                            );
                        }
                    } else {
                        console.error("'data' est indéfini ou n'est pas un objet valide.");
                    }

                    if (response.dataMoov && typeof response.data === 'object') {
                        if (response.dataMoov.hasOwnProperty('mtn_b2w_ko') && response.dataMoov
                            .hasOwnProperty(
                                'mtn_b2w_ok')) {
                            var newValuesb2w = [response.dataMoov.mtn_b2w_ko, response.dataMoov.mtn_b2w_ok];

                            myChart2.data.datasets[0].data = newValuesb2w;
                            myChart2.update();
                            $('#mtn_b2w_ok2').text(response.dataMoov.mtn_b2w_ok);
                            $('#montant_b2w_ok2').text(response.dataMoov.montant_b2w_ok);
                            $('#datetime_b2w_ok2').text(response.dataMoov.datetime_b2w_ok);

                            $('#mtn_b2w_ko2').text(response.dataMoov.mtn_b2w_ko);
                            $('#montant_b2w_ko2').text(response.dataMoov.montant_b2w_ko);
                            $('#datetime_b2w_ko2').text(response.dataMoov.datetime_b2w_ko);
                        } else {
                            console.error(
                                "Les propriétés 'mtn_b2w_ko' ou 'mtn_b2w_ok' sont indéfinies dans 'data'."
                            );
                        }

                        if (response.dataMoov.hasOwnProperty('mtn_w2b_ko') && response.dataMoov
                            .hasOwnProperty(
                                'mtn_w2b_ok')) {
                            var newValuesw2b = [response.dataMoov.mtn_w2b_ko, response.dataMoov.mtn_w2b_ok];

                            myChart3.data.datasets[0].data = newValuesw2b;
                            myChart3.update();
                            $('#mtn_w2b_ok2').text(response.dataMoov.mtn_w2b_ok);
                            $('#montant_w2b_ok2').text(response.dataMoov.montant_w2b_ok);
                            $('#datetime_w2b_ok2').text(response.dataMoov.datetime_w2b_ok);

                            $('#mtn_w2b_ko2').text(response.dataMoov.mtn_w2b_ko);
                            $('#montant_w2b_ko2').text(response.dataMoov.montant_w2b_ko);
                            $('#datetime_w2b_ko2').text(response.dataMoov.datetime_w2b_ko);
                        } else {
                            console.error(
                                "Les propriétés 'mtn_w2b_ko' ou 'mtn_w2b_ok' sont indéfinies dans 'data'."
                            );
                        }
                    } else {
                        console.error("'data' est indéfini ou n'est pas un objet valide.");
                    }
                }

            });
        }
        fetchData();
        setInterval(fetchData, 60000);
    </script>

@endsection

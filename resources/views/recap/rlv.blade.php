<!DOCTYPE html>
<html>

<body>
    <style>
        table,
        td,
        th {
            border: 1px solid;
            text-align: left;
            padding-left: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>


    <main class="container-fluid mt-4 w-100" style="margin: 1mm 3mm 20mm 3mm;">
        <!-- IMAGE ORABANK & RECAPITULATIF ANNUEL DES FRAIS -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <!-- IMAGE ORABANK -->
                <div style="text-align: left;">
                    <img style="height: 50px; margin-left: 30px"
                        src="data:image/png;base64,/9j/4AAQSkZJRgABAQEAkACQAAD/4QAiRXhpZgAATU0AKgAAAAgAAQESAAMAAAABAAEAAAAAAAD/4QOBaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPg0KCTxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+DQoJCTxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InV1aWQ6NUQyMDg5MjQ5M0JGREIxMTkxNEE4NTkwRDMxNTA4QzgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NkFBNkI3OTEwRTRBMTFFNzlCRjNEMEM0ODQxNjFFQkUiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NkFBNkI3OTAwRTRBMTFFNzlCRjNEMEM0ODQxNjFFQkUiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4NCgkJCTx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjU1QjBCMDU0MDk2NzExRTdCMDQ5RjlBMzcxQjhDQThBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjU1QjBCMDU1MDk2NzExRTdCMDQ5RjlBMzcxQjhDQThBIi8+DQoJCTwvcmRmOkRlc2Ny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" />
                </div>
            </div>

            <!-- RECAPITULATIF ANNUEL DES FRAIS -->
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div style="text-align: right; margin-bottom: 5px;">
                    <div style="font-size: 20px; font-weight: bold; color: #074623;">RECAPITULATIF ANNUEL DES FRAIS
                    </div>
                    <div><span style="font-size: 18px; color: #074623;">Client </span> <span
                            style="background-color: #e0dcdc; color: black; padding-left: 5px; padding-right: 15px;">{{ $cli }}
                        </span></div>
                </div>
            </div>
        </div>

        <!-- DESTINATAIRE & DEVISE & PERIODE -->
        <div class="row">
            <!-- DESTINATAIRE -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table align-items-center
                        table-flush" style="width: 50%;"
                    align="right">
                    <thead class="thead-light">
                        <tr>
                            <th
                                style="font-size: 20px; text-align: center; background-color: #086c3c; color: aliceblue;">
                                DESTINATAIRE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-bottom: none; font-weight: bold; font-size: 14px;">{{ $titulaire_compte }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none; font-weight: bold; font-size: 14px;">{{ $adresse }}
                            </td>
                        </tr>
                        <tr rowspan="3">
                            <td style="border-bottom: none; font-weight: bold; color: black; font-size: 14px;">
                                {{ $code_agence . '-' . $agence }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- DEVISE -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h5 style="margin-top: 5px; margin-bottom: -15px; text-align: right; font-size: 14px;"><span
                        style="color: #086c3c; font-weight: bold; font-style: italic;">DEVISE DU COMPTE :</span> XOF
                </h5>
            </div>

            <!-- PERIODE -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h5 style="margin-bottom: 5px; text-align: right; font-size: 14px; color: #086c3c; font-weight: bold;">
                    PERIODE DU <span
                        style="background-color: #e0dcdc; color: black; padding-left: 5px; padding-right: 15px;">01/01/{{ $annee }}</span>
                    AU <span
                        style="background-color: #e0dcdc; color: black; padding-left: 5px; padding-right: 15px;">31/12/{{ $annee }}</span>
                </h5>
            </div>
        </div>

        <!-- RELEVE -->
        <div class="row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table align-items-center
                        table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th style="background-color: #086c3c; color: aliceblue;" width="5px">N°</th>
                            <th style="background-color: #086c3c; color: aliceblue;" width="50%">RUBRIQUE</th>
                            <th colspan="2"
                                style="background-color: #086c3c; color: aliceblue; padding-right: 5px; padding-left: 5px; text-align: right;">
                                DEBIT</th>
                            <th style="background-color: #086c3c; color: aliceblue; text-align: right;">CREDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $compteur = 1;
                            $total_debit = 0;
                            $total_credit = 0;
                        @endphp


                        @foreach ($liste_mouvement as $row)
                            <tr>
                                <td style="border-bottom: none; border-right: 1px solid;" width="5px">
                                    {{ $compteur++ }}</td>
                                <td style="border-bottom: none; border-right: 1px solid" width="50%">
                                    {{ $row->libcatgfra }}
                                </td>
                                <td colspan="2"
                                    style="border-bottom: none; border-right: 1px solid; white-space : nowrap; padding-right: 5px; padding-left: 5px; text-align: right;">
                                    @if ($row->mon < 0)
                                        @php
                                            $total_debit = $total_debit + $row->mon * -1;
                                        @endphp
                                        {{ number_format($row->mon * -1, 0, '.', ' ') }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td style="border-bottom: none; border-right: 1px solid; text-align: right;">
                                    @if ($row->mon > 0)
                                        @php
                                            $total_credit = $total_credit + $row->mon;
                                        @endphp
                                        {{ number_format($row->mon * -1, 0, '.', ' ') }}
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"
                                style="border-bottom: none; border-right: 1px solid; text-align: center; font-weight: bold;"
                                width="50%">TOTAL</td>
                            <td colspan="2"
                                style="border-bottom: none; border-right: 1px solid; white-space : nowrap; padding-right: 5px; padding-left: 5px; text-align: right;">
                                {{ number_format($total_debit, 0, '.', ' ') }}
                            </td>
                            <td style="border-bottom: none; border-right: 1px solid; text-align: right;">
                                {{ number_format($total_credit, 0, '.', ' ') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>


</body>

</html>

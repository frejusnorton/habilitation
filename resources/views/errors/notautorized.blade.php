<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.app_name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            color: #333;
            font-family: "Open Sans", sans-serif;
            background-color: rgb(233, 236, 243);
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
            width: 100%;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 30px;
            margin-bottom: 40px;
        }
    </style>

    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" />
</head>

<body>
    <div class="container">
        <div class="content">
            <center>
                <div class="text-danger">
                    <img src="{{ asset('assets/benin2.png') }}" style="display: inline-block;max-height: 100px">
                </div>
                <div class="title">
                    @if (session('typeAnswer'))
                        {{ session('typeAnswer') }}
                    @else
                        Vous n'êtes pas autorisé à utiliser cette application.
                    @endif
                    <br>
                    <a href="{{config('app.portal_url')}}" class="btn btn-primary btn-lg"> Retourner à l'accueil</a>
            </center>

        </div>
    </div>
</body>

</html>

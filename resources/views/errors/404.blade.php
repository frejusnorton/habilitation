<!DOCTYPE html>
<html>
    <head>
        <title>{{config('app.app_name')}}</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{url('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

        <style>
            html, body {
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
                font-family: "Open Sans",sans-serif;
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

        <link rel="shortcut icon" href="{{url('favicon.ico')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <center>
                    <div >
                        <img src="{{url('img/logo.png')}}" style="display: inline-block;max-height: 100px">
                    </div>
                    <div class="title">
                        @if(isset($message) && !empty($message))
                            Erreur :  {!! $message !!}
                        @else
                            Erreur 404 : Page Introuvable <br/>
                        @endif



                        <small style="color: #4c87b9" href="{{url('/')}}"> La page que vous recherchez est introuvable.</small></div>
                    <a href="{{url('/')}}"  class="btn btn-primary btn-lg"> Retourner à l'accueil</a>
                </center>

            </div>
        </div>
    </body>
</html>

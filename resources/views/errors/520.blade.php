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
                font-family: 'Lato';
            }

            .content {
                text-align: center;

            }

            .title {
                font-size: 50px;
                margin-bottom: 40px;
            }
        </style>

        <link rel="shortcut icon" href="{{url('favicon.ico')}}"/>
    </head>
    <body>
        <div class="container-fluid">
            <div class="content">
                <div >
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <img src="{{url('img/logo.png')}}" style="display: inline-block">
                </div>
                <div class="title">
                    <small style="color:red " > <b>Erreur liée à la base de données.</b><br/>
                       <span style="font-size:.8em">Veuillez actualiser la page. Si le problème persiste, contacter le support IT WAMU. </span> </small></div>

            </div>
        </div>
    </body>
</html>

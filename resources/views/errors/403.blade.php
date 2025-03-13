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

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>

        <link rel="shortcut icon" href="{{url('favicon.ico')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div >
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <img src="{{url('img/logo.png')}}" style="display: inline-block">
                    <br/>
                    <br/>
                </div>
                <div class="title">
                    <small style="color:#BFD715; font-size: .6em " href="{{url('/')}}"> Votre navigateur ne vous permettra pas d'utiliser l'application correctement.<br/>
                    Veuillez utilisez une version récente du navigateur CHROME, Opera, ou Mozilla Firefox  </small></br/></br/></br/>


                </div>
                <div class="alert alert-danger" style="font-size: 1.5em">
                    <u>NB</u>: Si vous rencontrez des problèmes, Contacter le support IT ou soumettre votre préoccupation sur la plateforme
                    <a href="https://support.wamu"> Support WAMU</a>. Merci
                </div>


            </div>
        </div>
    </body>
</html>

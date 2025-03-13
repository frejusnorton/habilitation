<!DOCTYPE html>

<html lang="fr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="fr_FR" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>


<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-auto  w-xl-600px positon-xl-relative"
                style="background-color: #0A6535">
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                        <img alt="Logo orabank" src="{{ asset('assets/benin.png') }}" class="h-60px mx-5" />

                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10 text-white mt-10">Gestion des demandes habilitations</h1>
                    </div>
                    <div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                        style="background-image: url(../../assets/media/illustrations/sketchy-1/17.png)">
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-lg-row-fluid py-10">

                <div class="d-flex flex-center flex-column flex-column-fluid">

                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">

                        <form class="form w-100" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Connexion</h1>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="form-label fs-6 fw-bold text-dark">Identifiant</label>
                                <input id="email" type="text"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-10">
                                <label class="form-label fs-6 fw-bold text-dark">Mot de passe</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">
                                        Continue
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                    <div class="d-flex flex-center fw-semibold fs-6">
                        <a href="" class="text-muted text-hover-primary px-2" target="_blank">About</a>
                        <a href="" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
                        <a href="" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>

</body>

</html>

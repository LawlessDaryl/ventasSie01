<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login Ventas SIE</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <style>
        .form-form .form-form-wrap form .field-wrapper a.forgot-pass-link {
    width: 100%;
    font-weight: 700;
    color: #009688 !important;
    text-align: center;
    display: block;
    letter-spacing: 2px;
    font-size: 15px;
    margin-top: 15px;
}
body {
    height: 100%;
    overflow: auto;
    margin: 0;
    padding: 0;
    background: #060818 !important;
}
.form-form .form-form-wrap h1 .brand-name {
    color: #009688 !important;
    font-weight: 600;
}
.form-form .form-form-wrap p.signup-link a {
    color: #009688 !important;
    border-bottom: 1px solid;
}
.form-form .form-form-wrap form .field-wrapper input {
    display: inline-block;
    vertical-align: middle;
    border-radius: 0;
    min-width: 50px;
    max-width: 635px;
    width: 100%;
    min-height: 36px;
    background-color: transparent;
    border: none;
    -ms-transition: all 0.2s ease-in-out 0s;
    transition: all 0.2s ease-in-out 0s;
    color: #009688;
    font-size: 16px;
    border-bottom: 1px solid #191e3a;
    padding: 0px 0 10px 35px !important;
}

    </style>
</head>

<body class="form">


    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Get started with a <br/> free account</h1>
                        <p class="signup-link">Already have an account? <a href="auth_login.html">Log in</a></p>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">


                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">



                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Mostrar Contraseña</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">
                                            {{ __('Login') }}
                                        </button>

                                        {{-- @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif --}}
                                    </div>

                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input type="checkbox" class="new-control-input">
                                            <span class="new-control-indicator"></span>Keep me logged in
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    @if (Route::has('password.request'))
                                        <a href="auth_pass_recovery.html" class="forgot-pass-link">¿Olvidaste tu contraseña?</a>
                                    @endif
                                </div>

                            </div>
                        </form>
                        <p class="terms-conditions">© 2021 Todos los derechos reservados. <a href="index.html">Sie</a> es un producto de soluciones informaticas Emanuel. <a href="javascript:void(0);">Preferencias de cookies</a>, <a href="javascript:void(0);">Privacidad</a>, y <a href="javascript:void(0);">Terminos</a>.</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <img src="assets/img/sie.png" width="650" height="650" style="margin: 50px">
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>

</body>

</html>
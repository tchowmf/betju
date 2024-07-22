<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bet Juuu - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container custom-container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Bem-Vindo ao Bet Juuu!</h1>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @CSRF
                            <!-- Email -->
                            <div class="form-group">
                                <input type="text" id="username" class="form-control form-control-user"
                                    name="username" required placeholder="{{ __('Usuário') }}">

                            <x-input-error :messages="$errors->get('text')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <input type="password" id="password" class="form-control form-control-user"
                                    name="password" required autocomplete placeholder="{{ __('Senha') }}" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember me -->
                            <div class="form-group">
                                <label for="remember_me" class="inline-flex custom-checkbox small items-center">
                                    <input type="checkbox" class="rounded" name="remember_me" id="remember_me">
                                    <span class="ms-2 text-sm">{{ __('Lembre-me') }}</span>
                                <label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                {{ __('Log in') }}
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="/register">{{ __('Create your account') }}</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>

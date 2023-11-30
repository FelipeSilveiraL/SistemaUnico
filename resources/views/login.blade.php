<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sistema Unico - Grupo Servopa</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/public/img/favicon.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('resources/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="d-flex justify-content-center py-4">
                                        <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                                            <span class="d-none d-lg-block"><img
                                                    src="{{ asset('public/img/logo.png') }}" id="logo"></span>
                                        </a>
                                    </div><!-- End Logo -->

                                    <form class="row g-3 needs-validation" method="post"
                                        action="{{ route('login.logar') }}">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bi bi-envelope"></i></span>
                                                <input type="text" name="username" placeholder="E-mail"
                                                    class="form-control" id="yourUsername" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bi bi-lock"></i></span>
                                                <input type="password" name="password" placeholder="Senha"
                                                    class="form-control" id="password" required>
                                            </div>
                                        </div>
                                        @error('error')
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <span style="font-size: 12px"> {{ $message }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                        @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endif
                                        <div class="col-12 py-3">
                                            <button class="btn btn-primary w-100" type="submit">Entrar</button>
                                        </div>
                                        <div class="col-12 text-center">
                                            <p class="small mb-0">Nova conta ou esqueceu a senha</p>
                                            <p class="small mb-0">Basta entrar em contato com o departamento TI</p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>

</html>

<script src="{{ asset('/resources/js/seg.js') }}"></script>

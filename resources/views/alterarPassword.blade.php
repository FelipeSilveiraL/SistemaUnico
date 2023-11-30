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
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Logando em sua conta</h5>
                                    <p class="text-center small">mas antes, altere a sua senha por favor!</p>
                                </div>
                                @auth
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ url('atualizarSenha', ['idPerfil' => auth()->user()->id]) }}">
                                    @endauth
                                    @csrf
                                    <div class="col-12">
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-lock"></i></span>
                                            <input type="password" name="password" placeholder="Senha"
                                                class="form-control" id="password">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="bi bi-lock"></i></span>
                                            <input type="password" name="passwordConfirm" placeholder="Confirmar senha"
                                                onblur="validarSenha('password','passwordConfirm')" class="form-control"
                                                id="passwordConfirm" required>
                                        </div>
                                    </div>
                                    <div class="col-12 py-3">
                                        <button class="btn btn-success w-100" type="submit">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->


    <script>
        function validarSenha(name1, name2) {
            var senha1 = document.getElementById(name1).value;
            var senha2 = document.getElementById(name2).value;

            if (senha1 != senha2) {
                alert('Senhas Diferentes');
                document.getElementById(name2).value = '';
            }
        }
    </script>

</body>

</html>

<script src="{{ asset('/resources/js/seg.js') }}"></script>

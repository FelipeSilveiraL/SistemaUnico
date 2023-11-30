<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

//Tela atual
$currentPath = Request::path();

//Forçando para que o usuario nao acesse qualquer pagina sem antes estar logado no sistema.
if($currentPath != '/'){
    if (!auth()->check()) {
        header('Location: http://'.servidorLocal($_SERVER['SERVER_ADDR']).'/sistemaUnico/');
        die();
    }
}

//usuário que nao for administrador nao poderá acessar as paginas abaixo
if(Auth::user()->admin != 1 ){ $administrador = 'administrador'; }else {$administrador = '';}

//chegando permissão de telas
$telasPermitidas = ['index', 'usuarios', 'editar', 'sistemas'];
$telasComIds = explode('/', $currentPath);

if (permissaoTela(Auth::user()->id, nomeSistema($currentPath)) == false && !in_array($telasComIds[0], $telasPermitidas)) {
    header('Location: http://'.servidorLocal($_SERVER['SERVER_ADDR']).'/sistemaUnico/index');
    die();
}

?>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sistema Unico - Grupo Servopa</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('public/img/favicon.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('resources/css/style.css') }}" rel="stylesheet">

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- mascaras --}}
    <script src="{{ asset('resources/js/mascaras.js') }}"></script>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="javascript:" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">{{ nomeSistema($currentPath) }}</span>
                <img src="{{ asset('public/img/fd_logo.png') }}" alt="">
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->nome }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->nome }}</h6>
                            <span>
                                @if (auth()->user()->admin == 1)
                                Administrador
                                @else
                                Usuário padrão
                                @endif
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                                data-bs-target="#meuPerfil">
                                <i class="bi bi-person"></i>
                                <span>Meu Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('login.destroy') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sair</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    {{-- MODAL PERFIL --}}

    <div class="modal fade" id="meuPerfil" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meu perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Edit Form -->

                    <form action="{{ url('atualizaPerfil', ['idPerfil' => auth()->user()->id]) }}" method="post">
                        @csrf
                        <h5 class="card-title">Principal</h5>
                        <div class="row mb-3">
                            <label for="nomeUsuario" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nomeUsuario" type="text" class="form-control" id="nomeUsuario"
                                    value="{{ auth()->user()->nome }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">E-mail</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" id="email"
                                    value="{{ auth()->user()->email }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cpf" class="col-md-4 col-lg-3 col-form-label">CPF</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="cpf" type="text" class="form-control" id="cpf"
                                    onkeydown="javascript: fMasc( this, mCPF );" maxlength="14"
                                    onblur="ValidarCPF(this)" value=" {{ auth()->user()->cpf }}" required="">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Empresa</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="empresa">
                                    <option value="{{ auth()->user()->empresa }}" selected>
                                        @foreach ($empresaUser as $empresa)
                                        {{ $empresa->nome }}
                                        @endforeach
                                    </option>
                                    <option>--------</option>

                                    @foreach ($empresaAll as $empresaAll)
                                    <option value="{{ $empresaAll->id }}">{{ $empresaAll->nome }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Departamento</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="departamento">
                                    <option value="{{ auth()->user()->depto }}" selected>
                                        @foreach ($departUser as $departamentoUser)
                                        {{ $departamentoUser->nome}}
                                        @endforeach
                                    </option>
                                    <option>--------</option>
                                    @foreach ($departamento as $depto)
                                    <option value="{{ $depto->id }}">{{ $depto->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5 class="card-title">Login</h5>
                        <div class="row mb-3">
                            <label for="usuario" class="col-md-4 col-lg-3 col-form-label">Usuário</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="usuario" type="text" class="form-control" id="usuario"
                                    value="{{ auth()->user()->username }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="senha" class="col-md-4 col-lg-3 col-form-label">Senha</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="senha" type="password" class="form-control" id="senha" value="">
                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form><!-- End Profile Edit Form -->

                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->

    @include(caminhoMenu($currentPath))

    @yield('content')

</body>

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="credits">© Grupo Servopa | 2023</div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS Files -->
<script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('resources/js/formCpf.js') }}"></script>
{{-- <script src="{{ asset('resources/js/seg.js') }}"></script> --}}
<script src="{{ asset('resources/js/buscaCPF.js') }}"></script>
<script src="{{ asset('resources/js/horario.js') }}"></script>
<script src="{{ asset('resources/js/editarNota.js') }}"></script>
<script src="{{ asset('resources/js/buscaFornecedor.js') }}"></script>

<!-- Template Main JS File -->
<script src=" {{ asset('resources/js/main.js') }}"></script>

</html>

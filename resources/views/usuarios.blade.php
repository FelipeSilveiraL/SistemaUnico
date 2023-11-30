<?php
$currentPath = Request::path();
$pagina = explode('/', $currentPath);

//Forçando para que o usuário não acesse qualquer página sem estar logado no sistema.
if ($pagina[0] == 'usuarios') {
    if (auth()->user() && auth()->user()->admin != 1) {
        header('Location: http://' . $_SERVER['SERVER_ADDR'] . '/sistemaUnico/index/');
        exit;
    }
}
?>

@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Lista Usuários</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index') }}">Meus sistemas</a></li>
                <li class="breadcrumb-item">Configurações</li>
                <li class="breadcrumb-item active">Lista usuários</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuários do sistema
                            <button type="button" class="btn btn-success button-rigth-card" data-bs-toggle="modal"
                                data-bs-target="#novousuario">
                                <i class="bi bi-person-plus-fill"></i>
                            </button>
                        </h5>
                        <hr />
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Login</th>
                                    <th scope="col">Depart</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaUsuarios as $usuario)
                                <tr>
                                    <th>{{ $usuario->id }}</th>
                                    <td>{{ $usuario->nome }}</td>
                                    <td>{{ $usuario->username }}</td>
                                    <td>{{ $usuario->nome_departamento }}</td>
                                    <td>{{ buscaNomeEmpresa($usuario->empresa) }}</td>
                                    <td>
                                        <a href="{{ url('editar', ['idUsuario' => $usuario->id]) }}" title="Editar"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if ($usuario->deletar == 0)
                                        <a href="{{ url('ativarDesativar', ['idUsuario' => 'D'.$usuario->id]) }}" title="Desativar" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        @else
                                        <a href="{{ url('ativarDesativar', ['idUsuario' => 'A'.$usuario->id]) }}" title="Ativar" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-square"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL ADICIONAR NOVO USUARIO --}}
    <div class="modal fade" id="novousuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ url('inserirUsuario') }}" method="POST">
                                            @csrf
                                            <h5 class="card-title">Formulario de cadastro</h5>
                                            <div class="row mb-3">
                                                <label for="nomeUsuario"
                                                    class="col-md-4 col-lg-3 col-form-label">Nome:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="nomeUsuario" type="text" class="form-control"
                                                        id="nomeUsuario" value="">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="email"
                                                    class="col-md-4 col-lg-3 col-form-label">E-mail:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="email"
                                                        value="">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="cpf" class="col-md-4 col-lg-3 col-form-label">CPF:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="cpf" type="text" class="form-control" id="cpf"
                                                        onkeydown="javascript: fMasc( this, mCPF );" maxlength="14"
                                                        onblur="ValidarCPF(this)" value="" required="">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label"
                                                    style="margin-right: 51px;">Empresa:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="empresa">
                                                        <option>--------</option>
                                                        @foreach ($empresaAll as $empresa)
                                                        <option value="{{ $empresa->id_empresa}}">{{ $empresa->nome_empresa }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label"
                                                    style="margin-right: 51px;">Departamento:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="departamento">
                                                        <option>--------</option>
                                                        @foreach ($departamento as $depto)
                                                        <option value="{{ $depto->id }}">{{ $depto->nome }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Login</h5>
                                            <div class="row mb-3">
                                                <label for="usuario"
                                                    class="col-md-4 col-lg-3 col-form-label">Usuário:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="usuario" type="text" class="form-control" id="usuario"
                                                        value="">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="senha"
                                                    class="col-md-4 col-lg-3 col-form-label">Senha:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="senha" type="password" class="form-control" id="senha"
                                                        value="">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Trocar senha ao
                                                    logar:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="TrocarSenha" name="trocarSenha">
                                                        <label class="form-check-label" for="TrocarSenha"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3"
                                                style="display: {{ auth()->user()->admin == 1 ? 'flex' : 'none' }};">
                                                <label class="col-md-4 col-lg-3 col-form-label">Administrador:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="admin" name="admin">
                                                        <label class="form-check-label"
                                                            for="admin"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="card-title">Outras informações</h5>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Sistemas
                                                    permitidos:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    @foreach ($buscaSistema as $sistema)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $sistema->id }}" id="gridCheck{{ $sistema->id }}"
                                                            name="sistemas[]">
                                                        <label class="form-check-label"
                                                            for="gridCheck{{ $sistema->id }}">
                                                            {{ $sistema->nome }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Voltar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->


</main><!-- End #main -->

@endsection

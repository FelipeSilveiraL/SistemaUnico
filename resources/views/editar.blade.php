<?php
$currentPath = Request::path();
$pagina = explode('/', $currentPath);

//Forçando para que o usuário não acesse qualquer página sem estar logado no sistema.
if ($pagina[0] == 'editar') {
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
        <h1>Editando usuário</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index') }}">Meus sistemas</a></li>
                <li class="breadcrumb-item">Configurações</li>
                <li class="breadcrumb-item"><a href="{{ url('usuarios') }}">Lista usuários</a></li>
                <li class="breadcrumb-item">Editar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        @foreach ($buscaUsuario as $usuario)
                        <form action="{{ url('inserirUsuario', ['idUsuario' => request('idUsuario')]) }}" method="post">
                            @csrf
                            <h5 class="card-title">Principal</h5>
                            <div class="row mb-3">
                                <label for="nomeUsuario" class="col-md-4 col-lg-3 col-form-label">Nome:</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nomeUsuario" type="text" class="form-control" id="nomeUsuario"
                                        value="{{ $usuario->nome }}">
                                </div>
                            </div>

                            <div class=" row mb-3">
                                <label for="email" class="col-md-4 col-lg-3 col-form-label">E-mail:</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="email" type="email" class="form-control" id="email"
                                        value="{{ $usuario->email }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="cpf" class="col-md-4 col-lg-3 col-form-label">CPF:</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="cpf" type="text" class="form-control" id="cpf"
                                        onkeydown="javascript: fMasc( this, mCPF );" maxlength="14"
                                        onblur="ValidarCPF(this)" value="{{ $usuario->cpf  }}" required="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" style="margin-right: 72px;">Empresa:</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="empresa">
                                        <option value="{{ $usuario->empresa}}">{{ buscaNomeEmpresa($usuario->empresa) }}</option>
                                        <option>--------</option>
                                        @foreach ($empresaAll as $empresa)
                                        <option value="{{ $empresa->id_empresa}}">{{ $empresa->nome_empresa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" style="margin-right: 72px;">Departamento:</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="departamento">
                                        <option value="{{ $usuario->depto }}">{{ $usuario->nome_departamento }}</option>
                                        <option>--------</option>
                                        @foreach ($departamento as $departamentoEmp )
                                        <option value="{{ $departamentoEmp->id }}">{{ $departamentoEmp->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h5 class="card-title">Login</h5>
                            <div class="row mb-3">
                                <label for="usuario" class="col-md-4 col-lg-3 col-form-label">Usuário:</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="usuario" type="text" class="form-control" id="usuario"
                                        value="{{ $usuario->username }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="senha" class="col-md-4 col-lg-3 col-form-label">Senha:</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="senha" type="password" class="form-control" id="senha" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Trocar senha ao logar:</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="trocarSenha"
                                            name="trocarSenha">
                                        <label class="form-check-label" for="trocarSenha"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Administrador:</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="admin" name="admin"
                                            {{$usuario->admin != 1 ?: 'checked' }}>
                                        <label class="form-check-label" for="admin"></label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="card-title">Outras informações</h5>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Sistemas permitidos:</label>
                                <div class="col-md-8 col-lg-9">
                                    @foreach ($buscaSistemas as $sistemas)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $sistemas->id }}"  id="gridCheck{{ $sistemas->id }}" name="sistemas[]"
                                        @foreach ($buscaSistemasUser as $sistemaUser)
                                            @if ($sistemas->id == $sistemaUser->id)
                                            checked
                                            @endif
                                        @endforeach
                                        >
                                        <label class="form-check-label" for="gridCheck{{ $sistemas->id }}">
                                            {{ $sistemas->nome }}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('usuarios') }}" class="btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@endsection

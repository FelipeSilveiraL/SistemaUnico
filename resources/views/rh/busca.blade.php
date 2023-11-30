@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Busca CPF</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('rh/index') }}">Home</a></li>
                <li class="breadcrumb-item">busca CPF</li>
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

            {{-- FORMULARIO DE BUSCA --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Localizando funcionário na base de dados RH</h5><br>

                        <!-- Horizontal Form -->
                        <form method="post" action="{{ url('rh/buscaColaborador') }}">
                            @csrf
                            <fieldset class="row mb-10 pt-2">
                                <legend class="col-form-label col-sm-5 pt-2">Buscar por:</legend>
                                <div class="col-sm-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="busca" id="gridRadios1"
                                            value="1" onclick="escolheNome()">
                                        <label class="form-check-label" for="gridRadios1">
                                            Nome
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="busca" id="gridRadios2"
                                            value="2" onclick="escolheCpf()">
                                        <label class="form-check-label" for="gridRadios2">
                                            CPF
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <hr><br>
                            <div class="col-md-8" id="nomeFuncionario" style="display: none;">
                                <label for="inputName5" class="form-label">Nome Completo:</label>
                                <input type="text" class="form-control" id="inputNome" name="nomeCompleto"
                                    style="text-transform: uppercase;">
                            </div>
                            <div class="col-md-5" id="cpfFuncionario" style="display: none;">
                                <label for="inputName5" class="form-label">CPF:</label>
                                <input name="cpf" type="text" class="form-control" id="inputCpf"
                                    onkeydown="javascript: fMasc( this, mCPF );" maxlength="14"
                                    onblur="ValidarCPF(this)">
                            </div>

                            <div class="text-center" style="margin-top: 25px; margin-bottom: 10px;">
                                <button type="submit" class="btn btn-success" id="localizar" disabled>Localizar <i
                                        class="bi bi-search"></i></button>
                            </div>
                        </form><!-- End Horizontal Form -->

                    </div>
                </div>
            </div>

            {{-- TABELA RESULTADO BUSCA --}}
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dados do colaborador</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col" class="capitalize">Nome Completo</th>
                                    <th scope="col" class="capitalize">CPF sem formatação</th>
                                    <th scope="col" class="capitalize">CPF com formatação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($buscaCpf))
                                @foreach ($buscaCpf as $resultado)
                                <tr>
                                    <td>{{ $resultado->nomfun }}</td>
                                    <td>{{ limparCPF($resultado->numcpf) }}</td>
                                    <td>{{ $resultado->numcpf }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>


</main><!-- End #main -->
@endsection

@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Excluir Fluxo Finalizado</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('contabilidade/index') }}">Home</a></li>
                <li class="breadcrumb-item">Excluir Fluxo Finalizado</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Não foi possivel prosseguir com a solicitação</h4>
        <p>Infelizmente houve algum erro que não deixou prosseguir. Abaixo segue uma lista de possíveis erros:</p>
        <hr>
        <p class="mb-0"><i class="bi bi-pin"></i>{{ session('error') }}</p>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="section">
        <div class="row">
            {{-- LOCALIZANDO O FLUXO --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Localizando um fluxo dentro do SmartShare para realizar a limpeza.</h5>
                        <br>
                        <!-- Horizontal Form -->
                        <form method="POST" action="{{ url('contabilidade/localizarFluxo') }}">
                            @csrf
                            <div class="col-md-6" id="nomeFuncionario">
                                <label for="inputName5" class="form-label">Número do fluxo:</label>
                                <input type="number" class="form-control" name="numeroSolicitacao">
                            </div>

                            <div class="text-center buttom_search">
                                <button type="submit" class="btn btn-success" id="localizar">
                                     <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form><!-- End Horizontal Form -->

                    </div>
                </div>
            </div>

            {{-- TABELA CONTANTO LOG DE EXCLUSÃO --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista das ultimas execuções</h5><br>

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col" class="capitalize">USUÁRIO</th>
                                    <th scope="col" class="capitalize">DATA</th>
                                    <th scope="col" class="capitalize">Nº FLUXO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaLogUsuario as $logUsuario)
                                <tr>
                                    <td>{{ $logUsuario->nome }}</td>
                                    <td>{{ $logUsuario->data }}</td>
                                    <td>{{ $logUsuario->numero_fluxo }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </section>

</main><!-- End #main -->
@endsection

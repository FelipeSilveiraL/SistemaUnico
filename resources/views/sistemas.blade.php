@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sistemas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index') }}">Meus sistemas</a></li>
                <li class="breadcrumb-item">Configuração</li>
                <li class="breadcrumb-item active">Sistemas</li>
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
                        <h5 class="card-title">Tabelas sistemas
                            <a href="#" class="btn btn-success button-rigth-card" title="Novo Sistema"
                                data-bs-toggle="modal" data-bs-target="#novoSistema">
                                <i class="bi bi-plus"></i>
                            </a>
                        </h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaSistemas as $sistemas)
                                <tr>
                                    <th scope="row">{{ $sistemas->id }}</th>
                                    <td>{{ $sistemas->nome }}</td>
                                    <td>{{ $sistemas->endereco }}</td>
                                    <td>
                                        <a href="{{ url('excluirSistema', ['idSistema' => $sistemas->id]) }}" title="Excluir" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
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
    <div class="modal fade" id="novoSistema" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ url('inserirSistema') }}" method="post">
                                            @csrf
                                            <h5 class="card-title">Formulario de cadastro</h5>
                                            <div class="row mb-3">
                                                <label for="nome" class="col-md-4 col-lg-3 col-form-label">Nome:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="nome" type="text" class="form-control" id="nome"
                                                        value="">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="endereco"
                                                    class="col-md-4 col-lg-3 col-form-label">Endereço:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="endereco" type="text" class="form-control"
                                                        id="endereco" value="">
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

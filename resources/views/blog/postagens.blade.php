@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Minhas Postagens</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('blog/index') }}">Home</a></li>
                <li class="breadcrumb-item">Minhas postagens</li>
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
                        <h5 class="card-title">Postagens</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col" class="capitalize">ID</th>
                                    <th scope="col" class="capitalize">Titulo</th>
                                    <th scope="col" class="capitalize">Data Postagem</th>
                                    <th scope="col" class="capitalize">Data exclusão</th>
                                    <th scope="col" class="capitalize">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogPost as $postagens)
                                <tr>
                                    <th scope="row">{{ $postagens->id_postagem }}</th>
                                    <td>{{ $postagens->titulo }}</td>
                                    <td>{{ $postagens->data }}</td>
                                    <td>{{ $postagens->data_drop }}</td>
                                    <td>
                                        <a href="{{ url('blog/mensagem', ['idPostagem' => $postagens->id_postagem]) }}"
                                            title="Vizualizar" class="btn-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if ($postagens->deletar == 0)
                                        <a href="{{ url('blog/update', ['idPostagem' => 'D'.$postagens->id_postagem]) }}"
                                            title="Desativar" class="btn-warning btn-sm">
                                            <i class="bi bi-slash-circle"></i>
                                        </a>
                                        @else
                                        <a href="{{ url('blog/update', ['idPostagem' => 'A'.$postagens->id_postagem]) }}"
                                            title="Ativar" class="btn-success btn-sm">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                        @endif

                                        <a href="{{ url('blog/update', ['idPostagem' => 'E'.$postagens->id_postagem]) }}"
                                            title="Excluir" class="btn-danger btn-sm">
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

</main><!-- End #main -->
@endsection

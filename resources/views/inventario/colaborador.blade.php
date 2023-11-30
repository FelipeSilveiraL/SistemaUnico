@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Colaboradores</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="{{ url('inventario/index') }}">Home</a></li>
                <li class="breadcrumb-item active">Colaboradores</li>
            </ol>
        </nav>
    </div><!-- End Navegação -->

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section>

        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title"> Lista colaboradores</span> </h5>
                        <table class="table-sm table table-hover datatable">
                            <thead>
                                <tr class="capitalize">
                                    <th scope="col">ID</th>
                                    <th scope="col">nome</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Função</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">empresa</th>
                                    <th scope="col">status</th>
                                    <th scope="col" class="text-right">ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaColaborador as $colaborador)

                                <tr>
                                    <td>{{ $colaborador['id_funcionario'] }}</td>
                                    <td>{{ $colaborador['nome'] }}</td>
                                    <td>{{ $colaborador['cpf'] }}</td>
                                    <td>{{ $colaborador['funcao'] }}</td>
                                    <td>{{ $colaborador['departamento'] }}</td>
                                    <td>{{ $colaborador['empresa'] }}</td>
                                    <td>{{ $colaborador['status'] }}</td>

                                    <td class="td-actions text-right">
                                        {{-- EDITAR --}}
                                        <a href="#" title="Editar" class="btn btn-success btn-just-icon btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- MODAL --}}
                                        <a href="#" title="Check-List" class="btn btn-warning btn-just-icon btn-sm">
                                            <i class="bi bi-journal-text"></i>
                                        </a>
                                        {{-- EXCLUIR --}}
                                        <a href="#" title="Termo" class="btn btn-info btn-just-icon btn-sm">
                                            <i class="bi bi-file-earmark"></i>
                                        </a>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </div>

    </section>

</main><!-- End #main -->

@endsection

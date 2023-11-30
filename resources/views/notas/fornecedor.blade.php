@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Fornecedores</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('notas/index') }}">Home</a></li>
                <li class="breadcrumb-item ">Cadastros</li>
                <li class="breadcrumb-item active">Fornecedor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section>
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Lista Fornecedores Rateados
                            <a href="{{ url('notas/reateioFornecedor') }}" class="btn btn-success button-rigth-espelho"
                                style="margin-top: -3px;">
                                <i class="bx bxs-plus-square"></i>
                            </a>
                        </h5>

                        <table class="table-sm table table-hover datatable">
                            <thead>
                                <tr class="capitalize">
                                    <th scope="col">CNPJ&emsp;</th>
                                    <th scope="col">FORNECEDOR&emsp;</th>
                                    <th scope="col">FILIAL&emsp;</th>
                                    <th scope="col">OBSERVAÇÃO&emsp;</th>
                                    <th scope="col" class="text-right">ação&emsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaFornecedor as $fornecedor)
                                <tr>
                                    <td>{{ $fornecedor['cpfcnpj_fornecedor'] }}</td>
                                    <td>{{ $fornecedor['fornecedor'] }} </td>
                                    <td>{{ buscaNomeEmpresa($fornecedor['ID_FILIAL']) }} </td>
                                    <td>{{ $fornecedor['observacao'] }} </td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('notas/editarFornecedor', ['idFornecedor' => $fornecedor['ID_RATEIOFORNECEDOR']]) }}"
                                            title="Editar" class="btn btn-primary btn-just-icon btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ url('notas/deletarFornecedor', ['idFornecedor' => $fornecedor['ID_RATEIOFORNECEDOR']]) }}"
                                            title="Desativar" class="btn btn-danger btn-just-icon btn-sm">
                                            <i class="bi bi-trash"></i>
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

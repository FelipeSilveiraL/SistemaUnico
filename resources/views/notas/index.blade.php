@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Home</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('notas/index') }}">Home</a></li>
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

            @foreach ($queryStatus['statusCounts'] as $status => $quantidade )
            <?php $statusInfo = layoutContador($status); ?>
            <div class="col-lg-3 py-2">
                <a href="{{ url('notas/index', ['dadosTabelaStatus' => $status]) }}" class="list-group-item-action"
                    title="Mostrar notas com este status">
                    <div class="alert {{ $statusInfo['cor'] }} alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">{{ $statusInfo['nome'] }}</h4>
                        <hr>
                        <p class="mb-0">Total: {{ $quantidade }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach

            @foreach ($queryStatus['statusCountsError'] as $status => $quantidadeError )
            <?php $statusInfo = layoutContador($status); ?>
            <div class="col-lg-3 py-2">
                <a href="{{ url('notas/index', ['dadosTabelaStatus' => 'error']) }}" class="list-group-item-action"
                    title="Mostrar notas com este status">
                    <div class="alert {{ $statusInfo['cor'] }} alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">{{ $statusInfo['nome'] }}</h4>
                        <hr>
                        <p class="mb-0">Total: {{ $quantidadeError }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title"> Notas fiscais <span>| {{ mesAtualAbreviado() }}</span> </h5>
                        <table class="table-sm table table-hover datatable">
                            <thead>
                                <tr class="capitalize">
                                    <th scope="col">ID</th>
                                    <th scope="col">empresa</th>
                                    <th scope="col">fornecedor</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">valor</th>
                                    <th scope="col">emissao</th>
                                    <th scope="col">vencimento</th>

                                    @if ($dadosTabelaStatus === 'error')
                                    <th scope="col">smartShare</th>
                                    <th scope="col">status</th>
                                    @endif

                                    <th scope="col" class="text-right">ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dadosNotas as $notas)
                                <tr>
                                    <td>{{ $notas['id_lancarnotas'] }}</td>
                                    <td>{{ $notas['nome_empresa'] }}</td>
                                    <td>{{ $notas['fornecedor'] }}</td>
                                    <td>{{ $notas['numero_nota'] }}</td>
                                    <td>R$ {{ $notas['valor_nota'] }}</td>
                                    <td>{{ $notas['emissao'] }}</td>
                                    <td>{{ $notas['vencimento'] }}</td>

                                    @if ($dadosTabelaStatus === 'error')
                                    <td>{{ $notas['smartShare'] }}</td>
                                    <td>{{ $notas['status'] }}</td>
                                    @endif

                                    <td class="td-actions text-right">
                                        {{-- MODAL --}}
                                        <a href="javascript:" title="Anexos"
                                            class="btn btn-success btn-just-icon btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#smallModal{{ $notas['id_lancarnotas'] }}"><i
                                                class="bi bi-file-earmark-pdf"></i></a>
                                        {{-- EDITAR --}}
                                        <a href="{{ url('notas/editar', ['idNota' => $notas['id_lancarnotas']]) }}" title="Editar" class="btn btn-primary btn-just-icon btn-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        {{-- EXCLUIR --}}
                                        <a href="{{ url('notas/deletar', ['idNota' => $notas['id_lancarnotas']]) }}" title="Excluir" class="btn btn-danger btn-just-icon btn-sm"><i
                                                class="bi bi-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- Small Modal-->
                                <div class="modal fade" id="smallModal{{ $notas['id_lancarnotas'] }}" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nota Fiscal: {{ $notas['numero_nota'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                $documento = pegarAnexos($notas['id_lancarnotas']);
                                                @endphp

                                                <p>
                                                    <code><u>Nota Fiscal:</u></code>
                                                    <br />

                                                    @if (count($documento['notas']) > 0)
                                                        @foreach ($documento['notas'] as $nota)
                                                        <a href="{{ asset('public/notas/'.$nota) }}" target="_blank">{{ nomeNota($nota) }}</a>
                                                        @endforeach
                                                    @else
                                                        Nenhuma nota fiscal encontrada.
                                                    @endif
                                                </p>

                                                <p>
                                                    <code><u>Boleto:</u></code>
                                                    <br />
                                                    @if (count($documento['boletos']) > 0)
                                                        @foreach ($documento['boletos'] as $boleto)
                                                            <a href="{{ asset('public/notas/'.$boleto) }}" target="_blank">{{ nomeBoleto($boleto) }}</a>
                                                        @endforeach
                                                    @else
                                                        Nenhum boleto encontrado.
                                                    @endif
                                                </p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Small Modal-->

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

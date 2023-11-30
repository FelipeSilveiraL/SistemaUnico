@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Cadastro - Bloqueio Bancos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index') }}">Home</a></li>
                <li class="breadcrumb-item active">Cadastro - Bloqueio Bancos</li>
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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro/Bloqueio bancos</h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="cadastro" data-bs-toggle="tab"
                                    data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Cadastro bancos</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="#" data-bs-toggle="tab"
                                    data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">
                                    Bloqueio bancos
                                </button>
                            </li>
                        </ul> <!-- End of default Tabs -->

                        <div class="tab-content pt-2" id="myTabjustifiedContent">

                            <!-- Cadastro bloqueio de bancos -->
                            <div class="tab-pane fade active show" id="home-justified" role="tabpanel"
                                aria-labelledby="cadastro">
                                <div class="card">

                                    <div class="card-header">
                                        <a href="#" class="btn btn-success button-rigth-card" data-bs-toggle="modal"
                                            data-bs-target="#basicModal" title="Cadastrar banco para bloqueio">
                                            <i class="bx bxs-file-plus"></i>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Bancos cadastrados</h5>
                                        <table class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="capitalize">Empresa</th>
                                                    <th scope="col" class="capitalize">Código banco</th>
                                                    <th scope="col" class="capitalize">Nome banco</th>
                                                    <th scope="col" class="capitalize">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($buscaBancosCadastrados as $bancos)
                                                <tr>
                                                    <td>{{ $bancos->nome_empresa }}</td>
                                                    <td>{{ $bancos->codigo_banco }}</td>
                                                    <td>{{ $bancos->nome_banco }}</td>
                                                    <td>
                                                        <a href="{{ url('contabilidade/deletar', ['idBanco' => $bancos->id]) }}"
                                                            title="Excluir" class="btn-danger btn-sm"> <i
                                                                class="bi bi-trash"></i> </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <!-- Efetuar bloqueio bancos APOLLO-->
                            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="lista">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Atualizar data bloqueio bancos Apollo</h5>

                                        <!-- No Labels Form -->
                                        <form class="row g-3" action="{{ url('bloquearDataBanco') }}" method="POST">
                                            @csrf
                                            <div class="col-md-4">
                                                <label for="data">Data:<span style="color: red;">*</span></label>
                                                <input type="date" class="form-control" name="date" id="date"
                                                    onblur="verificaData()" required>
                                                <input type="text" style="display: none;" name="idUsuario"
                                                    id="idUsuario" value="{{ auth()->user()->id }}">
                                            </div>
                                            <div class="col-md-8">
                                                <label for="Empresa">Empresa/Banco:<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" name="empresaBanco" id="empresaBanco"
                                                    required>
                                                    <option value="" selected="">Selecione...</option>
                                                    @foreach ($buscaBancosCadastrados as $bancos)
                                                    <option value="{{ $bancos->empresa_apollo }}-{{ $bancos->revenda_apollo }}-{{ $bancos->codigo_banco }}">{{
                                                        $bancos->nome_empresa }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success">Atualizar</button>
                                            </div>
                                        </form><!-- End No Labels Form -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->


<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModallLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="basicModallLabel"></h5>
            </div>

            <div class="modal-body">
                <form class="row g-3" action="{{ url('salvarBanco') }}" method="POST" id="formBuscaNomeEmpresa">
                    @csrf
                    <div class="col-md-6">
                        <label for="Empresa">Empresa:</label>
                        <select class="form-select" name="empresaRev" id="empresa" required>
                            <option value="" selected="">Selecione...</option>
                            @foreach ($buscaEmpresa as $empresa)
                            <option value="{{ $empresa->nome_empresa }}">{{ $empresa->nome_empresa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Banco">Código banco:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="banco" id="pequisaBanco"
                                placeholder="Pesquisar...">
                            <div class="input-group-append">
                                <button class="btn btn-primary button_ajust" id="botao" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Nome só aparece se o banco exister na empresa -->
                    <div class="col-md-12" id="nomeBancoDiv">
                        <label for="Banco">Nome banco:</label>
                        <div class="input-group">
                            <input type="text" id="nomeBanco" name="nomeBanco" class="form-control" value="" readonly>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" id="salvarBanco" class="btn btn-success">Cadastrar Banco</button>
                    </div>
                </form><!-- End No Labels Form -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>
<!--End basic Modal -->

<script>
    $(document).ready(function() {

      $('#salvarBanco').hide();
      $('#limparBanco').hide();
      $('#nomeBancoDiv').hide();

      $('#botao').click(function() {

        var banco = $('#pequisaBanco').val();
        var empresa = $('#empresa').val();

        $.ajax({
            type: "POST",
            url: '{{ url("buscaNome") }}',
            data: {
                empresaRev: empresa,
                banco: banco,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#nomeBanco').val(data.nomeBanco);
                $('#pequisaBanco').val(banco);
                $('#nomeBanco').prop('required', true);
                $('#nomeBancoDiv').show();
                $('#salvarBanco').show();
            },
            error: function (data, textStatus, errorThrown) {
                $('#pequisaBanco').val('Nada encontrado');
            },
        });

      });
    });

</script>

@endsection

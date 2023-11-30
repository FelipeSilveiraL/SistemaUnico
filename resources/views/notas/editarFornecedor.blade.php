@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Editar Fornecedor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('notas/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('notas/fornecedor') }}">Fornecedor</a></li>
                <li class="breadcrumb-item active">Editar rateio fornecedor</li>
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

    @foreach ($buscaFornecedor as $fornecedor)
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3"
                            action="{{ url('notas/updateFornecedor', ['idFornecedor' => $idFornecedor]) }}"
                            method="POST">
                            @csrf
                            <!--DADOS PRINCIPAIS -->
                            <h5 class="card-title mt-3">Dados Principais</h5>

                            <div class="form-floating mb-3 col-md-6">
                                <input type="text" class="form-control" value="{{ auth()->user()->nome }}" readonly>
                                <input type="text" class="form-control" id="idUsuario" name="usuarioResponsavel"
                                    value="{{ auth()->user()->id }}" style="display: none;">
                                <label for="floatingSelect" class="capitalize">Usuario responsável </label>
                            </div>

                            <div id="divFilial" class="form-floating mb-3 col-md-6">
                                <select class="form-select" id="selectFilial" name="filial" required>
                                    <option value="{{ $fornecedor['ID_FILIAL'] }}">{{
                                        buscaNomeEmpresa($fornecedor['ID_FILIAL']) }}</option>
                                    <option value="">-----------------</option>
                                    @foreach ($buscaEmpresa as $empresa)
                                    <option value="{{ $empresa['id_empresa'] }}">{{ $empresa['nome_empresa'] }}</option>
                                    @endforeach
                                </select>
                                <label for="selectFilial">Filial <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <span class="text-danger small pt-1 fw-bold" style="font-size: 12px;"><i
                                    class="bi bi-pin-fill"></i>Caso não esteja encontrando a FILIAL, abra um chamado no
                                <a href="http://<?= $_SERVER['SERVER_ADDR'] ?>/glpi/front/ticket.form.php"
                                    target="_blank">GLPI</a> ao departamento <b>SmartShare</b></span>

                            <h5 class="card-title mt-3">Dados Fornecedor</h5>

                            <div id="divFornecedor" class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cnpjVet" maxlength="15"
                                        placeholder="CNPJ / CPF Fornecedor" name="cpfCnpjFor"
                                        value="{{ $fornecedor['cpfcnpj_fornecedor'] }}">
                                    <label for="cpfCnpjFor">CNPJ / CPF Fornecedor <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <div id="divNomeFornecedor" class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="NomeFornecedor"
                                        value="{{ $fornecedor['fornecedor'] }}" placeholder="Fornecedor"
                                        name="NomeFornecedor" maxlength="100" readonly>
                                    <label for="NomeFornecedor">Nome fornecedor <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <span class="text-danger small pt-1 fw-bold" style="font-size: 12px;"><i
                                    class="bi bi-pin-fill"></i>Caso não esteja encontrando o FORNECEDOR, abra um chamado
                                no <a href="http://<?= $_SERVER['SERVER_ADDR'] ?>/glpi/front/ticket.form.php"
                                    target="_blank">GLPI</a> ao departamento <b>SmartShare</b></span>

                            <!--DADOS DO PAGAMENTOL -->
                            <h5 class="card-title mt-3">Dados Pagamento</h5>

                            <div class="form-floating mb-3 col-md-12">
                                <select class="form-select" id="tipoPagamento" name="tipoPagamento" onchange="bancos()"
                                    required>
                                    {!! tipoPagamento($fornecedor['ID_TIPOPAGAMENTO']) !!}
                                    <option value="">-----------------</option>
                                    <option value="1">Boleto</option>
                                    <option value="2">Depósito Bancário</option>
                                </select>
                                <label for="floatingSelect">Tipo pagamento <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="row" id="tipopagamentoBancos"
                                style="display: {{ $fornecedor['ID_TIPOPAGAMENTO'] == 2 ? 'contents' : 'none'}}">
                                @php
                                $meusBancos = bancos($fornecedor['CPFCNPJ_FORNECEDOR'], $fornecedor['ID_USUARIO'],
                                $fornecedor['ID_FILIAL']);
                                @endphp
                                <div class="form-floating mb-3 col-md-5">
                                    <select class="form-select" id="nomeBanco" name="banco">
                                        <option value="">{{ $meusBancos['nome_banco'] }}</option>
                                        <option value="">-----------------</option>
                                        @foreach ($buscaBanco as $bancos)
                                        <option value="{{ $bancos['banco'] }}">{{ $bancos['banco'] }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Banco <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numAgencia"
                                            value="{{ $meusBancos['agencia'] }}" name="agencia" maxlength="45">
                                        <label for="floatingName">Agência <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numConta"
                                            value="{{ $meusBancos['conta'] }}" name="conta" maxlength="45">
                                        <label for="floatingName">Conta <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numDigito"
                                            value="{{ $meusBancos['digito'] }}" name="digito" maxlength="1">
                                        <label for="floatingName">Dígito <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>

                            </div>


                            <h5 class="card-title mt-3">Dados Nota Fiscal</h5>

                            <div class="form-floating col-md-6">
                                <select class="form-select" id="tipoDespesaSelect" name="tipodespesa">
                                    <option value="{{ $fornecedor['ID_PERIODICIDADE'] }}">{{
                                        periodicidade($fornecedor['ID_PERIODICIDADE']) }}</option>
                                    <option value="">-----------------</option>
                                    <option value="1">AVULSA</option>
                                    <option value="5">ANUAL</option>
                                    <option value="7">AVULSA FUNILARIA</option>
                                    <option value="3">BIMESTRAL</option>
                                    <option value="2">MENSAL</option>
                                    <option value="4">SEMESTRAL</option>
                                    <option value="6">TRIAGEM</option>
                                </select>
                                <label for="tipoDespesaSelect">Tipo de Despesa <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div id="divNomeFornecedor" class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefone"
                                        onkeypress="mask(this, mphone);" onblur="mask(this, mphone);"
                                        title="Caso seja nota de telefonia" name="telefone"
                                        value="{{ $fornecedor['telefone'] }}">
                                    <label for="telefone">Telefone</label>
                                </div>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="departamentoAuditoria" name="departamentoAuditoria">
                                    {!! departamentosNota($fornecedor['auditoria']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="departamentoAuditoria">Depart. de Auditoria? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasGrupoObra" name="notasGrupo">
                                    {!! departamentosNota($fornecedor['obra']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasGrupoObra">Obras do G. Servopa? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasMarketing" name="notasMarketing">
                                    {!! departamentosNota($fornecedor['marketing']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Depart. de Marketing? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasCSC" name="notasCSC">
                                    {!! departamentosNota($fornecedor['csc']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento CSC? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>


                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasTI" name="notasTI">
                                    {!! departamentosNota($fornecedor['ti']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento TI? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasRH" name="notasRH">
                                    {!! departamentosNota($fornecedor['rh']) !!}
                                    <option value="">-----------------</option>
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento RH? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating col-md-6">
                                <select class="form-select" id="vencimento" name="vencimento"
                                    onchange="tipoVencimento()" required="">
                                    {!! tipoVencimento($fornecedor['vencimento_tipo']) !!}
                                    <option value="">-----------------</option>
                                    <option value="1">Nota Fiscal</option>
                                    <option value="2">Somatório</option>
                                    <option value="3">Fixo</option>
                                </select>
                                <label for="vencimento">Vencimento <span class="text-danger small pt-1 fw-bold"> *
                                    </span></label>
                            </div>

                            <div class="col-md-6" id="diasCorridos"
                                style="display: {{ $fornecedor['vencimento_tipo'] == 2 ? 'block' : 'none'}};">
                                <div class="form-floating">
                                    <input type="text" class="form-control" maxlength="3" name="diasCorridos"
                                        id="inputDiascorridos" value="{{ $fornecedor['vencimento'] }}">
                                    <label for="diasCorridos">Dias Corridos <span
                                            class="text-danger small pt-1 fw-bold"> * </span></label>
                                </div>
                            </div>

                            <div class="col-md-6" id="dias"
                                style="display: {{ $fornecedor['vencimento_tipo'] == 3 ? 'block' : 'none'}};">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="diasInput" maxlength="2" name="dias"
                                        onblur="diasMaximos()" value="{{ $fornecedor['vencimento'] }}">
                                    <label for="dias">Dia <span class="text-danger small pt-1 fw-bold"> *
                                        </span></label>
                                </div>
                            </div>

                            <span class="text-danger small pt-1 fw-bold" style="font-size: 12px;"><i
                                    class="bi bi-pin-fill"></i>Duvidas sobre o campo VENCIMENTO <a href="javascript:"
                                    data-bs-toggle="modal" data-bs-target="#largeModal"> clique aqui </i></a></span>

                            <hr>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Address" id="informacoes"
                                        style="height: 100px;"
                                        name="informacoes">{{ $fornecedor['informacoes_adicionais'] }}</textarea>
                                    <label for="informacoes">Informações adicionais <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <div class="col-12" id="teste">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Address" id="observacao"
                                        style="height: 100px;"
                                        name="observacao">{{ $fornecedor['observacao'] }}</textarea>
                                    <label for="observacao">Observação <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>
                            <hr>

                            <!--DADOS DO RATEIO -->
                            <h5 class="card-title">Rateio Departamentos</h5>

                            <div class="form-floating col-md-6 divFornecedor" id="centroCusto" style="display: block">
                                <select class="form-select" id="floatingSelect" name="centroCusto">
                                    <option value="n">-----------------</option>
                                    {!! buscaDepartamentoCusto($fornecedor['ID_FILIAL']) !!}
                                </select>
                                <label for="floatingSelect">Centro de custo</label>
                            </div>

                            <div class="col-md-5 divFornecedor" style="display: block">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="porcentual" id="porcentual"
                                        oninput="validarPorcentual(this)">
                                    <label for="cpfCnpjFor">Porcentual %</label>
                                </div>
                            </div>

                            <div class="top_margin col-md-1 divFornecedor" style="display: block">
                                <div class="form-floating">
                                    <button type="submit" class="btn btn-success btn-custo">
                                        <div class="icon">
                                            <i class="bx bxs-plus-square"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>


                            <div class="card" id="rateioFornecedor">
                                <h5 class="card-title">Tabela centro de custo</h5>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Centro de Custo</th>
                                                <th scope="col">% Rateio</th>
                                                <th scope="col">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $somando = 0;
                                            @endphp

                                            @if ($buscaRateioCusto->isEmpty())
                                            <tr>
                                                <td colspan="3">Nenhum dado encontrado</td>
                                            </tr>
                                            @else

                                            @foreach ($buscaRateioCusto as $rateioCusto)
                                            <tr>
                                                <td>{!! buscaNome($rateioCusto['ID_CENTROCUSTO_BPM']) !!}</td>
                                                <td>{{ $rateioCusto['percentual'] }}</td>
                                                <td>
                                                    <a href="{{ url('notas/excluirCentroCusto', ['idCentroCusto' => $rateioCusto['ID_RATEIOCENTROCUSTO']]) }}" title="Excluir" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            @php
                                            $somando += $rateioCusto['percentual']
                                            @endphp

                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                    <span class="text-danger small pt-1 fw-bold"> Total: {{ $somando }} % </span>
                                </div>
                            </div>

                            <hr>

                            <!-- BOTÃO DO FORMULARIOS -->
                            <div class="text-center py-5">
                                <hr>
                                <a href="{{ url('notas/fornecedor') }}" class="btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-success" id="enviarNota">Editar</button>
                            </div>
                        </form><!-- FIM Form -->
                    </div><!-- FIM card-body -->
                </div><!-- FIM card -->
            </div><!-- FIM col-lg-12 -->
        </div>
    </section>
    @endforeach


    <script>
        //FORNECEDOR
        $("#cnpjVet").on("blur", function() {

            var cnpj = $("#cnpjVet").val();

            $.ajax({

                url: '{{ url("notas/buscaFornecedor") }}',
                type: 'POST',
                data: {
                    cnpj: cnpj,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(data) {

                    if (data.fornecedor !== null) {

                        $("#NomeFornecedor").val(data.fornecedor);

                    } else {
                        // Trate o caso em que nenhum fornecedor foi encontrado, por exemplo, exiba uma mensagem de erro.
                        $("#NomeFornecedor").val("Fornecedor não encontrado");
                        $("#enviarNota").attr("disabled", true);
                    }
                },

            });

        });

    </script>

    @if ($scroll)

    <script>
        $(document).ready(function () {
            $('html, body').animate({
                scrollTop: $('#centroCusto').offset().top
            }, 'slow');
        });

    </script>

    @endif

</main><!-- End #main -->
@endsection

{{-- MODAIS --}}
<div class="modal fade" id="largeModal" tabindex="-1">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vencimento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h5><u>Nota Fiscal:</u></h5>
                <p><code> Lançamento Manual:</code> <span style="font-size: 15px;">Você irá informar o vencimento que
                        esta vindo da nota fiscal</span></p>
                <p><code> Lançamento Robô:</code> <span style="font-size: 15px;">Robo irá pegar o valor de vencimento
                        que esta vindo da nota fiscal </span></p>


                <h5><u>Somatório:</u></h5>
                <p><code> Ambos:</code> <span style="font-size: 15px;">Será coletado a informação que esta no campo
                        "DIAS CORRIDOS" e somar com a data de Emissão da nota fiscal.</span></p>
                <p><span style="font-size: 15px;"><code>Exemplo: </code>você informou 10 dias corridos e hoje é dia
                        10/12/2022 então o vencimento será dia 20/12/2022</span></p>

                <h5><u>Fixo:</u></h5>
                <p><code> Ambos:</code> <span style="font-size: 15px;">Será coletado a informação que esta no campo
                        "DIA" e esse será o dia do vencimento da nota fiscal, agora o mes e o ano é de acordo com o mes
                        e o ano que esta sendo lançado.</span></p>
                <p><span style="font-size: 15px;"><code>Exemplo:</code> se vc informou dia fixo 10 e estamos em dezembro
                        de 2022 então a data de vencimento será 10/12/2022</span></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Editar Nota Fiscal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('notas/index') }}">Home</a></li>
                <li class="breadcrumb-item active">Lançar nota fiscal</li>
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
                        <form class="row g-3" action="{{ url('notas/lancar') }}" method="POST" enctype="multipart/form-data">
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
                                        placeholder="CNPJ / CPF Fornecedor" name="cpfCnpjFor" value="">
                                    <label for="cpfCnpjFor">CNPJ / CPF Fornecedor <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <div id="divNomeFornecedor" class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="NomeFornecedor" value=""
                                        placeholder="Fornecedor" name="NomeFornecedor" maxlength="100" readonly>
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
                                    <option value="">-----------------</option>
                                    <option value="1">Boleto</option>
                                    <option value="2">Depósito Bancário</option>
                                </select>
                                <label for="floatingSelect">Tipo pagamento <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="row" id="tipopagamentoBancos" style="display: none">

                                <div class="form-floating mb-3 col-md-5">
                                    <select class="form-select" id="nomeBanco" name="banco">
                                        <option value="id_banco">nomeBanco</option>
                                    </select>
                                    <label for="floatingSelect">Banco <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numAgencia" value="" name="agencia"
                                            maxlength="45" readonly>
                                        <label for="floatingName">Agência <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numConta" value="" name="conta"
                                            maxlength="45" readonly>
                                        <label for="floatingName">Conta <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numDigito" value="" name="digito"
                                            maxlength="1" readonly>
                                        <label for="floatingName">Dígito <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>

                            </div>


                            <h5 class="card-title mt-3">Dados Nota Fiscal</h5>

                            <div class="form-floating col-md-6">
                                <select class="form-select" id="tipoDespesaSelect" name="tipodespesa">
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
                                        title="Caso seja nota de telefonia" name="telefone" readonly>
                                    <label for="telefone">Telefone</label>
                                </div>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="departamentoAuditoria" name="departamentoAuditoria">

                                </select>
                                <label for="departamentoAuditoria">Depart. de Auditoria? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasGrupoObra" name="notasGrupo">

                                </select>
                                <label for="notasGrupoObra">Obras do G. Servopa? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasMarketing" name="notasMarketing">

                                </select>
                                <label for="notasMarketing">Depart. de Marketing? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasCSC" name="notasCSC">

                                </select>
                                <label for="notasMarketing">Departamento CSC? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>


                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasTI" name="notasTI">

                                </select>
                                <label for="notasMarketing">Departamento TI? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasRH" name="notasRH">

                                </select>
                                <label for="notasMarketing">Departamento RH? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="mb-3 form-floating col-md-4">
                                <input type="text" class="form-control" name="numeroNota" value="" required>
                                <label for="numeroNota">Número Nota <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating col-md-4">
                                <input type="text" class="form-control uppercase" name="serie" value="" required>
                                <label for="serie">Série <span class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>
                            <div class="form-floating col-md-4">
                                <input type="text" class="form-control dinheiro"
                                    onKeyPress="return(moeda(this,'.',',',event))" value="" name="valor" id="valorNota"
                                    maxlength="12">
                                <label for="valor">Valor <span class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="date" class="form-control" name="emissao" value="" required>
                                <label for="emissao">Emissão <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="date" class="form-control" name="vencimento" value="" required>
                                <label for="vencimento">Vencimento <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="col-md-12 mb-3 mt-4">
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="carimbar">
                                        <label class="form-check-label" for="carimbar">Carimbar pelo Robô!</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Address" id="informacoes"
                                        style="height: 100px;" name="informacoes"></textarea>
                                    <label for="informacoes">Informações adicionais <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Address" id="observacao"
                                        style="height: 100px;" name="observacao" readonly></textarea>
                                    <label for="observacao">Observação <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>
                            <hr>

                            <h5 class="card-title mt-3">Anexar novo documento</h5>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Nota fiscal</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile" name="filenota">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Boleto</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile" name="fileboleto">
                                </div>
                            </div>

                            <hr>

                            <div class="card mb-6" id="rateioFornecedor">
                                <h5 class="card-title mt-3">Tabela centro de custo</h5>
                                <div class="card-body">
                                    <table class="table table-bordered" id="tableCusto">
                                        <thead>
                                            <tr>
                                                <th scope="col">Centro de Custo</th>
                                                <th scope="col">% Rateio</th>
                                                <th scope="col">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- BOTÃO DO FORMULARIOS -->
                            <div class="text-center py-5">
                                <hr>
                                <a href="{{ url('notas/index') }}" class="btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-success" id="enviarNota">Salvar</button>
                            </div>
                        </form><!-- FIM Form -->
                    </div><!-- FIM card-body -->
                </div><!-- FIM card -->
            </div><!-- FIM col-lg-12 -->
        </div>
    </section>

    <script>
        //CENTRO DE CUSTO
        $("#valorNota").on("blur", function() {

            var cpfCNPJ = $("#cnpjVet").val();
            var nomefilial = $("#selectFilial").val();
            var valorNota = $("#valorNota").val();
            var valorObservacao = $("#observacao").html();
            var InfoAdd = $("#informacoes").html();
            var idUsuario = $("#idUsuario").val();

            $.ajax({

                url: '{{ url("notas/TabelaCentroCusto") }}',
                type: 'POST',
                data: {
                    idFilial: nomefilial,
                    cnpjFornecedor: cpfCNPJ,
                    valor: valorNota,
                    informacoesAdicionais: InfoAdd,
                    idUsuario: idUsuario,
                    Observacao: valorObservacao,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(data) {

                    $("#tableCusto").empty();
                    $("#tableCusto").empty(data);
                    $("#tableCusto").append(data);
                }

            })
        });


        //FORNECEDOR
        $("#cnpjVet").on("blur", function() {

            var cnpj = $("#cnpjVet").val();
            var nomefilial = $("#selectFilial").val();
            var idUsuario = $("#idUsuario").val();

            $.ajax({

                url: '{{ url("notas/buscaFornecedor") }}',
                type: 'POST',
                data: {
                    idFilial: nomefilial,
                    cnpj: cnpj,
                    idUsuario: idUsuario,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(data) {

                    if (data.fornecedor !== null) {
                        $("#NomeFornecedor").val(data.fornecedor);

                        //DEMAIS INFORMAÇÕES DO FORMULARIO

                        //tipoPagamento
                        $("#tipoPagamento").html(data.tipoPagamento);

                        if(data.tipoPagamento == '<option value="2">Depósito Bancário</option>'){

                            $('#tipopagamentoBancos').show();
                            //dados bancarios
                            $("#nomeBanco").html('<option value="'+data.nomeBanco+'">'+data.nomeBanco+'</option>');
                            $("#numAgencia").val(data.agencia);
                            $("#numConta").val(data.conta);
                            $("#numDigito").val(data.digito);
                        }else{
                            $('#tipopagamentoBancos').hide();
                        }

                        //tipo de despesa
                        $("#tipoDespesaSelect").html('<option value="'+data.tipoDespesaID+'">'+data.tipoDespesaName+'</option>');

                        //telefone
                        $("#telefone").val(data.telefone);

                        //auditoria
                        $("#departamentoAuditoria").html(data.auditoria);

                        //obra
                        $("#notasGrupoObra").html(data.obra);

                        //markting
                        $("#notasMarketing").html(data.marketing);

                        //csc
                        $("#notasCSC").html(data.csc);

                        //ti
                        $("#notasTI").html(data.ti);

                        //rh
                        $("#notasRH").html(data.rh);

                        //observacao
                        $("#observacao").html(data.observacao);

                    } else {
                        // Trate o caso em que nenhum fornecedor foi encontrado, por exemplo, exiba uma mensagem de erro.
                        $("#NomeFornecedor").val("Fornecedor não encontrado");
                        $("#enviarNota").attr("disabled", true);
                    }
                },

            });

        });

    </script>

</main><!-- End #main -->

@endsection

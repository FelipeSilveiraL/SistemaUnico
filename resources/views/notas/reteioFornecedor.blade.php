@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Rateio Fornecedor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('notas/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('notas/fornecedor') }}">Fornecedor</a></li>
                <li class="breadcrumb-item active">Rateio Fornecedor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3" action="{{ url('notas/salvarFornecedor') }}" method="POST">
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
                                    <input type="text" class="form-control" id="cnpjVet_ADD" maxlength="15"
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
                                        <input type="text" class="form-control" id="numAgencia" value="" name="agencia"
                                            maxlength="45" >
                                        <label for="floatingName">Agência <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numConta" value="" name="conta"
                                            maxlength="45" >
                                        <label for="floatingName">Conta <span
                                                class="text-danger small pt-1 fw-bold">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numDigito" value="" name="digito"
                                            maxlength="1" >
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
                                        title="Caso seja nota de telefonia" name="telefone" >
                                    <label for="telefone">Telefone</label>
                                </div>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="departamentoAuditoria" name="departamentoAuditoria">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="departamentoAuditoria">Depart. de Auditoria? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasGrupoObra" name="notasGrupo">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasGrupoObra">Obras do G. Servopa? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasMarketing" name="notasMarketing">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Depart. de Marketing? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasCSC" name="notasCSC">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento CSC? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>


                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasTI" name="notasTI">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento TI? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating mb-3 col-md-4">
                                <select class="form-select" id="notasRH" name="notasRH">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                                <label for="notasMarketing">Departamento RH? <span
                                        class="text-danger small pt-1 fw-bold">*</span></label>
                            </div>

                            <div class="form-floating col-md-6">
                                <select class="form-select" id="vencimento" name="vencimento" onchange="tipoVencimento()" required="">
                                  <option value="">-----------------</option>
                                  <option value="1">Nota Fiscal</option>
                                  <option value="2">Somatório</option>
                                  <option value="3">Fixo</option>
                                </select>
                                <label for="vencimento">Vencimento <span class="text-danger small pt-1 fw-bold"> * </span></label>
                              </div>

                              <div class="col-md-6" id="diasCorridos" style="display: none;">
                                <div class="form-floating">
                                  <input type="text" class="form-control" maxlength="3" name="diasCorridos" id="inputDiascorridos">
                                  <label for="diasCorridos">Dias Corridos <span class="text-danger small pt-1 fw-bold"> * </span></label>
                                </div>
                              </div>

                              <div class="col-md-6" id="dias" style="display: none;">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="diasInput" maxlength="2" name="dias" onblur="diasMaximos()">
                                  <label for="dias">Dia <span class="text-danger small pt-1 fw-bold"> * </span></label>
                                </div>
                              </div>

                              <span class="text-danger small pt-1 fw-bold" style="font-size: 12px;"><i class="bi bi-pin-fill"></i>Duvidas sobre o campo VENCIMENTO <a href="javascript:" data-bs-toggle="modal" data-bs-target="#largeModal"> clique aqui </i></a></span>

                            <hr>

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
                                        style="height: 100px;" name="observacao" ></textarea>
                                    <label for="observacao">Observação <span
                                            class="text-danger small pt-1 fw-bold">*</span></label>
                                </div>
                            </div>

                            <!-- BOTÃO DO FORMULARIOS -->
                            <div class="text-center py-5">
                                <hr>
                                <a href="{{ url('notas/fornecedor') }}" class="btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-success" id="enviarNota">Continuar, casdastrar centro de custo</button>
                            </div>
                        </form><!-- FIM Form -->
                    </div><!-- FIM card-body -->
                </div><!-- FIM card -->
            </div><!-- FIM col-lg-12 -->
        </div>
    </section>
    <script>

        //FORNECEDOR
        $("#cnpjVet_ADD").on("blur", function() {

            var cnpj = $("#cnpjVet_ADD").val();

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
          <p><code> Lançamento Manual:</code> <span style="font-size: 15px;">Você irá informar o vencimento que esta vindo da nota fiscal</span></p>
          <p><code> Lançamento Robô:</code> <span style="font-size: 15px;">Robo irá pegar o valor de vencimento que esta vindo da nota fiscal </span></p>


          <h5><u>Somatório:</u></h5>
          <p><code> Ambos:</code> <span style="font-size: 15px;">Será coletado a informação que esta no campo "DIAS CORRIDOS" e somar com a data de Emissão da nota fiscal.</span></p>
          <p><span style="font-size: 15px;"><code>Exemplo: </code>você informou 10 dias corridos e hoje é dia 10/12/2022 então o vencimento será dia 20/12/2022</span></p>

          <h5><u>Fixo:</u></h5>
          <p><code> Ambos:</code> <span style="font-size: 15px;">Será coletado a informação que esta no campo "DIA" e esse será o dia do vencimento da nota fiscal, agora o mes e o ano é de acordo com o mes e o ano que esta sendo lançado.</span></p>
          <p><span style="font-size: 15px;"><code>Exemplo:</code> se vc informou dia fixo 10 e estamos em dezembro de 2022 então a data de vencimento será 10/12/2022</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->

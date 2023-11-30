<?php

namespace App\Http\Controllers\notas;

use App\Http\Controllers\contabilidade\querys\QueryEmpresa;
use App\Http\Controllers\Controller;
use App\Http\Controllers\notas\querys\QueryBancos;
use App\Http\Controllers\notas\querys\QueryCadBancos;
use App\Http\Controllers\notas\querys\QueryCadFornecedor;
use App\Http\Controllers\notas\querys\QueryCadLancarNotas;
use App\Models\notas\TabelaCadAnexo;
use App\Models\notas\TabelaCadLancarNotas;
use App\Http\Controllers\notas\querys\QueryCadRateioCentroCusto;
use App\Http\Controllers\notas\querys\QueryCadRateioFornecedor;
use App\Http\Controllers\notas\querys\QueryFatCliente;
use App\Http\Controllers\unico\querys\QueryUsuarios;
use App\Models\notas\TabelaCadRateioCentroCusto;
use App\Models\notas\TabelaCadRateioFornecedor;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index($dadosTabelaStatus = 1)
    {

        $queryCadLancarNotas = new QueryCadLancarNotas();

        //STATUS NOTAS
        $idStatus = [1, 2, 3];
        $queryStatus = $queryCadLancarNotas->statusNotas($idStatus, auth()->user()->id, 0);

        //DADOS DA TABELA
        $dadosNotas = $queryCadLancarNotas->notas($dadosTabelaStatus, auth()->user()->id, 0);


        return view('notas.index', compact('queryStatus', 'dadosNotas', 'dadosTabelaStatus'));
    }

    public function editar($idNota = null)
    {
        if ($idNota == null) {

            return $this->index();
        } else {

            //buscando dados da notas fiscal
            $queryNota = new QueryCadLancarNotas;
            $dadosNotas = $queryNota->dadosNotas($idNota);

            //pegando a filial da nota fiscal
            $queryEmpresa = new QueryEmpresa;
            $dadosEmpresa = $queryEmpresa->buscaEmpresa($idEmpresa = null, $cnpjFilial = null);

            foreach ($dadosNotas as $notas) {

                //pegando os dados do banco da nota fiscal
                $bancos = bancos($notas['CNPJ'], $notas['ID_USUARIO'], $notas['ID_FILIAL']);

                //pegando os dados do rateio
                $queryRateio = new QueryCadRateioCentroCusto;
                $dadosRateio = $queryRateio->buscaRateio($notas['ID_FILIAL'], $notas['CNPJ'], $notas['informacoes_adicionais'], $notas['ID_USUARIO'], $notas['observacao']);
            }

            if (empty($bancos)) {
                return $this->index();
            } else {
                return view('notas.editar', compact('dadosNotas', 'dadosEmpresa', 'bancos', 'dadosRateio'));
            }
        }
    }

    public function editarSalvar(Request $request, $idNota)
    {

        //SALVAR DADOS DA NOTA
        $salvar = TabelaCadLancarNotas::where('ID_LANCARNOTAS', $idNota)->firstOrFail();
        $salvar->id_filial = $request->filial;
        $salvar->cnpj = $request->cpfCnpjFor;
        $salvar->nome_fornecedor = $request->NomeFornecedor;
        $salvar->numero_nota = $request->numeroNota;
        $salvar->serie_nota = strtoupper($request->serie);
        $salvar->valor_nota = str_replace('R$ ', '', $request->valor);
        $salvar->emissao = date('d/m/Y', strtotime($request->emissao));
        $salvar->vencimento = date('d/m/Y', strtotime($request->vencimento));
        $salvar->carimbar = $request->carimbar ? 1 : 0;
        $salvar->status_desc = 1;
        $salvar->save();

        // SALVAR NOTA
        if ($request->hasFile('filenota')) {

            $file = $request->file('filenota');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/notas'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNota;
            $salvarAnexo->url_nota = '../documentos/notas/' . $fileName;
            $salvarAnexo->save();
        }

        // SALVAR BOLETO
        if ($request->hasFile('fileboleto')) {

            $file = $request->file('fileboleto');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/boletos'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNota;
            $salvarAnexo->url_nota = '../documentos/boletos/' . $fileName;
            $salvarAnexo->save();
        }

        return redirect()->back()->with('success', 'Nota editada com sucesso');
    }

    public function deletarDocumento($id)
    {


        if ($id == null) {
            $this->index();
        } else {
            $caminho = TabelaCadAnexo::select('url_nota')->where('ID', $id)->first();
            $urlNota = substr($caminho['url_nota'], 3);

            TabelaCadAnexo::where('ID', $id)->delete();
            unlink(public_path('notas/' . $urlNota));
        }

        return redirect()->back()->with('success', 'Documento deletado');
    }

    public function montarCentroCusto(Request $request)
    {
        $queryRateio = new QueryCadRateioCentroCusto;
        $dados = $queryRateio->buscaRateio($request->idFilial, $request->cnpjFornecedor, $request->informacoesAdicionais, $request->idUsuario, $request->Observacao);

        $tabela = '<table class="table table-bordered" id="tableCusto">
                        <thead>
                            <tr>
                                <th scope="col">Centro de Custo</th>
                                <th scope="col">% Rateio</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($dados as $rateio) {

            $porcentagem = porcentagem($rateio->porcento);

            $valorCalculado = porcentagem_nx(valorMonetario($request->valor), $porcentagem);

            $tabela  .= '<tr>';
            $tabela .= '<td>' . buscaNome($rateio->centrocusto) . '</td>';
            $tabela .= '<td>' . $porcentagem . '%</td>';
            $tabela .= '<td>R$ ' . number_format($valorCalculado, 2, ',', '.') . '</td>';
            $tabela .= '</tr>';
        }

        $tabela .= '</tbody></table>';

        return $tabela;
    }

    public function deletarNota($idNota = null)
    {

        if ($idNota == null) {
            return $this->index();
        } else {

            $excluir = TabelaCadLancarNotas::where('ID_LANCARNOTAS', $idNota)->firstOrFail();
            $excluir->deletar = 1;
            $excluir->save();

            return redirect()->back()->with('success', 'Nota deleteda com sucesso');
        }
    }

    public function lancarNota()
    {
        $queryEmpresa = new QueryEmpresa;
        $buscaEmpresa = $queryEmpresa->buscaEmpresa($idEmpresa = null, $cnpjFilial = null);

        return view('notas.lancar', compact('buscaEmpresa'));
    }

    public function buscaFornecedor(Request $request)
    {
        $queryFornecedor = new QueryFatCliente;
        $fornecedor = $queryFornecedor->buscaNomeCliente($request->cnpj);

        if ($fornecedor) {
            $nomeFornecedor = $fornecedor[0]->xnome_empresa;

            //buscar as demais informações da notafiscal
            $queryNotaFiscal = new QueryCadRateioFornecedor;
            $buscaNota = $queryNotaFiscal->buscaRateioFornecedor($request->idFilial, $request->cnpj, $request->idUsuario);

            //dados bancarios quando o tipo de pagamento for deposito
            $queryBanco =  new QueryCadBancos;
            $buscaDadosBanco = $queryBanco->buscaBanco($request->cnpj, $request->idUsuario, $request->idFilial);
        }

        return [
            'fornecedor' => $nomeFornecedor,
            'telefone' => $buscaNota['telefone'],
            'tipoPagamento' => tipoPagamento($buscaNota['tipo_pagamento']),
            'nomeBanco' => $buscaDadosBanco['nome_banco'],
            'agencia' => $buscaDadosBanco['agencia'],
            'conta' => $buscaDadosBanco['conta'],
            'digito' => $buscaDadosBanco['digito'],
            'tipoDespesaName' => periodicidade($buscaNota['id_periodicidade']),
            'tipoDespesaID' => $buscaNota['id_periodicidade'],
            'auditoria' => departamentosNota($buscaNota['auditoria']),
            'obra' => departamentosNota($buscaNota['obra']),
            'marketing' => departamentosNota($buscaNota['marketing']),
            'csc' => departamentosNota($buscaNota['csc']),
            'ti' => departamentosNota($buscaNota['ti']),
            'rh' => departamentosNota($buscaNota['rh']),
            'observacao' => $buscaNota['observacao']
        ];
    }

    public function salvarNotaFiscal(Request $request)
    {

        $inserindoNota = new TabelaCadLancarNotas();

        $inserindoNota->ID_FILIAL = $request->filial;
        $inserindoNota->ID_USUARIO = $request->usuarioResponsavel;
        $inserindoNota->ID_TIPOPAGAMENTO = $request->tipoPagamento;
        $inserindoNota->ID_PERIODICIDADE = $request->tipodespesa;
        $inserindoNota->nome_fornecedor = $request->NomeFornecedor;
        $inserindoNota->CNPJ = $request->cpfCnpjFor;
        $inserindoNota->auditoria = $request->departamentoAuditoria;
        $inserindoNota->obra = $request->notasGrupo;
        $inserindoNota->marketing = $request->notasMarketing;
        $inserindoNota->observacao = $request->observacao;
        $inserindoNota->numero_nota = $request->numeroNota;
        $inserindoNota->serie_nota = strtoupper($request->serie);
        $inserindoNota->emissao = date('d/m/Y', strtotime($request->emissao));
        $inserindoNota->vencimento = date('d/m/Y', strtotime($request->vencimento));
        $inserindoNota->valor_nota = valorMonetario($request->valor);
        $inserindoNota->status_desc = 1;
        $inserindoNota->date_create = date('Y-m-d');
        $inserindoNota->telefone = $request->telefone;
        $inserindoNota->carimbar = $request->carimbar ? 1 : 0;
        $inserindoNota->sistema = 2;
        $inserindoNota->informacoes_adicionais = $request->informacoes ? $request->informacoes : NULL;
        $inserindoNota->ti = $request->notasTI;
        $inserindoNota->csc = $request->notasCSC;
        $inserindoNota->rh = $request->notasRH;
        $inserindoNota->deletar = 0;
        $inserindoNota->save();

        $idNotaFiscal = $inserindoNota->ID_LANCARNOTAS;

        // SALVAR NOTA
        if ($request->hasFile('filenota')) {

            $file = $request->file('filenota');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/notas'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNotaFiscal;
            $salvarAnexo->url_nota = '../documentos/notas/' . $fileName;
            $salvarAnexo->save();
        }

        // SALVAR BOLETO
        if ($request->hasFile('fileboleto')) {

            $file = $request->file('fileboleto');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/boletos'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNotaFiscal;
            $salvarAnexo->url_nota = '../documentos/boletos/' . $fileName;
            $salvarAnexo->save();
        }

        return redirect()->back()->with('success', 'Criado com sucesso!');
    }

    public function fornecedor()
    {

        $queryFornecedor = new QueryCadFornecedor;

        $buscaFornecedor = $queryFornecedor->buscaFornecedor(auth()->user()->id);

        return view('notas.fornecedor', compact('buscaFornecedor'));
    }

    public function reateioFornecedor()
    {

        $queryEmpresa = new QueryEmpresa;
        $buscaEmpresa = $queryEmpresa->buscaEmpresa($idEmpresa = null, $cnpjFilial = null);

        $queryBanco = new QueryBancos;
        $buscaBanco = $queryBanco->buscaBancos();

        return view('notas.reteioFornecedor', compact('buscaEmpresa', 'buscaBanco'));
    }

    public function salvarFornecedor(Request $request)
    {
        if (!empty($request->dias)) {
            $dias = $request->dias;
        } elseif (!empty($request->diasCorridos)) {
            $dias =  $request->diasCorridos;
        } else {
            $dias = 0;
        }

        $inserindoFor = new TabelaCadRateioFornecedor();
        $inserindoFor->ID_USUARIO = $request->usuarioResponsavel;
        $inserindoFor->ID_FILIAL = $request->filial;
        $inserindoFor->ID_TIPOPAGAMENTO = $request->tipoPagamento;
        $inserindoFor->ID_PERIODICIDADE = $request->tipodespesa;
        $inserindoFor->auditoria = $request->departamentoAuditoria;
        $inserindoFor->ti = $request->notasTI;
        $inserindoFor->csc = $request->notasCSC;
        $inserindoFor->rh = $request->notasRH;
        $inserindoFor->obra = $request->notasGrupo;
        $inserindoFor->observacao = $request->observacao;
        $inserindoFor->vencimento = $dias;
        $inserindoFor->vencimento_tipo = $request->vencimento;
        $inserindoFor->telefone = $request->telefone;
        $inserindoFor->fornecedor = $request->NomeFornecedor;
        $inserindoFor->cpfcnpj_fornecedor = $request->cpfCnpjFor;
        $inserindoFor->marketing = $request->notasMarketing;
        $inserindoFor->sistema = 2;
        $inserindoFor->informacoes_adicionais = $request->informacoes ? $request->informacoes : NULL;
        $inserindoFor->save();

        $idFornecedor = $inserindoFor->ID_RATEIOFORNECEDOR;
        $scroll = true;

        return redirect()->route('editarFornecedor', ['idFornecedor' => $idFornecedor, 'scroll' => $scroll]);
    }

    public function editarFornecedor($idFornecedor, $scroll = NULL)
    {

        $queryEmpresa = new QueryEmpresa;
        $buscaEmpresa = $queryEmpresa->buscaEmpresa($idEmpresa = null, $cnpjFilial = null);

        $queryBanco = new QueryBancos;
        $buscaBanco = $queryBanco->buscaBancos();

        $queryFornecedor = new QueryCadFornecedor;
        $buscaFornecedor = $queryFornecedor->buscaFornecedorID($idFornecedor);

        $queryRateioCusto = new QueryCadRateioCentroCusto;
        $buscaRateioCusto = $queryRateioCusto->buscaRateioID($idFornecedor);

        return view('notas.editarFornecedor', compact('buscaRateioCusto', 'buscaFornecedor', 'scroll', 'idFornecedor', 'buscaEmpresa', 'buscaBanco'));
    }

    public function updateFornecedor(Request $request, $idFornecedor)
    {
        if (!empty($request->dias)) {
            $dias = $request->dias;
        } elseif (!empty($request->diasCorridos)) {
            $dias =  $request->diasCorridos;
        } else {
            $dias = 0;
        }

        $alterFor = TabelaCadRateioFornecedor::where('ID_RATEIOFORNECEDOR', $idFornecedor)->firstOrFail();
        $alterFor->ID_USUARIO = $request->usuarioResponsavel;
        $alterFor->ID_FILIAL = $request->filial;
        $alterFor->ID_TIPOPAGAMENTO = $request->tipoPagamento;
        $alterFor->ID_PERIODICIDADE = $request->tipodespesa;
        $alterFor->AUDITORIA = $request->departamentoAuditoria;
        $alterFor->TI = $request->notasTI;
        $alterFor->CSC = $request->notasCSC;
        $alterFor->RH = $request->notasRH;
        $alterFor->OBRA = $request->notasGrupo;
        $alterFor->OBSERVACAO = $request->observacao;
        $alterFor->VENCIMENTO = $dias;
        $alterFor->VENCIMENTO_TIPO = $request->vencimento;
        $alterFor->TELEFONE = $request->telefone;
        $alterFor->FORNECEDOR = $request->NomeFornecedor;
        $alterFor->CPFCNPJ_FORNECEDOR = $request->cpfCnpjFor;
        $alterFor->MARKETING = $request->notasMarketing;
        $alterFor->SISTEMA = 2;
        $alterFor->informacoes_adicionais = $request->informacoes ? $request->informacoes : NULL;
        $alterFor->save();

        //CENTRO DE CUSTO

        if ($request->centroCusto !== 'n') {

            $queryCentroCusto = new QueryCadRateioCentroCusto;
            $buscaCentro = $queryCentroCusto->verificandoJaPossui($request->centroCusto, $idFornecedor);
            $contagem = 0;

            if ($buscaCentro->isEmpty()) {

                if ($request->porcentual == null) {

                    return redirect()->back()->with('error', 'Por favor, informar um valor válido ao campo "Porcentual %"');
                } else {

                    $queryContagem = new QueryCadRateioCentroCusto;
                    $buscaContagem = $queryContagem->buscaRateioID($idFornecedor);

                    foreach ($buscaContagem as $centroCusto) {
                        $contagem += $centroCusto['percentual'];
                    }

                    $total = $request->porcentual + $contagem;

                    if ($total > 100) {

                        return redirect()->back()->with('error', 'Seu valor já esta em 100% ou irá ficar superior a isso, favor validar!');
                    } else {

                        $salvarCentroCusto = new TabelaCadRateioCentroCusto();
                        $salvarCentroCusto->ID_RATEIOFORNECEDOR = $idFornecedor;
                        $salvarCentroCusto->ID_CENTROCUSTO_BPM = $request->centroCusto;
                        $salvarCentroCusto->percentual = $request->porcentual;
                        $salvarCentroCusto->deletar = 0;
                        $salvarCentroCusto->save();
                    }
                }
            } else {

                return redirect()->back()->with('error', 'Departamento já foi cadastrado');
            }
        }

        return redirect()->back()->with('success', 'Alteração realizada com sucesso!');
    }

    public function excluirCentroCusto($idCentroCusto)
    {
        $excluir = TabelaCadRateioCentroCusto::where('ID_RATEIOCENTROCUSTO', $idCentroCusto)->delete();

        return redirect()->back()->with('success', 'Centro de custo deletado com sucesso');
    }

    public function excluirFornecedor($idFornecedor)
    {
        $excluir = TabelaCadRateioFornecedor::where('ID_RATEIOFORNECEDOR', $idFornecedor)->delete();

        return redirect()->back()->with('success', 'Fornecedr deletado com sucesso');
    }

    public function carimbo($ia, $fornecedor, $filial, $email)
    {

        $queryRateio = new QueryCadRateioCentroCusto;
        $buscaRateio = $queryRateio->carimbo($ia, $fornecedor, $filial, $email);

        return view('notas.carimbar', compact('buscaRateio'));
    }

    public function lancarNotaRobo($serie, $cnpjFornecedor, $usuario, $numeroNota, $dataEmissao, $dataVencimento, $valorNota, $cnpjFilial)
    {

        return view('notas.roboLancarNota', compact('serie', 'cnpjFornecedor', 'usuario', 'numeroNota', 'dataEmissao', 'dataVencimento', 'valorNota', 'cnpjFilial'));
    }

    public function salvarNotasRobo(Request $request)
    {

        //PEGANDO ID FILIAL
        $queryEmpresa = new QueryEmpresa;
        $dadosFilial = $queryEmpresa->buscaEmpresa($idEmpresa = null, $request->cnpjFilial);

        $idFilial = $dadosFilial[0]->id_empresa;

        //PEGANDO O ID USUARIO
        $queryUsuarios = new QueryUsuarios;
        $usuario = $queryUsuarios->buscaUsuario($request->usuario);

        $idUsuario = $usuario[0]->id;

        //PEGANDO AS DEMAIS INFORMAÇÔES DO FORNECEDOR
        $queryFornecedor = new QueryCadRateioFornecedor;
        $dadosFornecedor = $queryFornecedor->buscaRateioFornecedor($idFilial, $request->cnpjFornecedor, $idUsuario);

        $inserindoNota = new TabelaCadLancarNotas();

        $inserindoNota->ID_FILIAL = $idFilial;
        $inserindoNota->ID_USUARIO = $idUsuario;
        $inserindoNota->ID_TIPOPAGAMENTO = $dadosFornecedor['tipo_pagamento'];
        $inserindoNota->ID_PERIODICIDADE = $dadosFornecedor['id_periodicidade'];
        $inserindoNota->nome_fornecedor = $dadosFornecedor['nome_fornecedor'];
        $inserindoNota->CNPJ = $request->cnpjFornecedor;
        $inserindoNota->auditoria = $dadosFornecedor['auditoria'];
        $inserindoNota->obra = $dadosFornecedor['obra'];
        $inserindoNota->marketing = $dadosFornecedor['marketing'];
        $inserindoNota->observacao = $dadosFornecedor['observacao'];
        $inserindoNota->numero_nota = $request->numeroNota;
        $inserindoNota->serie_nota = strtoupper($request->serie);
        $inserindoNota->emissao = date('d/m/Y', strtotime($request->dataEmissao));

        if ($request->dataVencimento == 'null') {

            if ($dadosFornecedor['vencimento_tipo'] == 2) { //SOMATORIO

                //limpando CNPJ da FILIAL
                $str = str_replace('/', '-', $request->dataEmissao);

                $vencimento =  date('d/m/Y', strtotime('+' . $dadosFornecedor['vencimento'] . ' days', strtotime('' . $str . '')));
            } elseif ($dadosFornecedor['vencimento_tipo'] == 3) { // FIXO VEM DO BANCO DE DADOS

                $vencimento = $dadosFornecedor['vencimento'];
            }

            $inserindoNota->vencimento = $vencimento;
        } else { //VEM DA NOTA FISCAL

            $inserindoNota->vencimento = date('d/m/Y', strtotime($request->dataVencimento));
        }

        $inserindoNota->valor_nota = $request->valorNota;
        $inserindoNota->status_desc = 1;
        $inserindoNota->date_create = date('Y-m-d');
        $inserindoNota->telefone = $dadosFornecedor['telefone'];
        $inserindoNota->carimbar = 0;
        $inserindoNota->sistema = 2;
        $inserindoNota->informacoes_adicionais = $dadosFornecedor['informacoes_adicionais'];
        $inserindoNota->ti = $dadosFornecedor['ti'];
        $inserindoNota->csc = $dadosFornecedor['csc'];
        $inserindoNota->rh = $dadosFornecedor['rh'];
        $inserindoNota->deletar = 0;
        $inserindoNota->save();

        $idNotaFiscal = $inserindoNota->ID_LANCARNOTAS;

        // SALVAR NOTA
        if ($request->hasFile('notaFiscal')) {

            $file = $request->file('notaFiscal');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/notas'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNotaFiscal;
            $salvarAnexo->url_nota = '../documentos/notas/' . $fileName;
            $salvarAnexo->save();
        }

        // SALVAR BOLETO
        if ($request->hasFile('boleto')) {

            $file = $request->file('boleto');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/boletos'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $idNotaFiscal;
            $salvarAnexo->url_nota = '../documentos/boletos/' . $fileName;
            $salvarAnexo->save();
        }

        return redirect()->back()->with('success', 'Criado com sucesso!');
    }

    public function salvarAnexo($idAnexo, $idLancarNota)
    {
        return view('notas.salvar', compact('idAnexo', 'idLancarNota'));
    }

    public function alterarAnexo(Request $request)
    {


        //adicionar a nova nota carimbada
        if ($request->hasFile('notaFiscal')) {

            //remover a nota antiga
            $deletar = TabelaCadAnexo::where('ID', $request->idAnexo)->delete();

            $file = $request->file('notaFiscal');
            $fileName = date('dmyHm') . $file->getClientOriginalName();

            $file->move(public_path('notas/documentos/notas'), $fileName);

            $salvarAnexo = new TabelaCadAnexo();
            $salvarAnexo->ID_LANCARNOTA = $request->idLancarNota;
            $salvarAnexo->url_nota = '../documentos/notas/' . $fileName;
            $salvarAnexo->save();

            //alterando CARIMBAR = 0
            $update = TabelaCadLancarNotas::where('ID_LANCARNOTAS', $request->idLancarNota)->update(['carimbar' => 0]);
        }

        return redirect()->back()->with('success', 'Nota enviada com sucesso');
    }
}

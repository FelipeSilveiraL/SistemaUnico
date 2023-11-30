<?php

namespace App\Http\Controllers\contabilidade;

use App\Http\Controllers\contabilidade\querys\QueryBuscaNota;
use App\Http\Controllers\contabilidade\querys\QueryCadastroBancos;
use App\Http\Controllers\contabilidade\querys\QueryEmpresa;
use App\Http\Controllers\contabilidade\querys\QueryFinBanco;
use App\Http\Controllers\contabilidade\querys\QueryHistoricoFluxo;
use App\Http\Controllers\contabilidade\querys\QueryLogUsuario;
use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableCadastroBanco;
use App\Models\contabilidade\TableDeletarBanco;
use App\Models\contabilidade\TableFinBanco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pagecontroller extends Controller
{
    public function index()
    {
        return view('contabilidade.index');
    }

    public function fluxo()
    {

        //relatorios
        $queryLog = new QueryLogUsuario();
        $buscaLogUsuario = $queryLog->buscaLogUsuario();


        return view('contabilidade.fluxo', compact('buscaLogUsuario'));
    }

    public function localizarFluxo(Request $request)
    {

        //primeiro verificamos se o fluxo tem permissão para ser excluido
        $numeroPermitido = 1060;

        $queryVerificar = new QueryHistoricoFluxo();
        $validando = $queryVerificar->validarFluxo($request->numeroSolicitacao, $numeroPermitido);

        if ($validando['validar'] == null) {
            return redirect()->back()->with('error', 'Fluxo não localizado');
        } else {
            if ($validando['validar'] == 1) { // 2->nao liberado; 1->liberado para a exclusão
                $queryNotas = new QueryBuscaNota();
                $buscaNotas = $queryNotas->notaFiscal($request->numeroSolicitacao);

                return view('contabilidade.visualizarNota', compact('buscaNotas'));
            } else {
                return redirect()->back()->with('error', 'Fluxo localizado porém NÃO é referente ao processo de NOTAS FISCAIS');
            }
        }
    }

    public function excluirFluxo(Request $request)
    {
        $idFluxo = $request->cdFluxo;

        if ($idFluxo != null) {

            $deletes = [
                'delete1' => "DELETE FROM HISTORICO_CAMPO_TEXTO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete2' => "DELETE FROM HISTORICO_CAMPO_VALOR WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete3' => "DELETE FROM HISTORICO_OBSERVACAO_TAREFA WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete4' => "DELETE FROM HISTORICO_OPCAO_TAREFA WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete5' => "DELETE FROM HISTORICO_CAMINHO_FLUXO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete6' => "DELETE FROM HISTORICO_TAREFA WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete7' => "DELETE FROM HISTORICO_FLUXO_INDICADOR WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete8' => "DELETE FROM HISTORICO_TAREFA_INDICADOR WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete9' => "DELETE FROM HISTORICO_VARIAVEL_FLUXO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete10' => "DELETE FROM HISTORICO_VER_ANEXO_LIBERACAO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete11' => "DELETE FROM HISTORICO_VERSAO_ANEXO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete12' => "DELETE FROM HISTORICO_ANEXO WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete13' => "DELETE FROM HISTORICO_TAREFA WHERE cd_fluxo IN(" . $idFluxo . ")",

                'delete14' => "DELETE FROM historico_FLUXO WHERE cd_fluxo IN(" . $idFluxo . ")"
            ];

            foreach ($deletes as $delete) {

                //Excluindo o fluxo na selbetti
                DB::connection('oracle_selbetti')->statement($delete);

                //Salvando log da execução
                $insert = 'INSERT INTO contabilidade_log_tarefa (id_usuario, desc_tarefa) VALUES (' . auth()->user()->id . ', "' . $delete . '")';
                DB::connection('mysql_unico')->statement($insert);
            }

            // ... save log usuario ...
            $insertLog = 'INSERT INTO contabilidade_log_usuario (id_usuario, data, numero_fluxo) VALUES (' . auth()->user()->id . ', "' . date('Y-m-d H:i:s') . '", ' . $idFluxo . ')';
            DB::connection('mysql_unico')->statement($insertLog);


            return redirect('contabilidade/fluxo')->with('success', 'Fluxo excluido com sucesso');
        } else {
            return redirect()->back();
        }
    }

    public function bloqueioBancos()
    {

        $queryBancos = new QueryCadastroBancos();
        $buscaBancosCadastrados = $queryBancos->buscaBancosCadastrados();

        $queryEmpresa = new QueryEmpresa();
        $buscaEmpresa = $queryEmpresa->buscaEmpresa($idEmpresa = null, $cnpjFilial = null);

        return view('contabilidade.bloqueioBancos', compact('buscaBancosCadastrados', 'buscaEmpresa'));
    }

    public function buscaNomeEmpresa(Request $request)
    {
        $empresa = explode('.', $request->empresaRev);
        $revenda = explode(' ', $empresa[1]);
        $banco = $request->banco;

        $queryBanco = new QueryFinBanco();
        $buscaBanco = $queryBanco->buscaFinBanco($empresa, $revenda, $banco);

        return response()->json(['nomeBanco' => $buscaBanco['nomeBanco']]);
    }

    public function salvarBanco(Request $request)
    {

        $empresa = explode('.', $request->empresaRev);
        $revenda = explode(' ', $empresa[1]);

        $queryBusca = TableCadastroBanco::where('empresa', $empresa)->where('revenda', $revenda);

        $resultado = $queryBusca->first();

        if (!empty($resultado->id)) {
            return redirect()->back()->with('success', 'Já esta cadastrado!');
        } else {
            $insertBanco = new TableCadastroBanco();

            $insertBanco->empresa = $empresa[0];
            $insertBanco->revenda = $revenda[0];
            $insertBanco->codigo_banco = $request->banco;
            $insertBanco->nome_banco = $request->nomeBanco;

            $insertBanco->save();

            return redirect()->back()->with('success', 'Banco cadastrado com sucesso!');
        }
    }

    public function deletarBanco($idBanco)
    {
        $deletar = TableDeletarBanco::find($idBanco);
        $deletar->delete();

        return redirect()->back()->with('success', 'Deletado com sucesso');
    }

    public function bloquearDataBanco(Request $request)
    {

        $dados = explode('-', $request->empresaBanco);

        $empresa = $dados[0];
        $revenda = $dados[1];
        $banco = $dados[2];

        $queryVerifica = new QueryFinBanco();
        $verifica = $queryVerifica->buscaFinBanco($empresa, $revenda, $banco);

        if ($verifica['nomeBanco'] == null) { //verificando antes se o banco ainda consta lá no APOLLO
            return redirect()->back()->with('error', 'Este banco não foi localizado no APOLLO - Verificar com a equipe responsável.');
        } else {
            $update = TableFinBanco::where('empresa', $empresa)
                ->where('revenda', $revenda)
                ->where('banco', $banco);

            $update->update(['dta_encerramento' => $request->date]);

            return redirect()->back()->with('success', 'Bloqueio efetuado com sucesso.');
        }
    }
}

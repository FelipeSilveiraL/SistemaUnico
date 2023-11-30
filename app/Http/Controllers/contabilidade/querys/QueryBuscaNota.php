<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableHistoricoCampoValor;

class QueryBuscaNota extends Controller
{
    public function notaFiscal($numeroSolicitacao)
    {

        /* FILIAL */
        $queryFilial = TableHistoricoCampoValor::select('historico_campo_valor.ds_valor as filial')
            ->where('historico_campo_valor.cd_fluxo', $numeroSolicitacao)
            ->where('historico_campo_valor.cd_campo', 12)
            ->where('historico_campo_valor.cd_tarefa', function ($subquery) use ($numeroSolicitacao) {
                $subquery->selectRaw('MAX(cd_tarefa)')
                    ->from('historico_tarefa')
                    ->where('cd_fluxo', $numeroSolicitacao)
                    ->whereNotNull('cd_usuario');
            });

        /* NUMERO DA NOTA FISCAL */
        $queryNumeroNota = TableHistoricoCampoValor::select('historico_campo_valor.ds_valor as numero_nota')
            ->where('historico_campo_valor.cd_fluxo', $numeroSolicitacao)
            ->where('historico_campo_valor.cd_campo', 14)
            ->where('historico_campo_valor.cd_tarefa', function ($subquery) use ($numeroSolicitacao) {
                $subquery->selectRaw('MAX(cd_tarefa)')
                    ->from('historico_tarefa')
                    ->where('cd_fluxo', $numeroSolicitacao)
                    ->whereNotNull('cd_usuario');
            });

        /* SÉRIE DA NOTA FISCAL */
        $querySerie = TableHistoricoCampoValor::select('historico_campo_valor.ds_valor as serie_nota')
            ->where('historico_campo_valor.cd_fluxo', $numeroSolicitacao)
            ->where('historico_campo_valor.cd_campo', 15)
            ->where('historico_campo_valor.cd_tarefa', function ($subquery) use ($numeroSolicitacao) {
                $subquery->selectRaw('MAX(cd_tarefa)')
                    ->from('historico_tarefa')
                    ->where('cd_fluxo', $numeroSolicitacao)
                    ->whereNotNull('cd_usuario');
            });

        /* NOME DO FORNECEDOR */
        $queryNomeForn = TableHistoricoCampoValor::select('historico_campo_valor.ds_valor as nome_fornecedor')
            ->where('historico_campo_valor.cd_fluxo', $numeroSolicitacao)
            ->where('historico_campo_valor.cd_campo', 17)
            ->where('historico_campo_valor.cd_tarefa', function ($subquery) use ($numeroSolicitacao) {
                $subquery->selectRaw('MAX(cd_tarefa)')
                    ->from('historico_tarefa')
                    ->where('cd_fluxo', $numeroSolicitacao)
                    ->whereNotNull('cd_usuario');
            });

        /* CNPJ DO FORNECEDOR */
        $queryCNPJForn = TableHistoricoCampoValor::select('historico_campo_valor.ds_valor as cnpj_fornecedor')
            ->where('historico_campo_valor.cd_fluxo', $numeroSolicitacao)
            ->where('historico_campo_valor.cd_campo', 16)
            ->where('historico_campo_valor.cd_tarefa', function ($subquery) use ($numeroSolicitacao) {
                $subquery->selectRaw('MAX(cd_tarefa)')
                    ->from('historico_tarefa')
                    ->where('cd_fluxo', $numeroSolicitacao)
                    ->whereNotNull('cd_usuario');
            });



        /* PEGANDO O PRIMEIRO VALOR DA PESQUISA */
        $resultFilial = $queryFilial->first();
        $resultNumeroNota = $queryNumeroNota->first();
        $resultSerie = $querySerie->first();
        $resultNomeForn = $queryNomeForn->first();
        $resultCNPJForn = $queryCNPJForn->first();

        /* SALVANDO O RESULTADO */
        return [
            'filial' => $resultFilial ? $resultFilial->filial : null,
            'numero_nota' => $resultNumeroNota ? $resultNumeroNota->numero_nota : null,
            'serie_nota' => $resultSerie ? $resultSerie->serie_nota : null,
            'nome_fornecedor' => $resultNomeForn ? $resultNomeForn->nome_fornecedor : null,
            'cnpj_fornecedor' => $resultCNPJForn ? $resultCNPJForn->cnpj_fornecedor : null,
            'numero_fluxo' => $numeroSolicitacao
        ];
    }
}

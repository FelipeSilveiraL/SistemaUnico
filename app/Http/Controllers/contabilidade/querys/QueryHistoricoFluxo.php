<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableHistoricoFluxo;

class QueryHistoricoFluxo extends Controller
{
    public function validarFluxo($numeroSolicitacao, $numeroPermitido)
    {
        $queryVerificar = TableHistoricoFluxo::where('cd_fluxo', $numeroSolicitacao)
            ->where('cd_processo', $numeroPermitido);

        $resultadoVerificar = $queryVerificar->first();

        if ($resultadoVerificar != null) {
            $validando = $resultadoVerificar->cd_processo == $numeroPermitido ? 1 : 2;// 1->nao liberado; 2->liberado para a exclusão
        } else {
            $validando = null;
        }

        return ['validar' =>  $validando];
    }
}

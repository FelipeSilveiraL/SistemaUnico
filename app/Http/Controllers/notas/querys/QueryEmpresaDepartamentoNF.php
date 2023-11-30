<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaEmpresaDepartamentoNF;

class QueryEmpresaDepartamentoNF extends Controller
{
    public function buscaDepartamento($idFiial){

        $sql = TabelaEmpresaDepartamentoNF::select('D.ID_DEPARTAMENTO', 'D.NOME_DEPARTAMENTO')
        ->leftJoin('departamento_nf AS D', 'empresa_departamento_nf.ID_DEPARTAMENTO', '=', 'D.ID_DEPARTAMENTO')
        ->where('empresa_departamento_nf.ID_EMPRESA', $idFiial)
        ->where('empresa_departamento_nf.SITUACAO', 'A')
        ->where('empresa_departamento_nf.LANCA_NOTAS', 'S')
        ->orderBy('D.nome_departamento')
        ->get();

        return $sql;
    }
}

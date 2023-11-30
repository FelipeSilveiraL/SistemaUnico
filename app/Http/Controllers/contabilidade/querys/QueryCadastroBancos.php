<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableCadastroBanco;

class QueryCadastroBancos extends Controller
{
    public function buscaBancosCadastrados(){
        $queryBancosCadastrados = TableCadastroBanco::leftJoin('EMPRESA AS E',  'CCB.EMPRESA' , '=', 'E.EMPRESA_APOLLO')
        ->whereColumn('CCB.EMPRESA', 'E.EMPRESA_APOLLO')
        ->whereColumn('CCB.REVENDA', 'E.REVENDA_APOLLO')
        ->where('E.SITUACAO', 'A')
        ->where('E.SISTEMA', 'A')
        ->OrderBy('CCB.id', 'DESC')
        ->get();

        return $queryBancosCadastrados;
    }
}

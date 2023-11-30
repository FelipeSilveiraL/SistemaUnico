<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableEmpresaApollo;

class QueryEmpresa extends Controller
{
    public function buscaEmpresa($idEmpresa, $cnpjFilial = null){

        $queryBuscaEmpresa = TableEmpresaApollo::where('SITUACAO', 'A');

        if ($idEmpresa == null AND $cnpjFilial == null) {

            $queryBuscaEmpresa->where('SISTEMA', 'A')->orWhere('SISTEMA', 'N');

        } elseif ($cnpjFilial == null) {

            $queryBuscaEmpresa->where('ID_EMPRESA', $idEmpresa);
        }else{
            $queryBuscaEmpresa->where('CNPJ', $cnpjFilial);
        }

        $queryBuscaEmpresa->orderBy('NOME_EMPRESA');

        return $queryBuscaEmpresa->get();
    }

}

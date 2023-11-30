<?php

namespace App\Http\Controllers\unico\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableEmpresaApollo;
use App\Models\unico\TabelaEmpresa;

class QueryEmpresa extends Controller
{
    public function listarEmpresaUser($idEmpresa){
        $listarEmpresaUser = TabelaEmpresa::where('id', $idEmpresa)
        ->get();

        return $listarEmpresaUser;
    }

    public function listarEmpresa(){
        $listarEmpresa = TabelaEmpresa::where('deletar', 0)
        ->orderBy('nome')
        ->get();

        return $listarEmpresa;

    }

    public function buscaEmpresaBpmgp($idEmpresa) {
        $query = TableEmpresaApollo::where('SITUACAO', 'A');

        if ($idEmpresa != null) {
            $query->where('id_empresa', $idEmpresa);
        }

        $result = $query->orderBy('nome_empresa')->get();

        return $result;
    }

}

<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadRateioFornecedor;
use Illuminate\Http\Request;

class QueryCadFornecedor extends Controller
{
    public function buscaFornecedor($idUsuario){
        $sql = TabelaCadRateioFornecedor::where('ID_USUARIO', $idUsuario)->get();

        return $sql;
    }

    public function buscaFornecedorID($idFornecedor){
        $sql = TabelaCadRateioFornecedor::where('ID_RATEIOFORNECEDOR', $idFornecedor)->get();

        return $sql;
    }
}

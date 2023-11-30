<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableFinBanco;

class QueryFinBanco extends Controller
{
    public function buscaFinBanco($empresa, $revenda, $banco){

        $queryFinBanco = TableFinBanco::where('empresa', $empresa)
        ->where('revenda', $revenda)
        ->where('banco', $banco);

        $resultado = $queryFinBanco->first();

        return ['nomeBanco' => $resultado->des_banco];

    }
}

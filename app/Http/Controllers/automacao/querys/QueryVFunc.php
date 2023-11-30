<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\rh\TabelaVFunc;

class QueryVFunc extends Controller
{
    public function buscaColaborador(){
        $sql = TabelaVFunc::where('dessit', '!=', 'demitido')
        ->select('nomfun', 'numcpf', 'emacom', 'dessit')
        ->orderBy('nomfun', 'ASC')
        ->get();

        return $sql;
    }
}

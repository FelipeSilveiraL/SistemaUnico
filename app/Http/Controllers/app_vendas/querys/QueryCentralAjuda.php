<?php

namespace App\Http\Controllers\app_vendas\querys;

use App\Http\Controllers\Controller;
use App\Models\app_vendas\TabelaCentralAjuda;
use Illuminate\Http\Request;

class QueryCentralAjuda extends Controller
{
    public function centralAjuda($idCentral){

        $busca = TabelaCentralAjuda::where('id', $idCentral)->get();

        return $busca;
    }
}

<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\TabelaTransporteRotaAutorizada;

class QueryRotaAutorizada extends Controller
{
    public function buscarView($placa, $cnpj) {

        $queryRotaAutorizada = TabelaTransporteRotaAutorizada::where(function ($query) use ($placa){
            $query->where('placa', 'LIKE', '%' . $placa . '%')
                ->orWhere('chassi', 'LIKE', '%' . $placa . '%');
        })
        ->where('CNPJ_TRANSPORTADORA', $cnpj)
        ->get();

        return $queryRotaAutorizada;
    }
}



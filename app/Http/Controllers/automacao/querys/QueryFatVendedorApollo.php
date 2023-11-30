<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaUserVendedorApollo;

class QueryFatVendedorApollo extends Controller
{
    public function buscarUsuario(){
        $query = TabelaUserVendedorApollo::select('nome', 'cpf', 'ativo')->get();

        return $query;
    }
}

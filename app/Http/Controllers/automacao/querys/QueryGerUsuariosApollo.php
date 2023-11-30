<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaUserApollo;

class QueryGerUsuariosApollo extends Controller
{
    public function buscaUsuariosApollo(){

        $query = TabelaUserApollo::select('nome', 'cpf', 'ativo')->get();

        return $query;

    }
}

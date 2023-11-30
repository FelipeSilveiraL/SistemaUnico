<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaEmpresaUsuarios;

class QueryEmpresaUsuarios extends Controller
{
    public function buscaUsuario(){
        $query = TabelaEmpresaUsuarios::select('nome', 'cpf', 'demitido')->get();

        return $query;
    }
}

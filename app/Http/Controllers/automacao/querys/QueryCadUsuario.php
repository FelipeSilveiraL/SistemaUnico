<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\cad_usuario_api;

class QueryCadUsuario extends Controller
{
    public function buscarUsuario($cpf){

        $sql = cad_usuario_api::select('nome')->where('cpf', $cpf);

        $result = $sql->first();

        return ['nome' => $result ? $result->nome : NULL];
    }
}

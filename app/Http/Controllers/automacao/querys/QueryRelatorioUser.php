<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaRelatorioUser;

class QueryRelatorioUser extends Controller
{
    public function buscaUsuario(){
        $sql = TabelaRelatorioUser::get();

        return $sql;
    }
}

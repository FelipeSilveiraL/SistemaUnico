<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaVetorUsers;

class QueryVetorUser extends Controller
{
    public function usuariosVetor(){
        $sql = TabelaVetorUsers::get();

        return $sql;
    }
}

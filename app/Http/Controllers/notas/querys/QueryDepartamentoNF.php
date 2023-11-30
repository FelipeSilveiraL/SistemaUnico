<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaDepartamentoNF;

class QueryDepartamentoNF extends Controller
{
    public function buscaNomeDepartamento($idDepartamento){
        $sql = TabelaDepartamentoNF::where('DNF.ID_DEPARTAMENTO', $idDepartamento)->get();

        return $sql;
    }
}

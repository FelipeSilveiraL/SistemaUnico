<?php

namespace App\Http\Controllers\rh\querys;

use App\Http\Controllers\Controller;
use App\Models\rh\TabelaDepartamentos;

class QueryDepartamentos extends Controller
{
    public function buscaDepartamento(){
        $buscaDepartamento = TabelaDepartamentos::where('SITUACAO', 'A')
        ->orderBy('NOME_DEPARTAMENTO', 'ASC')
        ->get();

        return $buscaDepartamento;

    }
}

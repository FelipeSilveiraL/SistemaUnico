<?php

namespace App\Http\Controllers\unico\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaDepartamentoNF;
use App\Models\unico\TabelaDepartamento;

class QueryDepartamento extends Controller
{
    public function listaDepartamentoUser($idDepartamento){
        $listaDepartUser = TabelaDepartamento::where('id', $idDepartamento)
        ->get();

        return $listaDepartUser;

    }

    public function listaDepartamento(){
        $listaDepart = TabelaDepartamento::where('deletar', 0)
        ->orderBy('nome', 'ASC')
        ->get();

        return $listaDepart;
    }

    public function departamentoBPMGP($idDepartamento){

        $sql = TabelaDepartamentoNF::where('DNF.SITUACAO', 'A');

        if ($idDepartamento != null) {
            $sql->where('DNF.ID_DEPARTAMENTO', $idDepartamento);
        }

        $result = $sql->orderBy('DNF.nome_departamento')->get();

        return $result;

    }
}

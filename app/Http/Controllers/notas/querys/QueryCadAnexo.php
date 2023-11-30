<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadAnexo;

class QueryCadAnexo extends Controller
{
    public function buscaAnexo($idNota){
        $sql = TabelaCadAnexo::where('ID_LANCARNOTA', $idNota)
        ->get();

        return $sql;
    }
}

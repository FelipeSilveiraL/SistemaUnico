<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\TAREFA;
use Illuminate\Support\Facades\DB;

class QueryTarefaLiberacao extends Controller
{
    public function liberarAvanco($cdFluxo){

        $query = TAREFA::where('cd_fluxo', $cdFluxo)
        ->where('cd_tarefa', '=', DB::raw('(SELECT MAX(CD_TAREFA) FROM TAREFA WHERE CD_FLUXO = '.$cdFluxo.')'))
        ->select(DB::raw("CASE cd_passo WHEN 43 THEN 'OK' ELSE ' ' END AS situacao"));

        $resultado = $query->first();

        return ['situacao' => $resultado ? $resultado->situacao : NULL];
    }
}


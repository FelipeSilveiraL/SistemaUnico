<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\TAREFA;
use Illuminate\Support\Facades\DB;

class QueryTarefa extends Controller
{
    public function buscaTarefa($cdFluxo){

        $query = TAREFA::where('cd_fluxo', $cdFluxo)
        ->where('cd_tarefa', '=', DB::raw('(SELECT MAX(CD_TAREFA) FROM TAREFA WHERE CD_FLUXO = '.$cdFluxo.')'))
        ->select('cd_tarefa', 'cd_passo');

        $resultado = $query->first();

        return [
            'cdTarefa' => $resultado ? $resultado->cd_tarefa : NULL,
            'cdPasso' => $resultado ? $resultado->cd_passo : NULL
        ];

    }
}

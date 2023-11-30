<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\VW_FLUXO_TRANSPORTE_ROTA_A_PROGRAMAR;
use Illuminate\Support\Facades\DB;

class QueryFluxoRotaProgramar extends Controller
{
    public function rotaProgramarFluxo($cdFluxo)
    {

        $query = VW_FLUXO_TRANSPORTE_ROTA_A_PROGRAMAR::where('cd_fluxo', $cdFluxo)
            ->select('cd_fluxo', DB::raw('COUNT(*) as quantidade'))
            ->groupBy('cd_fluxo');

        $resultado = $query->first();

        return [
            'liberado' => $resultado ? $resultado->quantidade : NULL
        ];
    }
}

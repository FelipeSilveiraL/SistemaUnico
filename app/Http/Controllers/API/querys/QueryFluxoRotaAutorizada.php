<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\VW_FLUXO_TRANSPORTE_ROTA_AUTORIZADA;
use Illuminate\Support\Facades\DB; // Importe a classe DB

class QueryFluxoRotaAutorizada extends Controller

{

    public function rotaAutorizadaFluxo($cdFluxo)
    {

        $query = VW_FLUXO_TRANSPORTE_ROTA_AUTORIZADA::where('cd_fluxo', $cdFluxo)
            ->whereIn('situacao', ['DISPONIVEL', 'EMBARCADO'])
            ->select('cd_fluxo', DB::raw('COUNT(*) as quantidade'))
            ->groupBy('cd_fluxo');

        $resultado = $query->first();

        return [
            'liberado' => $resultado ? $resultado->quantidade : NULL
        ];
    }
}

<?php

namespace App\Http\Controllers\API\querys;

use App\Http\Controllers\Controller;
use App\Models\API\VW_FLUXO_TRANSPORTE;

class QueryFluxoTransporte extends Controller
{
    public function liberacao($id_contrato){
        $sql = VW_FLUXO_TRANSPORTE::where('cd_fluxo', $id_contrato)->select('pode_finalizar');

        $result = $sql->first();

        return ['podeLiberar' => $result ? $result->pode_finalizar : NULL];
    }
}

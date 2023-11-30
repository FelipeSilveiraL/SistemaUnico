<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class VexCreatePdf extends Controller
{
    public function getPDF()
    {
        /* ======================  CONFIGURAÇÕES ====================== */

        //API
        $token = 'AJS159'; //SGO373->homologação
        $embarque = 728; //727->desenbarque
        $procedure = 'SP_EMBARQUE_DESEMBARQUE_520';
        $db = 'oracle_selbetti';

        /* ======================  COLETANDO ID VISTORIA ====================== */
        $client = new Client();
        $response = $client->request('GET', 'COLOCAR O LINK CORRETO PARA GERAR O PDF');

        $data = json_decode($response->getBody(), true);


        foreach ($data['data'] as $dataItem) {

            if (isset($dataItem['id'])) {

                echo $dataItem['id']."<br />";

                return response()->json('PDF gerado com sucesso', 200);

            }else {

                return response()->json('Nenhuma vistoria encontrada', 200);

            }
        }

        return response()->json('Finalizado', 200);
    }
}

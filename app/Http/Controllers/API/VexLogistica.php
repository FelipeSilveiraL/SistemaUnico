<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\querys\QueryRotaAutorizada;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class VexLogistica extends Controller
{
    public function index(Request $request, $placa = null)
    {

        $placa = strtoupper($placa);
        $cnpj = limparCPF($request->header('cnpj-usuario'));

        if ($placa === '{PLACA}' || empty($placa)) {
            return response()->json('API ON');
        } else {
            try {

                /* LISTA DE IPS QUE PODEM ACESSAR */
                $allowedIps = [
                    '10.212.128.4', //FELIPE LARA
                    '10.212.128.3', //RUBENS JUNIOR
                    /* VEX SOFT */
                    '168.205.190.65',
                    '168.205.190.101',
                    '45.170.26.1',
                    '168.205.190.101',
                    '168.205.190.27',
                    '168.205.190.105'
                ];

                $clientIp = trim($request->ip());

                if (!in_array($clientIp, $allowedIps)) {
                    return response()->json("Acesso nao autorizado", 200);
                }

                /* nao DEIXA PASSAR SEM INFORMAR UMA PLACA */
                if (empty($placa)) {
                    return response()->json("Placa nao informada", 200);
                }

                //BUSCA DA PLACA
                $queryRota = new QueryRotaAutorizada;
                $rotaAutorizada = $queryRota->buscarView($placa, $cnpj);

                /* PLACA nao LOCALIZADA */
                if ($rotaAutorizada->isEmpty()) {
                    return response()->json("Placa nao localizada ", 200);
                }

                //MONTA OS DADOS
                foreach ($rotaAutorizada as $key => $rota) {

                    $cliente = new \stdClass();
                    $cliente->email = $rota['cliente'];

                   /*  $contrato = $rota['cd_fluxo'].'-'.$rota['linha']; */
                    $contrato = $rota['cd_fluxo'].$rota['linha'];
                    $localVistoria = $rota['origem_rota'];
                    /* $destino = $rota['destino_rota']; */
                    $emailCliente = $rota['cliente'];


                    $veiculo = new \stdClass();
                    $veiculo->nome = $rota['modelo'];
                    $veiculo->placa = $rota['placa'];
                    $veiculo->chassi = $rota['chassi'];
                    $veiculo->cor = $rota['cor_veiculo'];
                    $veiculo->destino = $rota['destino_rota'];
                }

                $response = [
                    'cliente' => $cliente,
                    'contrato' => $contrato,
                    'localVistoria' => $localVistoria,
                    /* 'destino' => $destino, */
                    "email" => $emailCliente,
                    'veiculo' => $veiculo,
                ];

                return response()->json($response, 200);
            } catch (Exception $e) {

                $response = [
                    'error' => $e->getMessage(),
                ];

                return response()->json($response, 500);
            }
        }
    }
}

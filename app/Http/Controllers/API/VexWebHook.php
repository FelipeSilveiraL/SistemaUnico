<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\querys\QueryFluxoRotaAutorizada;
use App\Http\Controllers\API\querys\QueryFluxoRotaProgramar;
use App\Http\Controllers\API\querys\QueryFluxoTransporte;
use App\Http\Controllers\API\querys\QueryTarefa;
use App\Http\Controllers\API\querys\QueryTarefaLiberacao;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PDO;


class VexWebHook extends Controller
{

    public function importacao($log = null)
    {
        /* ======================  CONFIGURAÇÕES ====================== */

        //API
        $token = 'AJS159'; //SGO373->homologação
        $embarque = 728; //727->desenbarque
        $procedure = 'SP_EMBARQUE_DESEMBARQUE_520';
        $db = 'oracle_selbetti';

        //FTP
        $ftpHost = '10.100.1.44';
        $ftpUsername = 'FTPgSTI';
        $ftpPassword = '&FP@ssGSTI23';
        $ftpPort = 2121;
        $localPath = 'vistoriaTemporario/';
        $remoteFilePath = '/WF0520/';

        //AVANÇO DE FLUXO
        $tokenSelbettiUser = 'integra.usuario'; //Usuario para solicitar o Token junto a selbetti
        $tokenSelbettiPasswd = 'passwshare'; //Senha do usuario de token
        $dsCliente = 'mobile';
        $dsChaveAutenticacao = 'NnLHcy3ilNdOs1+JJJysCJbhOX9cWOVkn1jj5MzdViA=';
        $cdUsuario = 27329;
        $cdOpcao = 1;

        /* ======================  COLETANDO ID VISTORIA ====================== */
        $client = new Client();
        $response = $client->request('GET', 'https://api.vexsoft.com.br/empresa/' . $token . '/vistorias/naoexportadas');

        $data = json_decode($response->getBody(), true);

        foreach ($data['data'] as $dataItem) {

            if (isset($dataItem['id'])) {

                /* ======================  COLETANDO CONTEÚDO DA VISTORIA ====================== */
                $coleta = new Client();
                $resposta = $coleta->request('GET', 'https://apiv3.vexsoft.com.br/vistoria/' . $token . '/' . $dataItem['id'] . '');
                $info = json_decode($resposta->getBody(), true);

                $dadosVistoria = $info[0];

                //PARAMETROS DA PROCEDURA
                $embarque_desembarque = $dadosVistoria['id_tipo_operacao'] == $embarque ? 'E' : 'D';
                $data = date('d/m/Y', strtotime($dadosVistoria['data'])) . " " . hora($dadosVistoria['hora']);
                $id_contrato = contrato($dadosVistoria['contrato']); //CD_FLUXO
                $id_linha = linha($dadosVistoria['contrato']); //NUMERO DA LINHA
                $documento_vistoria = $dadosVistoria['url_download'];
                $cnpjTransportadora = $dadosVistoria['vistoriador_cnpj'];

                if ($dadosVistoria['url_download'] != NULL) { //VERIFICANDO SE O DOCUMENTO JÁ ESTA DISPONIVEL

                    /* ======================  EXECUTANDO A PROCEDURE ====================== */

                    /* PARAMETROS */
                    $procedure .= "(" . $id_contrato . ", " . $id_linha . ", '" . $data . "', '" . $embarque_desembarque . "', '" . $cnpjTransportadora . "', :v_status_retorno_out, :v_nome_anexo_out)";

                    /* CONECTANDO E EXECUTANDO A PROCEDURE */
                    $connection = DB::connection($db);
                    $statement = $connection->getPdo()->prepare('BEGIN ' . $procedure . '; END;');

                    $statement->bindParam(':v_status_retorno_out', $v_status_retorno_out, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 150);
                    $statement->bindParam(':v_nome_anexo_out', $v_nome_anexo_out, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 150);

                    $statement->execute();

                    $status = removerEspacosBrancos($v_status_retorno_out);

                    if (!empty($status)) {

                        //TRATATIVA DOS ERROS
                        switch ($v_status_retorno_out) {

                            case 'Linha ja embarcada':

                                marcarExportada($token, $dataItem['id']);

                                //marco como vistoria importada
                                return vistoriaImportada($id_contrato, $id_linha, $embarque_desembarque);

                                break;

                            case 'Linha ja desembarcada':

                                marcarExportada($token, $dataItem['id']);

                                //marco como vistoria importada
                                return vistoriaImportada($id_contrato, $id_linha, $embarque_desembarque);

                                break;

                            default:

                                //MOSTRAR ERRO QUE ESTA VINDO DA PROCEDURE
                                $log = new \stdClass();
                                $log->id_vex = $dataItem['id'];
                                $log->contrato = $id_contrato;
                                $log->linha = $id_linha;
                                $log->procedimento = $embarque_desembarque;
                                $log->mensagem = $v_status_retorno_out;

                                //MANDANDO EMAIL
                                $alertarEmail = new EmailErroProcedure;
                                $alertarEmail->enviarEmail();

                                return response()->json($response = ['alerta' => $log], 200);

                                break;
                        }

                    } else {

                        /* ======================  SALVAR O DOCUMENTO PDF ====================== */
                        //ARQUIVO LOCAL
                        $localPath .= $v_nome_anexo_out;

                        // Faz o download do arquivo da URL e salva na pasta local
                        copy($documento_vistoria, public_path($localPath));

                        //FTP

                        // Caminho local do arquivo a ser enviado
                        $localFilePath = public_path($localPath);

                        // Caminho remoto no servidor FTP
                        $remoteFilePath .= $v_nome_anexo_out; // Substitua pelo caminho desejado no servidor

                        // Conecta ao servidor FTP
                        $ftpConnection = ftp_connect($ftpHost, $ftpPort);

                        // Faz o login no servidor FTP
                        ftp_login($ftpConnection, $ftpUsername, $ftpPassword);

                        // Upload do arquivo
                        ftp_put($ftpConnection, $remoteFilePath, $localFilePath, FTP_BINARY);

                        // Deletando o arquivo que foi salvo temporariamente
                        unlink($localFilePath);

                        // Fecha a conexão FTP
                        ftp_close($ftpConnection);

                        /* ======================  INFORMAR VISTORIA QUE ESTA OK ====================== */

                        marcarExportada($token, $dataItem['id']);

                        /* ======================  AVANÇO DE FLUXO ====================== */

                        if ($embarque_desembarque === 'D') {

                            $sqlPassoLiberar = new QueryTarefaLiberacao();
                            $liberarPasso = $sqlPassoLiberar->liberarAvanco($id_contrato);

                            if ($liberarPasso['situacao'] == 'OK') {

                                //chegar se tem liberação para fazer o avanço de fluxo
                                $liberar = new QueryFluxoTransporte();
                                $liberar = $liberar->liberacao($id_contrato);

                                //API SELBETTI AVANÇAR FLUXO
                                if ($liberar['podeLiberar'] === 'S') {

                                    //COLETANDO O CD_TAREFA
                                    $tarefa = new QueryTarefa;
                                    $tarefa = $tarefa->buscaTarefa($id_contrato);

                                    //AVANÇANDO FLUXO
                                    $avancaFluxo = new Client();

                                    $dataAvanca = [
                                        'lstCamposForm' => [],
                                        'lstExecutores' => [
                                            [
                                                'cdUsuario' => $cdUsuario
                                            ]
                                        ]
                                    ];

                                    $jsonDataA = json_encode($dataAvanca);

                                    $aplicandoAPI = $avancaFluxo->request('POST', 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareApi/api/v2/Fluxo/AvancaFluxo', [
                                        'headers' => [
                                            'Content-Type' => 'application/json',
                                            'dsCliente' => $dsCliente,
                                            'dsChaveAutenticacao' => $dsChaveAutenticacao,
                                            'tokenUsuario' => tokenSelbetti($tokenSelbettiUser, $tokenSelbettiPasswd, $dsCliente, $dsChaveAutenticacao),
                                            'cdFluxo' => $id_contrato,
                                            'cdTarefa' => $tarefa['cdTarefa'],
                                            'cdOpcao' => $cdOpcao
                                        ],

                                        'body' => $jsonDataA
                                    ]);

                                    json_decode($aplicandoAPI->getBody(), true);
                                }
                            }
                        } // END AVANÇO DE FLUXO

                    }
                } else {

                    //MSN DE FINALIZAÇÃO
                    $log = new \stdClass();
                    $log->id_vex = $dataItem['id'];
                    $log->contrato = $id_contrato;
                    $log->linha = $id_linha;
                    $log->procedimento = $embarque_desembarque;
                    $log->mensagem = "PDF nao localizado";

                    //FINALIZANDO PROCESSO
                    return response()->json($response = ['alerta' => $log], 200);

                    die();
                } //END IF $dadosVistoria['url_download']

                return vistoriaImportada($id_contrato, $id_linha, $embarque_desembarque);
            } //END IF isset($dataItem['id']

        } //END FOREACH $data['data'] as $dataItem

        /* ======================  FINAL DO PROCESSO ====================== */

        return response()->json($response = ['alerta' => $log], 200);
    }
}

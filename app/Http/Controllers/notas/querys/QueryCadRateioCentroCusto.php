<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadRateioCentroCusto;
use Illuminate\Support\Facades\DB;

class QueryCadRateioCentroCusto extends Controller
{
    public function buscaRateio($filial, $cnpjFornecedor, $infAdicionais, $idUsuario, $obs)
    {
        $sql = TabelaCadRateioCentroCusto::select('cad_rateiocentrocusto.ID_CENTROCUSTO_BPM AS centrocusto', 'cad_rateiocentrocusto.percentual AS porcento', 'cad_rateiocentrocusto.ID_CENTROCUSTO_BPM')
            ->leftJoin('cad_rateiofornecedor AS CRF', 'cad_rateiocentrocusto.ID_RATEIOFORNECEDOR', '=', 'CRF.ID_RATEIOFORNECEDOR')
            ->where('CRF.ID_FILIAL', $filial)
            ->where('CRF.cpfcnpj_fornecedor', $cnpjFornecedor)
            ->where('CRF.ID_USUARIO', $idUsuario)
            ->where('CRF.OBSERVACAO', $obs);

        if ($infAdicionais == NULL) {
            $sql->whereNull('CRF.informacoes_adicionais');
        } else {
            $sql->where('CRF.informacoes_adicionais', $infAdicionais);
        }

        $result = $sql->get();

        return $result;
    }

    public function buscaRateioID($idRateioFornecedor)
    {
        $sql = TabelaCadRateioCentroCusto::select('ID_RATEIOCENTROCUSTO', 'ID_CENTROCUSTO_BPM', 'percentual')
            ->where('ID_RATEIOFORNECEDOR', $idRateioFornecedor)->get();

        return $sql;
    }

    public function verificandoJaPossui($departamento, $idRateioFornecedor)
    {
        $sql = TabelaCadRateioCentroCusto::select('ID_RATEIOCENTROCUSTO', 'ID_CENTROCUSTO_BPM', 'percentual')
            ->where('ID_CENTROCUSTO_BPM', $departamento)
            ->where('ID_RATEIOFORNECEDOR', $idRateioFornecedor)
            ->get();

        return $sql;
    }

    public function carimbo($ia, $fornecedor, $filial, $email)
    {

        //INFORMAÇÃOES ADICIONAIS
        $where = $ia != 'null' ? "informacoes_adicionais = '" . $ia . "' AND" : 'informacoes_adicionais is null and';

        //ID DA FILIAL
        $selec = " AND ID_FILIAL = (";

        if (strlen($filial) < 14) {

            $selec .=  $filial;
        } else {

            $queryEmpresa = "SELECT ID_EMPRESA FROM empresa WHERE CNPJ = '$filial' AND SITUACAO = 'A'";

            $idEmpresa = DB::connection('oracle_bpmgp')->select($queryEmpresa);

            if (!empty($idEmpresa)) {

                $selec .= $idEmpresa[0]->id_empresa;
            } else {

                $selec .= '0';
            }
        }

        $selec .= ")";

        //MONTANDO A CUNSULTA
        $sql = TabelaCadRateioCentroCusto::select('percentual', 'ID_CENTROCUSTO_BPM')
            ->where('ID_RATEIOFORNECEDOR', DB::connection('mysql_dbnotas')
                ->raw('(SELECT ID_RATEIOFORNECEDOR  FROM cad_rateiofornecedor  WHERE cpfcnpj_fornecedor = ' . $fornecedor . ' AND ' . $where . ' ID_USUARIO = (SELECT id FROM unico.usuarios WHERE email = "' . $email . '") ' . $selec. ')'))
            ->get();

        return $sql;
    }
}

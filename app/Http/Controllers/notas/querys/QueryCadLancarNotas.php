<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\contabilidade\querys\QueryEmpresa;
use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadLancarNotas;

class QueryCadLancarNotas extends Controller
{
    public function statusNotas($idStatus, $userId, $mesAnterior)
    {

        //STATUS SENDO INFORMADO NO PARAMETRO
        foreach ($idStatus as $status) {

            $sqlLancando = TabelaCadLancarNotas::where('status_desc', $status)
                ->where('id_usuario', $userId)
                ->where('deletar', 0)
                ->whereBetween('date_create', [
                    date('Y-m', strtotime('-' . $mesAnterior . ' months', strtotime(date('Y-m-d')))) . "-01",
                    date('Y-m') . "-31"
                ])
                ->count();

            $statusCounts[$status] = $sqlLancando;
        }

        //TODOS OS STATUS COM ERRO
        $sqlError = TabelaCadLancarNotas::leftJoin('cad_status AS CS', 'cad_lancarnotas.status_desc', '=', 'CS.id')
            ->where('CS.erro', 1)
            ->where('cad_lancarnotas.id_usuario', $userId)
            ->where('cad_lancarnotas.deletar', 0)
            ->whereBetween('cad_lancarnotas.date_create', [
                date('Y-m', strtotime('-' . $mesAnterior . ' months', strtotime(date('Y-m-d')))) . "-01",
                date('Y-m') . "-31"
            ])
            ->count();

        $statusCountsError['erro'] = $sqlError;

        return ['statusCounts' => $statusCounts, 'statusCountsError' => $statusCountsError];
    }

    public function notas($idStatus, $userId, $mesAnterior){

        $sql = TabelaCadLancarNotas::leftJoin('cad_status AS CS', 'cad_lancarnotas.status_desc',  '=',  'CS.id')
            ->select('cad_lancarnotas.id_lancarnotas', 'cad_lancarnotas.valor_nota', 'cad_lancarnotas.emissao', 'cad_lancarnotas.vencimento', 'cad_lancarnotas.numero_fluig AS smartShare', 'cad_lancarnotas.nome_fornecedor AS fornecedor', 'cad_lancarnotas.ID_FILIAL AS id_empresa', 'CS.nome AS status', 'CS.id AS id_status','cad_lancarnotas.numero_nota')
            ->where('cad_lancarnotas.ID_USUARIO', $userId)
            ->where('cad_lancarnotas.deletar', 0)
            ->whereBetween('cad_lancarnotas.date_create', [
                date('Y-m', strtotime('-' . $mesAnterior . ' months', strtotime(date('Y-m-d')))) . "-01",
                date('Y-m') . "-31"
            ]);

        if ($idStatus === 'error') {
            $sql->where('CS.erro', 1);
        } else {
            $sql->where('cad_lancarnotas.status_desc', $idStatus);
        }

        $results = $sql->get(); // Executa a consulta e armazena os resultados

        $results->map(
            function ($sql) {
                $buscaNomeEmpresa = new QueryEmpresa;
                $empresa = $buscaNomeEmpresa->buscaEmpresa($sql->id_empresa)->first(); // Obtenha o primeiro resultado

                if ($empresa) {
                    $sql->nome_empresa = $empresa['nome_empresa'];
                } else {
                    $sql->nome_empresa = null; // Define como null se a empresa não for encontrada
                }

                return $sql;
            }
        );

        return $results;
    }

    public function dadosNotas($idNota){
        $sql = TabelaCadLancarNotas::where('id_lancarnotas', $idNota)->get();

        $sql->map(
            function ($sql) {
                $buscaNomeEmpresa = new QueryEmpresa;
                $empresa = $buscaNomeEmpresa->buscaEmpresa($sql->ID_FILIAL)->first(); // Obtenha o primeiro resultado

                if ($empresa) {
                    $sql->nome_empresa = $empresa['nome_empresa'];
                } else {
                    $sql->nome_empresa = null; // Define como null se a empresa não for encontrada
                }

                return $sql;
            }
        );

        return $sql;
    }

}

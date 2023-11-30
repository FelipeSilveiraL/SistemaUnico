<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadBancos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryCadBancos extends Controller
{
    public function buscaBanco($cpfcnpjFornecedor, $id_usuario, $id_filial)
    {
        $result = TabelaCadBancos::select('CB.nome_banco', 'CB.agencia', 'CB.conta', 'CB.digito')
            ->where(
                'id_rateiofornecedor',
                DB::connection('mysql_dbnotas')
                    ->table('cad_rateiofornecedor')
                    ->select(DB::connection('mysql_dbnotas')->raw('MAX(id_rateiofornecedor) as max_id_rateiofornecedor'))
                    ->where('cpfcnpj_fornecedor', $cpfcnpjFornecedor)
                    ->where('id_usuario', $id_usuario)
                    ->where('id_filial', $id_filial)
            )->first();

        return [
            'nome_banco' => $result ? $result->nome_banco : null,
            'agencia' => $result ? $result->agencia : null,
            'conta' => $result ? $result->conta : null,
            'digito' => $result ? $result->digito : null,
        ];
    }
}

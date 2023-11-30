<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaCadRateioFornecedor;

class QueryCadRateioFornecedor extends Controller
{
    public function buscaRateioFornecedor($idFilial, $cnpjFornecedor, $idUsuario){

        $sql = TabelaCadRateioFornecedor::where('ID_FILIAL', $idFilial)
        ->where('CPFCNPJ_FORNECEDOR', $cnpjFornecedor)
        ->where('ID_USUARIO', $idUsuario);

        $resultado = $sql->first();

        return [
            'telefone' => $resultado ? $resultado->telefone : null,
            'id_rateiofornecedor' => $resultado ? $resultado->ID_RATEIOFORNECEDOR : null,
            'id_periodicidade' => $resultado ? $resultado->ID_PERIODICIDADE : null,
            'auditoria' => $resultado ? $resultado->auditoria : null,
            'obra' => $resultado ? $resultado->obra : null,
            'marketing' => $resultado ? $resultado->marketing : null,
            'csc' => $resultado ? $resultado->csc : null,
            'ti' => $resultado ? $resultado->ti : null,
            'rh' => $resultado ? $resultado->rh : null,
            'observacao' => $resultado ? $resultado->observacao : null,
            'tipo_pagamento' => $resultado ? $resultado->ID_TIPOPAGAMENTO : null,
            'nome_fornecedor' => $resultado ? $resultado->fornecedor : null,
            'vencimento_tipo' => $resultado ? $resultado->vencimento_tipo : null,
            'vencimento' => $resultado ? $resultado->vencimento : null,
            'informacoes_adicionais' => $resultado ? $resultado->informacoes_adicionais : null,

        ];
    }
}

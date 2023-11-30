<?php

namespace App\Http\Controllers\rh\querys;

use App\Http\Controllers\Controller;
use App\Models\rh\TabelaVFunc;

class QueryVFunc extends Controller
{
    public function buscaColaborador($cpf, $nome)
    {
        $buscaColaborador = TabelaVFunc::query();

        if (!empty($cpf)) {
            $buscaColaborador->where('numcpf', $cpf);
        } elseif (!empty($nome)) {
            $nomeColaborador = explode(' ', $nome);
            $buscaColaborador->where(function ($query) use ($nomeColaborador) {
                $query->where('nomfun', 'LIKE', '%'.$nomeColaborador[0].'%');
                if (isset($nomeColaborador[1])) {
                    $query->orWhere('nomfun', 'LIKE', '%' . $nomeColaborador[1] . '%');
                }
            });
        }

        $resultados = $buscaColaborador->get();

        return $resultados;
    }
}

<?php

/*TODO O SISTEMA ESTA SENDO USADO O Eloquent, PORÉM AQUI NÃO DEU POIS NAO CONSEGUI MONTAR ESSA MERDA DE SQL EM Eloquent, SE CASO CONSEGUIR PARABENS VC É O CARA!, OU A MULHER!  */

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaFatCliente;
use Illuminate\Support\Facades\DB;

class QueryFatCliente extends Controller
{
    public function buscaNomeCliente($cnpj)
    {
        $sql = DB::connection('oracle_apollo')->select("SELECT CAST(FPJ.CGC AS VARCHAR(14)) xcgccpf,
            fc.nome as xnome_empresa,
            'APOLLO' as xsistema,
            fc.fantasia as xfantasia
            FROM FAT_CLIENTE FC,
            FAT_PESSOA_JURIDICA FPJ
            WHERE FC.CLIENTE = FPJ.CLIENTE
            AND CAST(FPJ.CGC AS VARCHAR(14)) = ?
            AND ((FC.INATIVO_CONSULTAS = 'N') OR (FC.INATIVO_CONSULTAS IS NULL))
            AND FPJ.CGC NOT IN (0)", [$cnpj]);

        return $sql;
    }
}


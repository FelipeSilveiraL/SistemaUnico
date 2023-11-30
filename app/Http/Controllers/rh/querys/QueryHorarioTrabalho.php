<?php

namespace App\Http\Controllers\rh\querys;

use App\Http\Controllers\Controller;
use App\Models\rh\TabelaHorarioTrabalho;

class QueryHorarioTrabalho extends Controller
{
    public function buscaHorarioTrabalho($idHorario){

        $buscaHorarioT = TabelaHorarioTrabalho::leftJoin('EMPRESA as E', 'E.ID_EMPRESA', '=', 'Horario_trabalho.ID_EMPRESA')
        ->leftJoin('DEPARTAMENTO_RH as D', 'D.ID_DEPARTAMENTO', '=', 'Horario_trabalho.ID_DEPARTAMENTO')
        ->select(
            'Horario_trabalho.ID_HORARIO',
            'Horario_trabalho.SEGUNDA_SEXTA',
            'Horario_trabalho.SEGUNDA_SEXTA_ALMOCO',
            'Horario_trabalho.SABADO',
            'Horario_trabalho.SABADO_ALMOCO',
            'Horario_trabalho.SITUACAO',
            'E.NOME_EMPRESA',
            'E.ID_EMPRESA',
            'D.ID_DEPARTAMENTO',
            'D.NOME_DEPARTAMENTO'
        );

        if(!empty($idHorario)){
            $buscaHorarioT = $buscaHorarioT->where('id_horario', $idHorario);
        }

        $query = $buscaHorarioT->orderBy('Horario_trabalho.ID_HORARIO','DESC')
        ->get();


        $query->transform(

            function($item){
                $item->segunda_sexta = str_pad($item->segunda_sexta, 8, '0', STR_PAD_LEFT);
                $item->segunda_sexta_almoco = str_pad($item->segunda_sexta_almoco, 8, '0', STR_PAD_LEFT);
                $item->sabado = str_pad($item->sabado, 8, '0', STR_PAD_LEFT);
                $item->sabado_almoco = str_pad($item->sabado_almoco, 8, '0', STR_PAD_LEFT);

                return $item;
            }

        );


        return $query;
    }
}

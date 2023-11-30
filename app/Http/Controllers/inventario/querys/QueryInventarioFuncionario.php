<?php

namespace App\Http\Controllers\inventario\querys;

use App\Http\Controllers\Controller;
use App\Models\inventario\TabelaInventarioFuncionario;

class QueryInventarioFuncionario extends Controller
{
    public function buscaColaborador(){

        $sql = TabelaInventarioFuncionario::select('manager_inventario_funcionario.id_funcionario',
        'manager_inventario_funcionario.nome',
        'manager_inventario_funcionario.cpf',
        'MDF.nome AS funcao',
        'MDD.nome AS departamento',
        'MDE.nome AS empresa',
        'MDS.nome AS status',
        'manager_inventario_funcionario.status AS id_status',
        'manager_inventario_funcionario.funcao AS id_funcao',
        'manager_inventario_funcionario.departamento AS id_departamento',
        'manager_inventario_funcionario.empresa AS id_empresa',
        'manager_inventario_funcionario.deletar')
        ->leftJoin('manager_dropfuncao AS MDF', 'manager_inventario_funcionario.funcao', '=', 'MDF.id_funcao')
        ->leftJoin('manager_dropdepartamento AS MDD', 'manager_inventario_funcionario.departamento', '=', 'MDD.id_depart')
        ->leftJoin('manager_dropempresa AS MDE', 'manager_inventario_funcionario.empresa', '=', 'MDE.id_empresa')
        ->leftJoin('manager_dropstatus AS MDS', 'manager_inventario_funcionario.status', '=', 'MDS.id_status')
        ->orderBy('manager_inventario_funcionario.nome')

        ->get();

        return $sql;
    }
}

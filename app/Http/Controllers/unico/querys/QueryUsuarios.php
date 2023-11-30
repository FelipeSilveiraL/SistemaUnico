<?php

namespace App\Http\Controllers\unico\querys;

use App\Http\Controllers\Controller;
use App\Models\unico\TabelaUsuarios;

class QueryUsuarios extends Controller
{
    public function listaUsuarios($idUsuario)
    {

        $buscaUsuarios = TabelaUsuarios::leftJoin('cad_empresa', 'cad_empresa.id', 'usuarios.empresa')
            ->leftJoin('cad_depto', 'cad_depto.id', 'usuarios.depto')
            ->select('usuarios.*', 'cad_empresa.nome AS nome_empresa', 'cad_depto.nome AS nome_departamento');

        if ($idUsuario != null) {
            $buscaUsuarios = $buscaUsuarios->where('usuarios.id', $idUsuario);
        }

        $buscaUsuarios = $buscaUsuarios->get();

        return $buscaUsuarios;
    }

    public function buscaUsuario($email){
        $sql = TabelaUsuarios::where('email', $email)->get();

        return $sql;
    }
}

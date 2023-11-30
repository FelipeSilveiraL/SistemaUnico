<?php

namespace App\Http\Controllers\automacao\querys;

use App\Http\Controllers\Controller;
use App\Models\automacao\TabelaSelbettiUsers;

class QuerySelbettiUser extends Controller
{
    public function usuariosSelbetti($usuario){
        $sql = TabelaSelbettiUsers::where('usuario', $usuario);

        $result = $sql->first();

        return [
            'usuario' => $result ? $result->usuario : NULL
        ];
    }
}

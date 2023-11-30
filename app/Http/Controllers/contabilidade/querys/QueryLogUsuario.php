<?php

namespace App\Http\Controllers\contabilidade\querys;

use App\Http\Controllers\Controller;
use App\Models\contabilidade\TableLogUsuario;

class QueryLogUsuario extends Controller
{
    public function buscaLogUsuario()
    {
        $query = TableLogUsuario::leftjoin('usuarios as u', 'u.id', '=', 'contabilidade_log_usuario.id_usuario');

        $ajusteData = $query->OrderBy('contabilidade_log_usuario.data', 'DESC')
            ->get();

        $ajusteData->transform(
            function ($item) {

                if (!empty($item->data)) {
                    $item->data = date('d/m/Y H:i:s', strtotime($item->data));
                }

                return $item;
            }
        );

        return $ajusteData;
    }
}

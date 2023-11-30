<?php

namespace App\Http\Controllers\unico\querys;

use App\Http\Controllers\Controller;
use App\Models\unico\TabelaSistemasUser;

class QuerySistemasUser extends Controller
{
    public function listaSistemasUser($idUsuario){
        $buscaSisUser = TabelaSistemasUser::leftJoin('cad_sistemas', 'cad_sistemas.id', 'cad_sis_user.id_sistema')
        ->select('cad_sistemas.*');

        if(!empty($idUsuario)){
            $buscaSisUser = $buscaSisUser->where('cad_sis_user.id_usuario', $idUsuario);
        }else{
            $buscaSisUser = $buscaSisUser->where('cad_sis_user.id_usuario', empty(auth()->user()->id) ?: auth()->user()->id);
        }
        $buscaSisUser = $buscaSisUser->where('cad_sistemas.deletar', 0)
        ->get();


        return $buscaSisUser;
    }
}

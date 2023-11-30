<?php

namespace App\Http\Controllers\unico\querys;

use App\Http\Controllers\Controller;
use App\Models\unico\TabelaSistemas;
use Illuminate\Http\Request;

class QuerySistemas extends Controller
{
    public function listarSistemas(){
        $buscaSistemas = TabelaSistemas::where('deletar', 0)
        ->get();

        return $buscaSistemas;
    }
}

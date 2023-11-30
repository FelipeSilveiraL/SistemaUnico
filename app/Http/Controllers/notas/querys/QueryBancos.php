<?php

namespace App\Http\Controllers\notas\querys;

use App\Http\Controllers\Controller;
use App\Models\notas\TabelaBancos;
use Illuminate\Http\Request;

class QueryBancos extends Controller
{
    public function buscaBancos(){
        $sql = TabelaBancos::orderBy('banco')->get();

        return $sql;
    }
}

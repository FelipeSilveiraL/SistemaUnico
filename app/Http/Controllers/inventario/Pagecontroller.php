<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use App\Http\Controllers\inventario\querys\QueryInventarioFuncionario;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index()
    {
        return view('inventario.index');
    }

    public function colaborador()
    {
        $queryColaborador = new QueryInventarioFuncionario;
        $buscaColaborador = $queryColaborador->buscaColaborador();


        return view('inventario.colaborador', compact('buscaColaborador'));
        
    }
}

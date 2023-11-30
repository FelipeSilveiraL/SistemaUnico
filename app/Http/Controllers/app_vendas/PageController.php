<?php

namespace App\Http\Controllers\app_vendas;

use App\Http\Controllers\app_vendas\querys\QueryCentralAjuda;
use App\Http\Controllers\Controller;
use App\Models\app_vendas\TabelaCentralAjuda;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return view('app_vendas.index');
    }

    public function configTelas(){
        return view('app_vendas.configTelas');
    }

    public function centralAjuda(){

        $buscaCentralAjuda = new QueryCentralAjuda();
        $centralAjuda = $buscaCentralAjuda->centralAjuda($idTela = 1);

        return view('app_vendas.centralAjuda', compact('centralAjuda'));
    }

    public function salvarAjuda(Request $request){

        $insert = TabelaCentralAjuda::where('id', $request->id)
        ->update(
            [
                'crm' => $request->crm,
                'smart' => $request->smart,
                'logistica' => $request->logistica,
                'faturamento' => $request->faturamento,
                'entrega' => $request->entrega,
                'despachante' => $request->despachante,
                'pendencia' => $request->pendencia,
            ]
            );

        return redirect()->back()->with('success', 'Alterado com sucesso');
    }

}

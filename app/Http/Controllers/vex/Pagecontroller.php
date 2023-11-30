<?php

namespace App\Http\Controllers\vex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index()
    {

        return view('vex.index');
    }

    public function vistoriaParada()
    {

        return view('vex.vistoriaParada');
    }

    public function vistoriaLiberar()
    {
        return view('vex.vistoriaLiberar');
    }

    public function marcarVistoria(Request $request)
    {

        $token = 'AJS159';

        $resultado = marcarExportada($token, $request['numeroVistoria']);

        return redirect()->back()->with('success', $resultado['message']);
    }

    public function liberarPDF()
    {
        return view('vex.pdf');
    }

    public function liberarGerarPDF(Request $request){

        $token = 'AJS159';

        $resultado = gerarPDF($token, $request['numeroVistoria']);

        return redirect()->back()->with('success', 'PDF liberado com sucesso!');
    }
}

<?php

namespace App\Http\Controllers\rh;

use App\Http\Controllers\contabilidade\querys\QueryEmpresa;
use App\Http\Controllers\Controller;
use App\Http\Controllers\rh\querys\QueryDepartamentos;
use App\Http\Controllers\rh\querys\QueryHorarioTrabalho;
use App\Http\Controllers\rh\querys\QueryVFunc;
use App\Models\rh\TabelaHorarioTrabalho;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index()
    {
        return view('rh.index');
    }

    public function busca()
    {
        return view('rh.busca');
    }

    public function buscaCpf(Request $request)
    {

        $cpf = $request->cpf;
        $nome = $request->nomeCompleto;


        if ($cpf == null && $nome == null) {
            return redirect()->back()->with('success', 'Deve informar um CPF ou um NOME para efetuar a busca');
        } else {
            $queryVFunc = new QueryVFunc();
            $buscaCpf = $queryVFunc->buscaColaborador($cpf, $nome);

            return view('rh.busca', compact('buscaCpf'));
        }
    }

    public function horario($idHorario = null)
    {

        $queryHorariosT = new QueryHorarioTrabalho();
        $buscaHorarioT = $queryHorariosT->buscaHorarioTrabalho($idHorario);

        return view('rh.horario', compact('buscaHorarioT'));
    }

    public function novoHorario()
    {

        $queryDepartamentos = new QueryDepartamentos();
        $buscaDepartBpmgp = $queryDepartamentos->buscaDepartamento();

        $queryEmprpesa = new QueryEmpresa;
        $buscaEmpresa = $queryEmprpesa->buscaEmpresa($idempresa = null);


        return view('rh.novoHorario', compact('buscaDepartBpmgp', 'buscaEmpresa'));
    }

    public function salvar(Request $request)
    {

        $insereHorario = new TabelaHorarioTrabalho();

        $insereHorario->id_empresa = $request->empresa;
        $insereHorario->id_departamento = $request->departamento;
        $insereHorario->segunda_sexta = limparCPF($request->HoraInicioSemanal . $request->HoraFinalSemanal);
        $insereHorario->segunda_sexta_almoco = limparCPF($request->HoraInicioAlmocoSemanal . $request->HoraFinalAlmocoSemanal);
        $insereHorario->sabado = limparCPF($request->HoraInicioSabado . $request->HoraFinalSabado);
        $insereHorario->sabado_almoco = limparCPF($request->HoraInicioAlmocoSabado . $request->HoraFinalAlmocoSabado);
        $insereHorario->situacao = 'A';

        $insereHorario->save();

        return redirect()->route('rh.horario')->with('success', 'Horario adicionado com sucesso');
    }

    public function desativarHorario($idHorario = null)
    {

        if (!empty($idHorario)) {

            $acao = substr($idHorario, 0, 1);
            $id = substr($idHorario, 1);

            if ($acao == 'D') {

                $deletar = TabelaHorarioTrabalho::where('id_horario', $id)->update(['situacao' => 'D']);

                return redirect()->route('rh.horario')->with('success', 'Deletado com sucesso');
            } else {
                $ativar = TabelaHorarioTrabalho::where('id_horario', $id)->update(['situacao' => 'A']);

                return redirect()->route('rh.horario')->with('success', 'Ativado com sucesso');
            }
        }
    }

    public function editarHorario($idHorario = null)
    {

        $queryDepartamentos = new QueryDepartamentos();
        $buscaDepartBpmgp = $queryDepartamentos->buscaDepartamento();

        $queryBuscaHorario = new QueryHorarioTrabalho();
        $buscaHorario = $queryBuscaHorario->buscaHorarioTrabalho($idHorario);

        $queryEmpresa = new QueryEmpresa;
        $buscaEmpresa = $queryEmpresa->buscaEmpresa($idempresa = null);


        return view('rh.editarHorario', compact('buscaDepartBpmgp', 'buscaHorario', 'buscaEmpresa'));
    }

    public function updateHorario(Request $request, $idHorario = null)
    {

        if (!empty($idHorario)) {

            $atualizaHorario = TabelaHorarioTrabalho::find($idHorario);

            $atualizaHorario->id_empresa = $request->empresa;
            $atualizaHorario->id_departamento = $request->departamento;
            $atualizaHorario->segunda_sexta = limparCPF($request->HoraInicioSemanal . $request->HoraFinalSemanal);
            $atualizaHorario->segunda_sexta_almoco = limparCPF($request->HoraInicioAlmocoSemanal . $request->HoraFinalAlmocoSemanal);
            $atualizaHorario->sabado = limparCPF($request->HoraInicioSabado . $request->HoraFinalSabado);
            $atualizaHorario->sabado_almoco = limparCPF($request->HoraInicioAlmocoSabado . $request->HoraFinalAlmocoSabado);

            $atualizaHorario->save();

            return redirect()->back()->with('success', 'Editado com sucesso');
        }
    }
}

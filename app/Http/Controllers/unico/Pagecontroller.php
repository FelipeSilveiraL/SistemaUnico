<?php

namespace App\Http\Controllers\unico;

use App\Http\Controllers\Controller;
use App\Http\Controllers\unico\querys\QuerySistemas;
use App\Http\Controllers\unico\querys\QuerySistemasUser;
use App\Http\Controllers\unico\querys\QueryUsuarios;
use App\Models\unico\TabelaSistemas;
use App\Models\unico\TabelaSistemasUser;
use App\Models\unico\TabelaUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Pagecontroller extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logar(Request $request)
    {
        $credenciais = $request->only('username', 'password'); //salvando as credenciais em uma array

        $autenticandoUser = Auth::attempt($credenciais); //aplica a busca dentro do banco

        if (!$autenticandoUser) { //validando as informações
            return redirect()->route('login.index')->withErrors(['error' => 'Email ou senha invalidos']);
        }

        if (auth()->user()->deletar == 1) { //vendo se esta desativado
            return redirect()->route('login.index')->withErrors(['error' => 'Conta desativada']);
        }

        if(auth()->user()->alterar_senha_login == 1){
            return redirect()->route('login.alterar');
        }else{
            return redirect()->route('tela.index'); //tudo OK
        }
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login.index')->with(['success' => 'Deslogado!']);
    }

    public function alterar(){
        return view('alterarPassword');
    }

    public function atualizarSenha($idPerfil){

        $user =  TabelaUsuarios::find($idPerfil);

        $senha = request()->input('passwordConfirm');

        $user->password = bcrypt($senha);
        $user->alterar_senha_login = 0;

        $user->save();

        return redirect()->route('login.index')->with(['success' => 'Dados atualizados, basta logar novamente!']);
    }

    public function index($idUsuario = null)
    {
        $querySistemasUser = new QuerySistemasUser();
        $buscaSistemasUser = $querySistemasUser->listaSistemasUser($idUsuario);

        return view('index', compact('buscaSistemasUser'));
    }

    public function atualizaPerfil($idPerfil = null)
    {

        $user =  TabelaUsuarios::find($idPerfil);

        $user->nome = request()->input('nomeUsuario');
        $user->email = request()->input('email');
        $user->cpf = request()->input('cpf');
        $user->empresa = request()->input('empresa');
        $user->depto = request()->input('departamento');
        $user->username = request()->input('usuario');

        $senha = request()->input('senha');

        if (!empty($senha)) {
            $user->password = bcrypt($senha);
        }

        $user->save();

        return redirect()->route('login.index')->withErrors(['error' => 'Dados atualizados, basta logar novamente!']);
    }

    public function usuarios($idUsuario = null)
    {
        $queryBuscaUsuario = new QueryUsuarios();
        $buscaUsuarios = $queryBuscaUsuario->listaUsuarios($idUsuario);

        $queryBuscaSistema = new QuerySistemas();
        $buscaSistema = $queryBuscaSistema->listarSistemas();

        return view('usuarios', compact('buscaUsuarios', 'buscaSistema'));
    }

    public function editarUser($idUsuario = null)
    {
        if (!empty($idUsuario)) {
            
            $queryEditarUsuario = new QueryUsuarios();
            $buscaUsuario = $queryEditarUsuario->listaUsuarios($idUsuario);

            $querySistemas = new QuerySistemas();
            $buscaSistemas = $querySistemas->listarSistemas();

            $queryBuscaSistemaUser = new QuerySistemasUser();
            $buscaSistemasUser = $queryBuscaSistemaUser->listaSistemasUser($idUsuario);

            return view('editar', compact('buscaUsuario', 'buscaSistemas', 'buscaSistemasUser'))->with('success', 'Usuario editado com sucesso');
        } else {
            return view('login');
        }
    }

    public function inserindoUsuario(Request $request, $idUsuario = null)
    {

        //Inserir o usuario
        $insertUser = empty($idUsuario) ? new TabelaUsuarios() : TabelaUsuarios::find($idUsuario);

        $insertUser->nome = $request->nomeUsuario;
        $insertUser->email = $request->email;
        $insertUser->cpf = $request->cpf;
        $insertUser->empresa = $request->empresa;
        $insertUser->depto = $request->departamento;
        $insertUser->username = $request->usuario;
        if($request->senha != null){
            $insertUser->password = bcrypt($request->senha);
        }
        $insertUser->alterar_senha_login = $request->trocarSenha == null ? 0 : 1;
        $insertUser->admin = $request->admin == null ? 0 : 1;

        $insertUser->save();

        //limpando todos os sitemas antes de salvar os novos
        empty($idUsuario) ?: TabelaSistemasUser::where('id_usuario', $idUsuario)->delete();

        //inserindo sistemas
        $idusuarioInserido = $insertUser->id; //ID esta vindo da linha 117 - pegando da tabela autoincremente campo 'id'

        $idSistemas = $request->input('sistemas');

        if (!empty($idSistemas)) {
            foreach ($idSistemas as $sistemas) {
                $insertUserSistemas = new TabelaSistemasUser([
                    'id_sistema' => $sistemas,
                    'id_usuario' => $idusuarioInserido
                ]);
                $insertUserSistemas->save();
            }
        }

        return redirect()->route('index.usuario')->with(empty($idUsuario ? ['success' => 'Adicionado com sucesso'] : ['success' => 'Editado com sucesso']));
    }

    public function sistemas()
    {
        $querySistemas = new QuerySistemas();
        $buscaSistemas = $querySistemas->listarSistemas();

        return view('sistemas', compact('buscaSistemas'));
    }

    public function ativarDesativar($idUsuario)
    {

        if (!empty($idUsuario)) {

            $acao = substr($idUsuario, 0, 1);
            $idUsuario = substr($idUsuario,  1);

            $atualiza = TabelaUsuarios::find($idUsuario);

            if ($acao == 'D') {
                $atualiza->update(['deletar' => 1]); //desativar
                return redirect()->back()->with('success', 'Usuário desativado com sucesso');
            } else {
                $atualiza->update(['deletar' => 0]); //ativar
                return redirect()->back()->with('success', 'Usuário ativado com sucesso');
            }

        } else {
            return view('login');
        }
    }

    public function inserirSistema(Request $request)
    {

        $insert = new TabelaSistemas();

        $insert->nome = $request->nome;
        $insert->endereco = $request->endereco;

        $insert->save();

        return redirect()->back()->with('success', 'Sistema adicionado com sucesso');

    }

    public function excluirSistema($idSistema)
    {
        if(!empty($idSistema)){

            $deletar = TabelaSistemas::find($idSistema);
            $deletar->delete();

            $deletarUser = TabelaSistemasUser::where('id_sistema', $idSistema);
            $deletarUser->delete();

            return redirect()->back()->with('success', 'Sistema deletado com sucesso');
        }

    }
}

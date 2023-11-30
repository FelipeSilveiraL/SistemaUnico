<?php

namespace App\Http\Controllers\automacao;

use App\Http\Controllers\automacao\querys\QueryCadUsuario;
use App\Http\Controllers\automacao\querys\QueryEmpresaUsuarios;
use App\Http\Controllers\automacao\querys\QueryFatVendedorApollo;
use App\Http\Controllers\automacao\querys\QueryGerUsuariosApollo;
use App\Http\Controllers\automacao\querys\QuerySelbettiUser;
use App\Http\Controllers\automacao\querys\QueryVetorUser;
use App\Http\Controllers\automacao\querys\QueryVFunc;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\automacao\cad_usuario_api;
use App\Models\automacao\TabelaRelatorioUser;
use App\Models\automacao\TabelaSelbettiUsers;
use App\Models\automacao\TabelaVetorUsers;
use GuzzleHttp\Client;

class Pagecontroller extends Controller
{
    public function abreviador()
    {
        return view('automacao.abreviador');
    }

    public function importarUsuariosApi()
    {
        //excluir a tabela cad_usuario_api
        $drop = 'DROP TABLE cad_usuario_api';
        DB::connection('mysql_unico')->statement($drop);

        //criar a tabela cad_usuario_api
        $drop = 'CREATE TABLE cad_usuario_api (
                id INT NOT NULL AUTO_INCREMENT,
                nome VARCHAR(255) NOT NULL,
                cpf VARCHAR(12),
                ativo VARCHAR(10),
                sistema VARCHAR(10),
                PRIMARY KEY (id))';
        DB::connection('mysql_unico')->statement($drop);

        //COLETANDO OS USUARIO DO APOLLO -> salvar na cad_usuario_api

        //GER USUARIO
        $buscarApollo = new QueryGerUsuariosApollo;
        $buscarApollo = $buscarApollo->buscaUsuariosApollo();

        foreach ($buscarApollo as $usuarioApollo) {

            //Buscar se já nao foi salvo
            $apolloU = new QueryCadUsuario();
            $apolloU = $apolloU->buscarUsuario($usuarioApollo['cpf']);

            if ($apolloU['nome'] == NULL) {

                //salvando da GER_USUARIO
                $insertUsuario = new cad_usuario_api();

                $insertUsuario->nome = $usuarioApollo['nome'] ? $usuarioApollo['nome'] : '----';
                $insertUsuario->cpf = $usuarioApollo['cpf'];
                $insertUsuario->ativo = $usuarioApollo['ativo'];
                $insertUsuario->sistema = 'apollo';

                $insertUsuario->save();
            }
        }

        //FAT VENDEDOR
        $buscaApolloVen = new QueryFatVendedorApollo();
        $buscaApolloVen = $buscaApolloVen->buscarUsuario();

        foreach ($buscaApolloVen as $usuarioApolloVen) {

            //Buscar se já nao foi salvo
            $apolloV = new QueryCadUsuario();
            $apolloV = $apolloV->buscarUsuario($usuarioApolloVen['cpf']);

            if ($apolloV == NULL) {

                $insertUsuario = new cad_usuario_api();

                $insertUsuario->nome = $usuarioApolloVen['nome'] ? $usuarioApolloVen['nome'] : '----';
                $insertUsuario->cpf = $usuarioApolloVen['cpf'];
                $insertUsuario->ativo = $usuarioApolloVen['ativo'];
                $insertUsuario->sistema = 'apollo';

                $insertUsuario->save();
            }
        }

        //COLETANDO OS USUARIO DO NBS -> salvar na cad_usuario_api

        $buscaUsuariosNbs = new QueryEmpresaUsuarios();
        $buscaUsuariosNbs = $buscaUsuariosNbs->buscaUsuario();

        foreach ($buscaUsuariosNbs as $usuariosNbs) {

            //Buscar se já nao foi salvo
            $nbsU = new QueryCadUsuario();
            $nbsU = $nbsU->buscarUsuario($usuariosNbs['cpf']);

            if ($nbsU['nome'] == NULL) {

                //salvando da GER_USUARIO
                $insertUsuario = new cad_usuario_api();

                $insertUsuario->nome = $usuariosNbs['nome'] ? $usuariosNbs['nome'] : '----';
                $insertUsuario->cpf = $usuariosNbs['cpf'] ? $usuariosNbs['cpf'] : '----';
                $insertUsuario->ativo = demitidosNBS($usuariosNbs['demitido']);
                $insertUsuario->sistema = 'nbs';

                $insertUsuario->save();
            }
        }

        die('Usuarios salvos na cad_usuario_api');
    }

    public function importarUsuarioVetorSelbetti()
    {
        //TABELA VETOR
        tabelaVetor(1);

        //TABELA SELBETTI
        tabelaSelbetti(1);

        //TABELA RELATORIO
        tabelaRelatorio(1);

        //Coletando os funcionarios na vetor que nao estão como demitido
        $funcionariosVetor = new QueryVFunc();
        $funcionariosVetor = $funcionariosVetor->buscaColaborador();

        foreach ($funcionariosVetor as $colaboradorVetor) {
            $insert = new TabelaVetorUsers();

            $insert->nome = $colaboradorVetor['nomfun'];
            $insert->usuario = loginSelbetti($colaboradorVetor['nomfun'], $colaboradorVetor['numcpf']);
            $insert->email = emailSelbetti($colaboradorVetor['emacom']);
            $insert->dessit = $colaboradorVetor['dessit'];
            $insert->save();
        }

        //Coletando os funcionarios na selbetti
        $tokenSelbettiUser = 'integra.usuario'; //Usuario para solicitar o Token junto a selbetti
        $tokenSelbettiPasswd = 'passwshare'; //Senha do usuario de token
        $dsCliente = 'mobile';
        $dsChaveAutenticacao = 'NnLHcy3ilNdOs1+JJJysCJbhOX9cWOVkn1jj5MzdViA=';

        $colaboradorSelbetti = new Client();

        $aplicandoAPI = $colaboradorSelbetti->request(
            'POST',
            'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v2/Usuario/ListarUsuarios',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'dsCliente' => $dsCliente,
                    'dsChaveAutenticacao' => $dsChaveAutenticacao,
                    'tokenUsuario' => tokenSelbetti($tokenSelbettiUser, $tokenSelbettiPasswd, $dsCliente, $dsChaveAutenticacao),
                    'Content-Length' => '0'
                ]
            ]
        );

        $colaboradoresSel = json_decode($aplicandoAPI->getBody(), true);

        foreach ($colaboradoresSel['listaUsuarios'] as $funcionarioSelbetti) {
            $insert = new TabelaSelbettiUsers();

            $insert->nome = $funcionarioSelbetti['dsNome'];
            $insert->usuario = $funcionarioSelbetti['dsLogin'];
            $insert->email = $funcionarioSelbetti['dsEmail'];
            $insert->stAtivo = $funcionarioSelbetti['stAtivo'];
            $insert->idTipoUsuario = $funcionarioSelbetti['idTipoUsuario'];
            $insert->cdUsuario = $funcionarioSelbetti['cdUsuario'];

            $insert->save();
        }


        // INICIANDO A VERIFICAÇÃO
        $usuariosVetor = new QueryVetorUser;
        $usuariosVetor = $usuariosVetor->usuariosVetor();

        foreach ($usuariosVetor as $vetorUser) {

            //verificar se o usuario da vetor esta dentro da selbetti
            $verificando = new QuerySelbettiUser;
            $verificando = $verificando->usuariosSelbetti($vetorUser['usuario']);

            if ($verificando['usuario'] == NULL) {
                //CADASTRAR NA SELBETTI

                //Salvar relatorio para mandar email
                $insert = new TabelaRelatorioUser();

                $insert->nome = $vetorUser['nome'];
                $insert->usuario = $vetorUser['usuario'];
                $insert->email = $vetorUser['email'];
                $insert->dessit = $vetorUser['dessit'];

                $insert->save();

                //APLICAR API DE INSERÇÃO
                $cadastrandoUsuario = cadastrarUsuarioSelbetti($vetorUser['nome'], $vetorUser['usuario'], $vetorUser['email'], $tokenSelbettiUser, $tokenSelbettiPasswd, $dsCliente, $dsChaveAutenticacao);

            }
        }

        return redirect()->route('enviar-email');
    }

}

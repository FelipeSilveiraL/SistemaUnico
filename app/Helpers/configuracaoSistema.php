<?php

use App\Http\Controllers\contabilidade\querys\QueryEmpresa;
use App\Http\Controllers\notas\querys\QueryCadAnexo;
use App\Http\Controllers\notas\querys\QueryCadBancos;
use App\Http\Controllers\notas\querys\QueryDepartamentoNF;
use App\Http\Controllers\notas\querys\QueryEmpresaDepartamentoNF;
use App\Models\unico\TabelaSistemasUser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//AJUSTA O NOME QUE FICARA NO SISTEMA
function nomeSistema($nome)
{

    $nome = explode('/', $nome);

    switch ($nome[0]) {
            //telas do unicos para serem ingoradas
        case 'usuarios':
            $nome = 'unico';
            break;

        case 'sistemas':
            $nome = 'unico';
            break;

        case 'index':
            $nome = 'unico';
            break;

        case 'api':
            $nome = 'unico';
            break;

        default: //demais telas
            $nome = $nome[0];
            break;
    }

    $nome = str_replace('-', ' ', $nome);
    $nome = strtoupper($nome);

    return $nome;
}
//AJUSTES PARA MOSTRA O MENU CORRETO DE CADA SISTEMA
function caminhoMenu($caminho)
{

    $caminho = explode('/', $caminho);

    if (empty($caminho[1])) {
        $caminho = 'layout.menu';
    } else {
        //palavras para serem ignoradas
        switch ($caminho[0]) {

            case 'editar':
                $caminho = 'layout.menu';
                break;

            default:
                $caminho = $caminho[0] . '.' . 'layout.menu';
                break;
        }
    }
    return $caminho;
}

function limparCPF($cpf)
{
    $str = str_replace('.', '', $cpf);
    $str = str_replace('-', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('/', '', $str);

    return $str;
}

function formatarHorario($horario)
{

    $horaInicial = substr($horario, 0, 2);
    $minutoInicial = substr($horario, 2, 2);

    $horaFinal = substr($horario, 4, 2);
    $minutoFinal = substr($horario, 6, 2);

    $horaFomatada = $horaInicial . ":" . $minutoInicial . " ás " . $horaFinal . ":" . $minutoFinal;

    return $horaFomatada;
}

function mesAtualAbreviado()
{

    $dataAtual = Carbon::now();

    $dataAtual->locale('pt_BR');

    $mesAbreviado = $dataAtual->isoFormat('MMMM - YYYY');

    return $mesAbreviado;
}


function horaInicial($variavel)
{
    $hora = substr($variavel, 0, 2);
    return $hora;
}

function minutoInicial($variavel)
{
    $minuto = substr($variavel, 2, 2);
    return $minuto;
}

function horaFinal($variavel)
{
    $hora = substr($variavel, 4, 2);
    return $hora;
}

function minutoFinal($variavel)
{
    $minuto = substr($variavel, 6, 2);
    return $minuto;
}

function formatCnpj($cnpj)
{

    $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
    $formattedCnpj = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);

    return $formattedCnpj;
}

function permissaoTela($idUsuario, $tela)
{
    $resultado = TabelaSistemasUser::select('cad_sis_user.id')
        ->leftJoin('cad_sistemas as cs', 'cad_sis_user.id_sistema', '=', 'cs.id')
        ->where('cad_sis_user.id_usuario', $idUsuario)
        ->where('cs.nome', 'like', '%' . $tela . '%')
        ->exists(); // Retorna true se houver resultados, false caso contrário.

    return $resultado;
}

function servidorLocal($ip)
{

    if ($ip == "10.100.1.217") {

        $dns = 'rede.paranapart.com.br';
    } else {

        $dns = $_SERVER['SERVER_ADDR'];
    }

    return $dns;
}

//função API webhook
function contrato($idContrato)
{
    /* $string = explode('-', $idContrato); */
    $string = substr($idContrato, 0, 7);
    /* return $string[0]; */
    return $string;
}

function linha($idLinha)
{
    /* $string = explode('-', $idLinha);
    return $string[1]; */

    $string = substr($idLinha, 7, 8);
    return $string;
}

function ternario($ternario)
{
    if ($ternario === '') {
        return NULL;
    } else {
        return $ternario;
    }
}

function hora($hora)
{
    $horas = explode(':', $hora);

    return ($horas[0] . ":" . $horas[1]);
}

function removerEspacosBrancos($string)
{
    $semEspacos = str_replace(' ', '', $string);

    return $semEspacos;
}

function marcarExportada($token, $vistoria)
{

    $informa = new Client();
    $retorno = $informa->request('POST', 'https://api.vexsoft.com.br/empresa/' . $token . '/vistorias/' . $vistoria . '/exportada');
    $dado = json_decode($retorno->getBody(), true);

    return $dado;
}

function gerarPDF($token, $vistoria)
{

    $informa = new Client();
    $retorno = $informa->request('GET', 'https://api.vexsoft.com.br/empresa/' . $token . '/vistorias/' . $vistoria . '/pdf');
    $dado = json_decode($retorno->getBody(), true);

    return $dado;
}

function vistoriaImportada($id_contrato, $id_linha, $embarque_desembarque)
{
    $log = new \stdClass();
    $log->contrato = $id_contrato;
    $log->linha = $id_linha;
    $log->procedimento = $embarque_desembarque;
    $log->mensagem = "Vistoria importada com sucesso!";

    return response()->json($response = ['alerta' => $log], 200);
}

function demitidosNBS($situacao)
{

    if ($situacao == NULL or $situacao == 'N') {
        $situacao = 'S';
    } else {
        $situacao = 'N';
    }

    return $situacao;
}

function tokenSelbetti($user, $password, $dsCliente, $dsChaveAutenticacao)
{
    //GERANDO TOKEN USUARIO
    $tokenSelbetti = new Client();

    $data = ['dsUsuario' => $user, 'dsSenha' => $password];

    $jsonData = json_encode($data);

    $aplicandoAPI = $tokenSelbetti->request('POST', 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v3/Usuario/ValidarLogin', [
        'headers' => [
            'Content-Type' => 'application/json',
            'dsCliente' => $dsCliente,
            'dsChaveAutenticacao' => $dsChaveAutenticacao
        ],

        'body' => $jsonData
    ]);

    $tokenSelbetti = json_decode($aplicandoAPI->getBody(), true);

    return $tokenSelbetti['tokenUsuario'];
}

function tabelaSelbetti($acao)
{

    //ação 1 vai excluir e criar, já a 2 apenas excluir

    if ($acao == 1) {

        //EXCLUIR/CRIAR SELBETTI

        if (Schema::connection('mysql_unico')->hasTable('selbetti_users')) {
            // A tabela existe, então podemos excluí-la com segurança
            $sql = "DROP TABLE selbetti_users";

            DB::connection('mysql_unico')->statement($sql);
        }

        $tabelaSelbetti = "CREATE TABLE selbetti_users (
            id INT NOT NULL AUTO_INCREMENT,
            nome VARCHAR(100) NULL,
            usuario VARCHAR(100) NULL,
            email VARCHAR(100) NULL,
            stAtivo VARCHAR(100) NULL,
            idTipoUsuario VARCHAR(100) NULL,
            cdUsuario VARCHAR(100) NULL,
            PRIMARY KEY (id))";
        DB::connection('mysql_unico')->statement($tabelaSelbetti);
    } else if ($acao == 2) {

        //EXCLUIR
        $tabelaSelbetti = 'DROP TABLE selbetti_users';
        DB::connection('mysql_unico')->statement($tabelaSelbetti);
    }
}

function tabelaVetor($acao)
{
    //ação 1 vai excluir e criar, já a 2 apenas excluir
    if ($acao == 1) {

        //EXCLUIR/CRIAR VETOR
        if (Schema::connection('mysql_unico')->hasTable('vetor_users')) {
            $tabela = 'DROP TABLE vetor_users';
            DB::connection('mysql_unico')->statement($tabela);
        }

        $tabela = "CREATE TABLE vetor_users (
            id INT NOT NULL AUTO_INCREMENT,
            nome VARCHAR(100) NULL,
            usuario VARCHAR(100) NULL,
            email VARCHAR(100) NULL,
            dessit VARCHAR(100) NULL,
            PRIMARY KEY (id))";
        DB::connection('mysql_unico')->statement($tabela);
    } else if ($acao == 2) {

        //EXCLUIR
        $tabela = 'DROP TABLE vetor_users';
        DB::connection('mysql_unico')->statement($tabela);
    }
}

function tabelaRelatorio($acao)
{

    //ação 1 vai excluir e criar, já a 2 apenas excluir

    if ($acao == 1) {

        if (Schema::connection('mysql_unico')->hasTable('relatorio_users')) {
            //EXCLUIR/CRIAR VETOR
            $tabela = 'DROP TABLE relatorio_users';
            DB::connection('mysql_unico')->statement($tabela);
        }

        $tabela = "CREATE TABLE relatorio_users (
            id INT NOT NULL AUTO_INCREMENT,
            nome VARCHAR(100) NULL,
            usuario VARCHAR(100) NULL,
            email VARCHAR(100) NULL,
            dessit VARCHAR(100) NULL,
            PRIMARY KEY (id))";
        DB::connection('mysql_unico')->statement($tabela);
    } else if ($acao == 2) {

        //EXCLUIR
        $tabela = 'DROP TABLE relatorio_users';
        DB::connection('mysql_unico')->statement($tabela);
    }
}

function loginSelbetti($nome, $cpf)
{

    $primeirosDigitosCPF = substr(str_replace('.', '', $cpf), '0', '6');

    $inicioNome = explode(' ', trim($nome));

    $login = strtolower($inicioNome[0] . "." . $primeirosDigitosCPF);

    return $login;
}

function emailSelbetti($email)
{
    $dominios = array(
        "@gruposervopa.com.br",
        "@hyundaisevec.com.br",
        "@redwheelharley-davidson.com.br",
        "@hondaprixx.com.br",
        "@protectaseguros.com.br",
        "@consorcioservopa.com.br",
        "@audicentercascavel.com.br",
        "@audicentercuritiba.com.br",
        "@audicentermaringa.com.br",
        "@brisapropaganda.com.br",
        "@carwaysul.com.br",
        "@cascavelharley-davidson.com.br",
        "@conseorcioservopa.com.br",
        "@dijonpeugeot.com.br",
        "@dijonveiculos.com.br",
        "@ducaticuritiba.com.br",
        "@gruposervopa.com.br",
        "@hondaprixx.com.br",
        "@hyundaisevec.com.br",
        "@lemansautomoveis.com.br",
        "@lyonveiculos.com.br",
        "@openpointvolvocars.com.br",
        "@passionveiculos.com.br",
        "@redwheelsharley-davidson.com.br",
        "@ribeiraopretohd.com.br",
        "@servopa.com.br",
        "@servopacaminhoes.com.br",
        "@theoneharley-davidson.com.br",
        "@triumphcwb.com.br",
        "@triumphnorth.com.br",
        "@vecodil.com.br",
        "@volvocascavel.com.br"
    );

    $strEmail = strrchr($email, '@');

    if (in_array($strEmail, $dominios)) {
        $email = $email;
    } else {
        $email = 'email_alterar@servopa.com.br';
    }

    return $email;
}

function cadastrarUsuarioSelbetti($nome, $usuario, $email, $user, $password, $dsCliente, $dsChaveAutenticacao)
{

    // Crie uma instância do cliente Guzzle
    $client = new Client();

    // Define a URL de destino
    $urlInserirUsuarios = 'https://appsmart.gruposervopa.com.br/smartshare/SmartShareAPI/api/v3/Usuario/InserirUsuario';

    // Define os dados do usuário em um array associativo
    $userData = [
        "idTipoUsuario" => 3,
        "dsNome" => $nome,
        "dsLogin" => $usuario,
        "dsSenha" => "Servopa@123",
        "dsEmail" => $email,
        "dsImpressaoDigital" => "",
        "dsTelefone" => "",
        "vlRamal" => "",
        "cdPapelPrincipal" => 100,
        "cdAreaPrincipal" => 1012,
        "cdPastaInicial" => 1,
        "idTipoLogin" => 0,
        "idVisaoInicialWF" => 1,
        "idVisaoInicial" => 1,
        "stPermiteTrocarVisaoInicial" => true,
        "vlDiasTrocarSenha" => 999,
        "stTrocarSenhaProximoLogin" => false,
        "stAusente" => false,
        "stAtivo" => true,
        "stMobile" => false,
        "stIndexador" => false,
        "stUsuarioAD" => false
    ];

    // Define os cabeçalhos HTTP
    $headers = [
        'dsCliente' => $dsCliente,
        'dsChaveAutenticacao' => $dsChaveAutenticacao,
        'tokenUsuario' => tokenSelbetti($user, $password, $dsCliente, $dsChaveAutenticacao),
        'Content-Type' => 'application/json'
    ];

    // Realiza a solicitação POST usando GuzzleHttp\Client
    $response = $client->request('POST', $urlInserirUsuarios, [
        'headers' => $headers,
        'json' => $userData, // Envia os dados como JSON
    ]);

    // Verifica a resposta
    if ($response->getStatusCode() == 200) {
        // A solicitação foi bem-sucedida (código 200)
        $responseData = json_decode($response->getBody(), true);
        // Faça algo com os dados da resposta, se necessário
    } else {
        // A solicitação não foi bem-sucedida
        $responseData = $response->getBody()->getContents();
        // Trate o erro de acordo com as necessidades do seu aplicativo
    }

    return $responseData;
}

//NOTAS

function layoutContador($idStatus)
{
    switch ($idStatus) {
        case '1':
            $cor = 'alert-primary';
            $nome = 'Aguardando';
            break;

        case '2':
            $cor = 'alert-warning';
            $nome = 'Pendentes';
            break;

        case '3':
            $cor = 'alert-success';
            $nome = 'Lançadas';
            break;

        default:
            $cor = 'alert-danger';
            $nome = 'Erros';
            break;
    }

    return ['cor'  => $cor, 'nome' => $nome];
}

function pegarAnexos($idNota)
{
    $queryAnexo = new QueryCadAnexo;
    $buscaAnexo = $queryAnexo->buscaAnexo($idNota);

    $notas = [];
    $boletos = [];

    foreach ($buscaAnexo as $anexo) {

        $tipoDocumento = substr($anexo['url_nota'], 14, 1);

        if ($tipoDocumento === 'b') {

            $boletos[] = substr($anexo['url_nota'], 3);
        } elseif ($tipoDocumento === 'n') {

            $notas[] = substr($anexo['url_nota'], 3);
        }
    }

    return ['notas' => $notas, 'boletos' => $boletos];
}

function nomeNota($nota)
{
    $string = substr($nota, 27);

    return $string;
}

function nomeBoleto($boleto)
{
    $string = substr($boleto, 29);

    return $string;
}

function bancos($cpfcnpjFornecedor, $id_usuario, $id_filial)
{
    $queryBanco = new QueryCadBancos();
    $dadosBancarios = $queryBanco->buscaBanco($cpfcnpjFornecedor, $id_usuario, $id_filial);

    return [
        'nome_banco' => $dadosBancarios['nome_banco'],
        'agencia' => $dadosBancarios['agencia'],
        'conta' => $dadosBancarios['conta'],
        'digito' => $dadosBancarios['digito']
    ];
}

function periodicidade($id)
{
    switch ($id) {
        case '1':
            return 'AVULSA';
            break;

        case '5':
            return 'ANUAL';
            break;
        case '7':
            return 'AVULSA FUNILARIA';
            break;

        case '3':
            return 'BIMESTRAL';
            break;
        case '2':
            return 'MENSAL';
            break;

        case '4':
            return 'SEMESTRAL';
            break;
        case '6':
            return 'TRIAGEM';
            break;
    }
}

function departamentosNota($id)
{

    if ($id == 0) {
        $resultado = '<option value="0">NÃO</option>';
    } else {
        $resultado = '<option value="1">SIM</option>';
    }

    return $resultado;
}

function dataFormulario($dataFormulario)
{
    $data = explode('/', $dataFormulario);

    // Check if the array has at least 3 elements (day, month, year)
    if (count($data) < 3) {
        return $dataFormulario; // Return the original input if it's not in the expected format
    }

    // Check if the year part is not empty
    if (!empty($data[2])) {
        return $data[2] . '-' . $data[1] . '-' . $data[0]; // Format as 'yyyy-mm-dd'
    } else {
        return $dataFormulario; // Return the original input if the year part is empty
    }
}


function carimbar($carimbar)
{

    if ($carimbar == 1) {
        return 'checked';
    }
}

function anexosNotas($idNota)
{
    $queryAnexo = new QueryCadAnexo();
    $dadosAnexo = $queryAnexo->buscaAnexo($idNota);

    $notas = [];
    $boletos = [];

    foreach ($dadosAnexo as $anexo) {
        $tipoDocumento = substr($anexo['url_nota'], 14, 1);

        if ($tipoDocumento === 'b') {

            $boletos[] = '
            <tr>
                <td>
                <a href="../../public/notas/' . substr($anexo['url_nota'], 3) . '" target="_blank" rel="noopener noreferrer">' . substr($anexo['url_nota'], 32) . '</a>
                </td>
                <td>BOLETO</td>
                <td>
                <a href="' . url('notas/deletarDocumento', ['ID' => $anexo['ID']]) . '" title="Excluir" class="btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                </td>
            </tr>';
        } elseif ($tipoDocumento === 'n') {

            $notas[] = '
            <tr>
                <td>
                 <a href="../../public/notas/' . substr($anexo['url_nota'], 3) . '" target="_blank" rel="noopener noreferrer">' . substr($anexo['url_nota'], 30) . '</a>
                </td>
                <td>NOTA FISCAL</td>
                <td>
                    <a href="' . url('notas/deletarDocumento', ['ID' => $anexo['ID']]) . '" title="Excluir" class="btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                </td>
            </tr>';
        }
    }

    return ['notas' => $notas, 'boletos' => $boletos];
}

function buscaNome($idDepartamento)
{

    $queryBusca = new QueryDepartamentoNF;
    return $queryBusca->buscaNomeDepartamento($idDepartamento)[0]['nome_departamento'];
}

function buscaNomeEmpresa($idEmpresa)
{

    $queryBusca = new QueryEmpresa;
    return $queryBusca->buscaEmpresa($idEmpresa, $cnpjFilial = null)[0]['nome_empresa'];
}

function porcentagem($stingPontuacao)
{
    $stingPontuacao = str_replace(',', '.', $stingPontuacao);

    return trim($stingPontuacao);
}

function valorMonetario($stingPontuacao)
{
    $stingPontuacao = str_replace('.', '', $stingPontuacao);
    $stingPontuacao = str_replace(',', '.', $stingPontuacao);

    return trim($stingPontuacao);
}

function porcentagem_nx($valor, $porcentagem)
{
    return ($valor * $porcentagem) / 100;
}

function tipoPagamento($tipo)
{

    switch ($tipo) {
        case '1':
            $tipo = '<option value="1">Boleto</option>';
            break;
        case '2':
            $tipo = '<option value="2">Depósito Bancário</option>';
            break;

        default:
            $tipo = '<option value="">-----------------</option>';
            break;
    }

    return $tipo;
}

function tipoVencimento($tipo)
{

    switch ($tipo) {
        case '1':
            $tipo = '<option value="1">Nota Fiscal</option>';
            break;
        case '2':
            $tipo = '<option value="2">Somatório</option>';
            break;

        default:
            $tipo = '<option value="3">Fixo</option>';
            break;
    }

    return $tipo;
}

function buscaDepartamentoCusto($idFilial)
{

    $query =  new QueryEmpresaDepartamentoNF;
    $result = $query->buscaDepartamento($idFilial);

    $option = '';

    foreach ($result as $departamento) {

        $option .= '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nome_departamento'] . '</option>';
    }

    return $option;
}

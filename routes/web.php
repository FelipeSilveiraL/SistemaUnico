<?php

use App\Http\Controllers\app_vendas\PageController as App_vendasPageController;
use App\Http\Controllers\automacao\EmailController;
use App\Http\Controllers\automacao\Pagecontroller as AutomacaoPagecontroller;
use App\Http\Controllers\blog\Pagecontroller as BlogPagecontroller;
use App\Http\Controllers\contabilidade\Pagecontroller as ContabilidadePagecontroller;
use App\Http\Controllers\inventario\Pagecontroller as InventarioPagecontroller;
use App\Http\Controllers\notas\Pagecontroller as NotasPagecontroller;
use App\Http\Controllers\rh\Pagecontroller as RhPagecontroller;
use App\Http\Controllers\unico\Pagecontroller;
use App\Http\Controllers\vex\Pagecontroller as VexPagecontroller;
use Illuminate\Support\Facades\Route;

/* ################ UNICO ################ */

/* ------------------- GRUPO DE ROTAS PARA O LOGIN ------------------- */
Route::controller(Pagecontroller::class)->group(function (){
    Route::get('/', 'login')->name('login.index');
    Route::post('/logar','logar')->name('login.logar');
    Route::get('/logout', 'destroy')->name('login.destroy');
    Route::get('/alterarPassword', 'alterar')->name('login.alterar');
});

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('index', [Pagecontroller::class, 'index'])->name('tela.index')->middleware('loaduservariables');
Route::get('usuarios', [Pagecontroller::class, 'usuarios'])->middleware('loaduservariables')->name('index.usuario');
Route::get('sistemas', [Pagecontroller::class, 'sistemas'])->name('index.sistemas')->middleware('loaduservariables');
Route::get('editar/{idUsuario?}', [Pagecontroller::class, 'editarUser'])->name('editar.user')->middleware('loaduservariables');

/* ------------------- ROTAS DE ALTERACAO VIA BANCO DE DADOS ------------------- */

//POST
Route::post('inserirUsuario/{idUsuario?}', [Pagecontroller::class, 'inserindoUsuario'])->name('inserindo.usuario');
Route::post('atualizaPerfil/{idPerfil?}', [Pagecontroller::class, 'atualizaPerfil']);
Route::post('inserirSistema', [Pagecontroller::class, 'inserirSistema']);
Route::post('atualizarSenha/{idPerfil?}', [Pagecontroller::class, 'atualizarSenha']);
//GET
Route::get('ativarDesativar/{idUsuario?}', [Pagecontroller::class, 'ativarDesativar']);
Route::get('excluirSistema/{idSistema?}', [Pagecontroller::class, 'excluirSistema']);


/* ------------------- AUTOMACAO - ROBO SERVOPA ------------------- */
Route::get('automacao/abreviador', [AutomacaoPagecontroller::class, 'abreviador']);
Route::get('automacao/importarUsuarioAPI', [AutomacaoPagecontroller::class, 'importarUsuariosApi']);
Route::get('automacao/importarUsuarioVetorSelbetti', [AutomacaoPagecontroller::class, 'importarUsuarioVetorSelbetti']);
Route::get('enviar-email', [EmailController::class, 'enviarEmail'])->name('enviar-email');


/* ################ BLOG ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('blog/index', [BlogPagecontroller::class, 'index'])->middleware('loaduservariables');
Route::get('blog/postage', [BlogPagecontroller::class, 'postage'])->middleware('loaduservariables');
Route::get('blog/nova', [BlogPagecontroller::class, 'nova'])->middleware('loaduservariables');

/* ------------------- ROTAS DE ALTERACAO VIA BANCO DE DADOS ------------------- */

//GET
Route::get('blog/mensagem/{idPostagem?}', [BlogPagecontroller::class, 'mensagem'])->middleware('loaduservariables');
//POST
Route::get('blog/update/{idPostagem?}', [BlogPagecontroller::class, 'update']);
Route::post('blog/novaPostagem', [BlogPagecontroller::class, 'novaPostagem']);


/* ################ RH ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('rh/index', [RhPagecontroller::class, 'index'])->name('rh.index')->middleware('loaduservariables');
Route::get('rh/busca', [RhPagecontroller::class, 'busca'])->name('rh.busca')->middleware('loaduservariables');
Route::get('rh/horario', [RhPagecontroller::class, 'horario'])->name('rh.horario')->middleware('loaduservariables');
Route::get('rh/novoHorario', [RhPagecontroller::class, 'novoHorario'])->middleware('loaduservariables');
Route::get('rh/editarHorario/{idHorario?}', [RhPagecontroller::class, 'editarHorario'])->name('rh.editarHorario')->middleware('loaduservariables');


/* ------------------- ROTAS DE ALTERACAO VIA BANCO DE DADOS ------------------- */

//GET
Route::get('rh/desativarHorario/{idHorario?}', [RhPagecontroller::class, 'desativarHorario']);


//POST
Route::post('rh/buscaColaborador', [RhPagecontroller::class, 'buscaCpf'])->middleware('loaduservariables');
Route::post('rh/salvar', [RhPagecontroller::class, 'salvar'])->name('horario.salvar');
Route::post('rh/editar/{idHorario?}', [RhPagecontroller::class, 'updateHorario'])->name('horario.editar');



/* ################ CONTABILIDADE ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('contabilidade/index', [ContabilidadePagecontroller::class, 'index'])->name('contabilidade.index')->middleware('loaduservariables');
Route::get('contabilidade/fluxo', [ContabilidadePagecontroller::class, 'fluxo'])->name('contabilidade.fluxo')->middleware('loaduservariables');
Route::get('contabilidade/bloqueioBancos', [ContabilidadePagecontroller::class, 'bloqueioBancos'])->name('contabilidade.bloqueioBancos')->middleware('loaduservariables');


/* ------------------- ROTAS DE ALTERACAO VIA BANCO DE DADOS ------------------- */

//POST
Route::post('contabilidade/localizarFluxo', [ContabilidadePagecontroller::class, 'localizarFluxo'])->middleware('loaduservariables');
Route::post('contabilidade/excluirFluxo', [ContabilidadePagecontroller::class, 'excluirFluxo'])->middleware('loaduservariables');
Route::post('buscaNome', [ContabilidadePagecontroller::class, 'buscaNomeEmpresa']);
Route::post('salvarBanco', [ContabilidadePagecontroller::class, 'salvarBanco']);
Route::post('bloquearDataBanco', [ContabilidadePagecontroller::class, 'bloquearDataBanco']);

//GET
Route::get('contabilidade/deletar/{idBanco?}', [ContabilidadePagecontroller::class, 'deletarBanco']);


/* ################ NOTAS ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('notas/index/{dadosTabelaStatus?}', [NotasPagecontroller::class, 'index'])->middleware('loaduservariables');
Route::get('notas/editar/{idNota?}', [NotasPagecontroller::class, 'editar'])->middleware('loaduservariables');
Route::get('notas/lancar', [NotasPagecontroller::class, 'lancarNota'])->middleware('loaduservariables');
Route::get('notas/fornecedor', [NotasPagecontroller::class,'fornecedor'])->middleware('loaduservariables');
Route::get('notas/reateioFornecedor', [NotasPagecontroller::class, 'reateioFornecedor'])->middleware('loaduservariables');
Route::get('notas/editarFornecedor/{idFornecedor}/{scroll?}', [NotasPagecontroller::class, 'editarFornecedor'])->middleware('loaduservariables')->name('editarFornecedor');
Route::get('notas/carimbo/{ia}/{fornecedor}/{filial}/{email}', [NotasPagecontroller::class, 'carimbo']);
Route::get('notas/roboLancarNota/{serie}/{cnpjFornecedor}/{usuario}/{numeroNota}/{dataEmissao}/{dataVencimento}/{valorNota}/{cnpjFilial}/{back?}', [NotasPagecontroller::class, 'lancarNotaRobo']);
Route::get('notas/anexo/{idAnexo}/{idLancarNota}', [NotasPagecontroller::class, 'salvarAnexo']);

//POST
Route::post('notas/editar/{idNota?}', [NotasPagecontroller::class, 'editarSalvar']);
Route::post('notas/TabelaCentroCusto', [NotasPagecontroller::class, 'montarCentroCusto']);
Route::post('notas/buscaFornecedor', [NotasPagecontroller::class, 'buscaFornecedor']);
Route::post('notas/lancar', [NotasPagecontroller::class, 'salvarNotaFiscal']);
Route::post('notas/salvarFornecedor', [NotasPagecontroller::class, 'salvarFornecedor']);
Route::post('notas/updateFornecedor/{idFornecedor?}', [NotasPagecontroller::class, 'updateFornecedor']);
Route::post('notas/salvarNotasRobo', [NotasPagecontroller::class, 'salvarNotasRobo']);
Route::post('notas/alterarAnexo', [NotasPagecontroller::class, 'alterarAnexo']);

//GET
Route::get('notas/deletar/{idNota?}', [NotasPagecontroller::class, 'deletarNota']);
Route::get('notas/deletarDocumento/{ID}', [NotasPagecontroller::class, 'deletarDocumento']);
Route::get('notas/excluirCentroCusto/{idCentroCusto?}', [NotasPagecontroller::class, 'excluirCentroCusto']);
Route::get('notas/deletarFornecedor/{idFornecedor?}', [NotasPagecontroller::class, 'excluirFornecedor']);



/* ################ VEX ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('vex/index', [VexPagecontroller::class, 'index'])->middleware('loaduservariables');
Route::get('vex/vistoriaParada',[VexPagecontroller::class, 'vistoriaParada'])->middleware('loaduservariables');
Route::get('vex/vistoriaLiberar',[VexPagecontroller::class, 'vistoriaLiberar'])->middleware('loaduservariables');
Route::get('vex/pdf',[VexPagecontroller::class, 'liberarPDF'])->middleware('loaduservariables');

//POST
Route::post('vex/marcarVistoria', [VexPagecontroller::class, 'marcarVistoria']);
Route::post('vex/gerarPDF', [VexPagecontroller::class, 'liberarGerarPDF']);


/* ################ INVENTARIO ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('inventario/index', [InventarioPagecontroller::class, 'index'])->middleware('loaduservariables');
Route::get('inventario/colaborador', [InventarioPagecontroller::class, 'colaborador'])->middleware('loaduservariables');
//POST

//GET

/* ################ APP VENDEDORES ################ */

/* ------------------- PAGINAS PRINCIPAIS ------------------- */
Route::get('app_vendas/index', [App_vendasPageController::class, 'index'])->middleware('loaduservariables');
Route::get('app_vendas/configTelas', [App_vendasPageController::class, 'configTelas'])->middleware('loaduservariables');
Route::get('app_vendas/centralAjuda', [App_vendasPageController::class, 'centralAjuda'])->middleware('loaduservariables');

//POST
Route::post('app_vendas/salvarAjuda', [App_vendasPageController::class, 'salvarAjuda']);

//GET


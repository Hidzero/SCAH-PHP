<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\GraficoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\FerramentaController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\EquipamentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas da sua aplicação. Estas rotas são carregadas
| pelo RouteServiceProvider dentro de um grupo que contém o grupo de middleware "web".
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Como bloquear rotas a partir da role de usuario que esta sendo pesquisada na model

    // Route::get('/admin', function () {
    //     return "Painel do Administrador";
    // })->middleware('auth')->where(fn ($request) => auth()->user()->isAdmin());

    // Ou esse para o blade

    // @if(auth()->user()->isAdmin())
    //   <a href="{{ route('admin.dashboard') }}">Acesso Administrativo</a>
    // @endif



    Route::get('/', [GraficoController::class, 'index'])->name('dashboard');

    // Rotas de Cadastro (você pode usar resource para facilitar)
    Route::resource('ferramentas', FerramentaController::class);
    Route::resource('obra', ObraController::class);
    Route::resource('veiculo', VeiculoController::class);
    Route::resource('motorista', MotoristaController::class);
    Route::resource('equipamentos', EquipamentoController::class);
    Route::resource('usuario', UsuarioController::class);

    // Rotas de Estoque
    Route::prefix('estoque')->name('estoque.')->group(function () {
        Route::get('visualizar', [EstoqueController::class, 'visualizar'])->name('visualizar');
        Route::get('retirar', [EstoqueController::class, 'retirar'])->name('retirar');
        Route::post('retirar/store', [EstoqueController::class, 'store'])->name('store');
        Route::get('devolucao', [EstoqueController::class, 'devolucao'])->name('devolucao');
        Route::post('devolucao/store', [EstoqueController::class, 'storeDevolucao'])
            ->name('devolucao.store');
        Route::post('devolucao/defeito', [EstoqueController::class, 'storeDevolucaoDefeito'])
            ->name('devolucao.defeito');

    });

    // Rotas de Manutenção
    Route::prefix('manutencao')->name('manutencao.')->group(function () {
        Route::get('atendimento-os', [ManutencaoController::class, 'atendimentoOs'])->name('atendimento_os.index');
        Route::get('ordem-servico', [ManutencaoController::class, 'ordemServico'])->name('ordem_servico.index');
        Route::get('gestao', [ManutencaoController::class, 'index'])->name('gestao_manutencao.index');
        Route::post('{id}/solicitar-peca', [ManutencaoController::class, 'solicitarPeca'])->name('solicitar');
        Route::post('{id}/em-conserto',   [ManutencaoController::class, 'enviarConserto'])->name('conserto');
        Route::post('{id}/condenar',      [ManutencaoController::class, 'condenar'])->name('condenar');
        Route::post('{id}/voltar-aguardando', [ManutencaoController::class, 'voltarAguardando'])->name('voltar');
        Route::post('{id}/voltar-estoque',    [ManutencaoController::class, 'voltarEstoque'])->name('voltar.estoque'); 
        Route::get('manuais',       [ManualController::class,'index'])->name('manuais.index');
        Route::get('manuais/create',[ManualController::class,'create'])->name('manuais.create');
        Route::post('manuais',      [ManualController::class,'store'])->name('manuais.store');
        Route::get('manuais/{manual}/download',[ManualController::class,'download'])->name('manuais.download');
        Route::delete('manuais/{manual}',      [ManualController::class,'destroy'])->name('manuais.destroy');
    
    });

    // Rotas de Veículos
    Route::prefix('veiculos')->name('veiculos.')->group(function () {
        Route::get('saida', [VeiculoController::class, 'indexSaida'])->name('saida');
        Route::post('saida/store', [VeiculoController::class, 'storeSaida'])->name('saida.store');
        Route::get('retorno', [VeiculoController::class, 'indexRetorno'])->name('retorno');
        Route::post('retorno/store', [VeiculoController::class, 'storeRetorno'])->name('retorno.store');
        Route::get('dashboard', [VeiculoController::class, 'dashboard'])->name('dashboard');
    });

    // Rota de Consulta
    Route::get('consulta/gpt', [ConsultaController::class, 'gpt'])->name('consulta.gpt');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';

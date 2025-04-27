<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\EstoqueController;
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

    

    Route::get('/', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

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
        Route::post('devolucao', [EstoqueController::class, 'devolucaoStore'])->name('devolucao.store');
    });

    // Rotas de Manutenção
    Route::prefix('manutencao')->name('manutencao.')->group(function () {
        Route::get('atendimento-os', [ManutencaoController::class, 'atendimentoOs'])->name('atendimento_os.index');
        Route::get('ordem-servico', [ManutencaoController::class, 'ordemServico'])->name('ordem_servico.index');
        Route::get('gestao', [ManutencaoController::class, 'gestao'])->name('gestao_manutencao.index');
        Route::get('consulta-manuais', [ManutencaoController::class, 'consultaManuais'])->name('consulta_manuales.index');
    });

    // Rota de Relatórios
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('ferramentas', [RelatorioController::class, 'ferramentas'])->name('ferramentas');
    });

    // Rotas de Veículos
    Route::prefix('veiculos')->name('veiculos.')->group(function () {
        Route::get('saida', [VeiculoController::class, 'saida'])->name('saida');
        Route::get('retorno', [VeiculoController::class, 'retorno'])->name('retorno');
        // Use um nome que não conflite com a rota 'home'
        Route::get('dashboard', [VeiculoController::class, 'dashboard'])->name('dashboard_veiculos');
    });

    // Rota de Consulta
    Route::get('consulta/gpt', [ConsultaController::class, 'gpt'])->name('consulta.gpt');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

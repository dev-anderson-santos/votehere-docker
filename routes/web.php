<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotacoesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VotoController;
use App\Http\Controllers\TipoController;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);
Route::get('verify/{code}', 'MailController@sendMail');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('/votacoes')->group(function () {
    Route::get('/', [VotacoesController::class, 'index'])->name('votacao.index');
    Route::get('/create', [VotacoesController::class, 'create'])->name('votacao.create');
    Route::post('/salvar', [VotacoesController::class, 'store'])->name('votacao.store');
    Route::get('/{votacao_id}/edit', [VotacoesController::class, 'edit'])->name('votacao.edit');
    Route::post('/{votacao_id}/update', [VotacoesController::class, 'update'])->name('votacao.update');
    Route::get('/{votacao_id}/delete', [VotacoesController::class, 'destroy'])->name('votacao.delete');
    Route::get('/votacao/{votacao_id}', [VotacoesController::class, 'show'])->name('votacao.show');
    Route::get('/votar/{votacao_id}', [VotacoesController::class, 'votar'])->name('votacao.votar');
    Route::get('/categorias', [VotacoesController::class, 'categorias'])->name('votacao.categorias');
    Route::get('/votacao-encerrada/{votacao_id}', [VotacoesController::class, 'votacaoEncerrada'])->name('votacao.votacao_encerrada');
});
Route::get('/getDisponibilidadeCanditados/{votacao_id}', [VotacoesController::class, 'getDisponibilidadeCanditados'])->name('votacao.getDisponibilidadeCanditados');    

Route::middleware('auth')->prefix('/tipos')->group(function () {
    Route::get('/', [TipoController::class, 'index'])->name('tipo.index');
    Route::get('/create', [TipoController::class, 'create'])->name('tipo.create');
    Route::get('/store', [TipoController::class, 'store'])->name('tipo.store');
    Route::get('/{tipo_id}/edit', [TipoController::class, 'edit'])->name('tipo.edit');
    Route::get('/{tipo_id}/update', [TipoController::class, 'update'])->name('tipo.update');
    Route::get('/{tipo_id}/delete', [TipoController::class, 'destroy'])->name('tipo.destroy');
    Route::get('dynamicModal/{tipo_id}',[TipoController::class, 'loadModal'])->name('dynamicModal');
});

Route::middleware('auth')->prefix('/votar')->group(function () {
    Route::post('/conputar-voto', [VotoController::class, 'votar'])->name('voto.computar');
    Route::get('/obrigado', [VotoController::class, 'obrigado'])->name('voto.obrigado');
    Route::get('/get-votos/{votacao_id}', [VotoController::class, 'show'])->name('voto.votos');
});

Route::middleware('auth')->prefix('/candidatos')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('usuario.index');    
    Route::get('/create', [UserController::class, 'create'])->name('usuario.create');
    Route::post('/store', [UserController::class, 'store'])->name('usuario.store');
    Route::get('/{candidato_id}/edit', [UserController::class, 'edit'])->name('usuario.edit');
    Route::post('/{candidato_id}/update', [UserController::class, 'update'])->name('usuario.update');
    Route::get('/{candidato_id}/delete', [UserController::class, 'destroy'])->name('usuario.destroy');
    Route::get('/killThemAll', [UserController::class, 'killThemAll'])->name('usuario.killThemAll');
});

Route::middleware('auth')->prefix('/eleitores')->group(function () {
    Route::get('/', [UserController::class, 'eleitores'])->name('eleitores');
});

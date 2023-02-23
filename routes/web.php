<?php

use App\Models\Carro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;
use App\Models\Manutencao;
use App\Models\Marca;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/teste', function () {

})->name('teste');


Route::get('/testee', function () {
$manutencao = Manutencao::findOrFail(4);
$servicos = $manutencao->servicosId();
dd($servicos[0]);

})->name('teste2');


Auth::routes();



Route::middleware('auth')->group(function () {
    Route::get('/servicos_manutencao/{id}', [ServicoController::class, 'servicos_manutencao'])->name('servicos.manutencao');

    Route::view('about', 'about')->name('about');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'carro'], function () {
        Route::get('/', [CarroController::class,'index'])->name('carro.index');
        Route::post('/', [CarroController::class,'create'])->name('carro.create');
        Route::delete('/{id}', [CarroController::class,'delete'])->name('carro.delete');
        Route::put('/{id}', [CarroController::class,'update'])->name('carro.update');
        Route::get('/form/{id?}', [CarroController::class, 'form'])->name('carro.form');
    });
    Route::group(['prefix' => 'manutencao'],function () {
        Route::get('/', [ManutencaoController::class,'index'])->name('manutencao.index');
        Route::post('/', [ManutencaoController::class,'create'])->name('manutencao.create');
        Route::delete('/{id}', [ManutencaoController::class,'delete'])->name('manutencao.delete');
        Route::put('/{id}', [ManutencaoController::class,'update'])->name('manutencao.update');
        Route::get('/form/{id?}', [ManutencaoController::class, 'form'])->name('manutencao.form');
        }
    );

    Route::group(['prefix' => 'servico'],function () {
        Route::get('/', [ServicoController::class,'index'])->name('servico.index');
        Route::post('/', [ServicoController::class,'create'])->name('servico.create');
        Route::delete('/{id}', [ServicoController::class,'delete'])->name('servico.delete');
        Route::put('/{id}', [ServicoController::class,'update'])->name('servico.update');
        Route::get('/form/{id?}', [ServicoController::class, 'form'])->name('servico.form');
    }
    );


    Route::group(
        ['prefix' => 'cliente'],
        function () {
            Route::get('/', [ClienteController::class,'index'])->name('cliente.index');
            Route::post('/', [ClienteController::class,'create'])->name('cliente.create');
            Route::delete('/{id}', [ClienteController::class,'delete'])->name('cliente.delete');
            Route::put('/{id}', [ClienteController::class,'update'])->name('cliente.update');    }
    );

    Route::group(
        ['prefix' => 'api'],
        function () {
            Route::get('/marcasFamosas', [DashboardController::class, 'manutencoesPorMes'])->name('manutencao.dashboard');
    }
    );
});

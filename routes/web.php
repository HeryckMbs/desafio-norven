<?php

use App\Http\Controllers\MarcaController;
use App\Models\Carro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
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


Auth::routes();



Route::middleware('auth')->group(function () {
    Route::get('/servicos_manutencao/{id}', [ServicoController::class, 'servicos_manutencao'])->name('servicos.manutencao');

    Route::view('about', 'about')->name('about');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::get('/produtoIndividual/{produto_id}',[ProdutoController::class,'getProdutoIndividual'])->name('produto.produto');
    Route::get('/produtosCategoria/{categoria_id}',[CategoriaController::class,'produtosCategoria']);

    Route::get('/produtosCategoriaEmEstoque/{categoria_id}',[CategoriaController::class,'produtosCategoriaEmEstoque'])->name('produtosCategoria.index');
    Route::get('/categoria/{categoria_id}',[CategoriaController::class,'getCategoria'])->name('categoria.categoria');
    Route::put('/categorias/{categoria_id}',[CategoriaController::class,'update'])->name('categoria.update');
    Route::get('/categorias',[CategoriaController::class,'index'])->name('categoria.index');
    Route::post('/categorias',[CategoriaController::class,'store'])->name('categoria.store');
    Route::get('/categoriaForm/{categoria_id?}',[CategoriaController::class, 'categoriaForm'])->name('categoria.form');
    Route::delete('/categorias/{categoria_id}',[CategoriaController::class,'delete'])->name('categoria.delete');
    
    Route::resource('fornecedor', FornecedorController::class);
    Route::resource('marca',MarcaController::class);
    Route::resource('produto',ProdutoController::class);
    Route::resource('estoque',EstoqueController::class);
    
    Route::get('/produtoEstoqueInfo/{produto_estoque_id}',[EstoqueController::class,'getInfoProdutoEstoque']);

});

<?php

use App\Http\Controllers\MarcaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Categoria;
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
    return redirect('/home');
});
Route::get('/welcome', function () {
    return view('welcome');
});


Auth::routes();



Route::middleware('auth')->group(function () {

    Route::view('about', 'about')->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/produtosCategoriaEmEstoque/{categoria_id}', [CategoriaController::class, 'produtosCategoriaEmEstoque'])->name('produtosCategoria.index');

    Route::resource('fornecedor', FornecedorController::class);
    Route::resource('marca', MarcaController::class);
    Route::resource('categoria', CategoriaController::class);
    Route::resource('produto', ProdutoController::class);
    Route::resource('estoque', EstoqueController::class);
    Route::resource('lancamento', LancamentoController::class);

});

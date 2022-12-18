<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarroController;

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

Auth::routes();


Route::middleware('auth')->group(function () {
    Auth::routes();

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
        Route::get('/form', [CarroController::class, 'form'])->name('carro.form');
    });
});

<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(int $categoria_id){
        $categoria = Categoria::find($categoria_id);
        $produtosCategoria = $categoria->produtosEmEstoquePorCategoria->unique('produto.id');

        return view('produtosCategoria.index',compact('produtosCategoria','categoria'));
    }
  

}

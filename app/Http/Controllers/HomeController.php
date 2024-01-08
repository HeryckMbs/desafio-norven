<?php

namespace App\Http\Controllers;

use App\DataTables\AgendamentosDataTable;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View
    {
        $categorias = Categoria::indexHome();
        return view('home', compact('categorias'));
    }

    public function produtosCategoriaEmEstoque(int $categoria_id) : View
    {
        $produtosCategoria = Produto::indexHome($categoria_id);
        $categoria = Categoria::find($categoria_id);
        return view('produtosCategoria.index', compact('produtosCategoria', 'categoria'));
    }
}

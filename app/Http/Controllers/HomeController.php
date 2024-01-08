<?php

namespace App\Http\Controllers;

use App\DataTables\AgendamentosDataTable;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categorias = Categoria::indexHome();
        return view('home', compact('categorias'));
    }

    public function produtosCategoriaEmEstoque(int $categoria_id)
    {
        $produtosCategoria = Produto::when(request()->has('search'), function ($query) {
            return  $query->whereHas('fornecedor', function ($query3) {
                $query3->where('nome', 'like', '%' . request()->search . '%');
            })->orWhereHas('marca', function ($query4) {
                $query4->where('nome', 'like', '%' . request()->search . '%');
            });
        })->where('categoria_id', $categoria_id)
            ->with(['categoria'])
            ->paginate(request()->paginacao ?? 10);

        $categoria = Categoria::find($categoria_id);
        return view('produtosCategoria.index', compact('produtosCategoria', 'categoria'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class a extends Controller
{
  
    public function produtosCategoria(int $categoria_id)
    {
    
    }

    public function index()
    {
        $categorias = Categoria::orderBy('id')->withTrashed()
            ->when(request()->has('search'), function ($query) {
                $request = request()->all();
                return $query->where('nome', 'like', '%' . $request['search'] . '%')
                    ->orWhere('descricao', 'like', '%' . $request['search'] . '%');
            })->paginate(request()->paginacao ?? 10);
        return view('categoria.index', compact('categorias'));
    }

    public function store(CategoriaRequest $request)
    {
        
    }
    public function delete(int $categoria_id)
    {
        try {
            Categoria::findOrFail($categoria_id)->delete();
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
        return back()->with('messages', ['success' => ['Categoria excluída com sucesso!']]);
    }

    public function getCategoria(int $categoria_id)
    {
        try {
            $categoria = Categoria::findOrFail($categoria_id);
            return response()->json(['success' => true, 'data' => $categoria]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => '']);
        }
    }

    public function update(int $categoria_id, CategoriaRequest $request)
    {
        
    }

    public function categoriaForm(int $categoria_id = null)
    {
        if ($categoria_id == null) {
            return view('categoria.form');
        }
        $categoria = Categoria::find($categoria_id);
        return view('categoria.form', compact('categoria'));
    }
}

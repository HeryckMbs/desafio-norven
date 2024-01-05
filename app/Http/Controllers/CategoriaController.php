<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::index();
        return view('categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('categoria.form');
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $imageLink = Storage::putFile('imagensCategoria', $request->url_capa);
            $imageLink = ENV('APP_URL') . '/' . $imageLink;
            Categoria::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'url_capa' => $imageLink
            ]);
            return redirect(route('categoria.index'))->with('messages', ['success' => ['Categoria criada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possícel criar a categoria!']]);
        }
    }

    public function show($categoria_id)
    {

        try{
            $categoria = Categoria::findOrFail($categoria_id);
            $produtosCategoria = $categoria->produtos->map->only(['id', 'nome']);
            return ['success' => true, 'data' => $produtosCategoria];
        }catch(\Exception $e){
            return ['success' => false, 'data' => '','message'=> 'Não foi possível encontrar a categoria', 'error' => $e->getMessage()];

        }
    }

    public function edit($categoria_id)
    {
        try{
            $categoria = Categoria::findOrFail($categoria_id);
            return view('categoria.form', compact('categoria'));
        }catch(\Exception $e){
            return back()->with('messages', ['error' => ['Não foi possícel editar a categoria!']]);

        }
    }

    public function update(Request $request, $categoria_id)
    {
        try {
            $categoria = Categoria::findOrFail($categoria_id);
            $arrayUpdate = [
                'nome' => $request->nome,
                'descricao' => $request->descricao,
            ];
            if (isset($request->url_capa)) {
                $nameOldFile = explode('/', $categoria->url_capa);
                if (Storage::disk('imagensCategoria')->exists(end($nameOldFile))) {
                    Storage::disk('imagensCategoria')->delete(end($nameOldFile));
                }
                $imageLink = Storage::putFile('imagensCategoria', $request->url_capa);
                $imageLink = ENV('APP_URL') . '/' . $imageLink;
                $arrayUpdate['url_capa'] = $imageLink;
            }

            $categoria->update($arrayUpdate);
            return redirect(route('categoria.index'))->with('messages', ['success' => ['Categoria atualizada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar a categoria!']]);
        }
    }

    public function destroy($categoria_id)
    {
        try {
            Categoria::findOrFail($categoria_id)->delete();
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
        return back()->with('messages', ['success' => ['Categoria excluída com sucesso!']]);
    }

  
}

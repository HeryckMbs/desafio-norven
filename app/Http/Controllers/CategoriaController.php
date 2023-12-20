<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function produtosCategoria(int $categoria_id){
        $categoria = Categoria::find($categoria_id);
        $produtosCategoria = $categoria->produtosEmEstoquePorCategoria->unique('produto.id');

        return view('produtosCategoria.index',compact('produtosCategoria','categoria'));
    }

    public function index(){
        $categorias = Categoria::orderBy('id')->withTrashed()->get();
        return view('categoria.index', compact('categorias'));
    }

    public function store(CategoriaRequest $request) {
        $imageLink = Storage::putFile('imagensCategoria',$request->url_capa);
        $imageLink = ENV('APP_URL').'/'.$imageLink;
        Categoria::create([
            'nome' => $request->nome,
            'descricao'=> $request->descricao,
            'url_capa' => $imageLink
        ]);
        return redirect(route('categoria.index'))->with('messages',['success'=>['Categoria criada com sucesso!']]);
    }
    public function delete(int $categoria_id) {
        try{
            Categoria::findOrFail($categoria_id)->delete();
        }catch(\Exception $e){
            return back()->with('messages',['error'=>['Requisição inválida!']]);
        }
        return back()->with('messages',['success'=>['Categoria excluída com sucesso!']]);
    }

    public function getCategoria(int $categoria_id){
        try{
            $categoria = Categoria::findOrFail($categoria_id);
            return response()->json(['success' => true, 'data' => $categoria]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'data' => '']);
        }
    }

    public function update(int $categoria_id, CategoriaRequest $request){
        try{
            $categoria = Categoria::findOrFail($categoria_id);
            $arrayUpdate = [
                'nome' => $request->nome,
                'descricao'=> $request->descricao,
            ];
            if(isset($request->url_capa)){
                $nameOldFile = explode('/',$categoria->url_capa);
                if(Storage::disk('imagensCategoria')->exists(end($nameOldFile))){
                    Storage::disk('imagensCategoria')->delete(end($nameOldFile));
                }
                $imageLink = Storage::putFile('imagensCategoria',$request->url_capa);
                $imageLink = ENV('APP_URL').'/'.$imageLink;
                $arrayUpdate['url_capa'] = $imageLink;
            }

            $categoria->update($arrayUpdate);
        }catch(\Exception $e){
            return back()->with('messages',['error'=>['Requisição inválida!']]);
        }
        return redirect(route('categoria.index'))->with('messages',['success'=>['Categoria atualizada com sucesso!']]);
    }  

    public function categoriaForm(int $categoria_id = null){
        if($categoria_id == null){
            return view('categoria.form');
        }
        $categoria = Categoria::find($categoria_id);
        return view('categoria.form',compact('categoria'));
    }

}

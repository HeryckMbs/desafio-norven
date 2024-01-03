<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoria.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageLink = Storage::putFile('imagensCategoria', $request->url_capa);
        $imageLink = ENV('APP_URL') . '/' . $imageLink;
        Categoria::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'url_capa' => $imageLink
        ]);
        return redirect(route('categoria.index'))->with('messages', ['success' => ['Categoria criada com sucesso!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $produtosCategoria = $categoria->produtos->map->only(['id','nome']);
        return ['success' => true, 'data' => $produtosCategoria];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        return view('categoria.form', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoria_id)
    {
        try {
            Categoria::findOrFail($categoria_id)->delete();
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
        return back()->with('messages', ['success' => ['Categoria excluída com sucesso!']]);
    }

    public function produtosCategoriaEmEstoque(int $categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $produtosCategoria = $categoria->produtos;

        return view('produtosCategoria.index', compact('produtosCategoria', 'categoria'));
    }
}

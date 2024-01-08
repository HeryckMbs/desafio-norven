<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Models\Produto;
use App\Repositories\CategoriaRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    private CategoriaRepository $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)   {
        $this->categoriaRepository = $categoriaRepository;
    }
    public function index() : View
    {
        $categorias = $this->categoriaRepository->getIndex();
        return view('categoria.index', compact('categorias'));
    }

    public function create() : View
    {
        return view('categoria.form');
    }

    public function store(CategoriaRequest $request) : RedirectResponse
    {
        try {
            $this->categoriaRepository->store($request);
            return redirect(route('categoria.index'))->with('messages', ['success' => ['Categoria criada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possícel criar a categoria!']]);
        }
    }

    public function show(int $categoria_id) : Array
    {

        try{
            $produtosCategoria = $this->categoriaRepository->getProdutosCategoria( $categoria_id ); 
            return ['success' => true, 'data' => $produtosCategoria];
        }catch(\Exception $e){
            return ['success' => false, 'data' => '','message'=> 'Não foi possível encontrar a categoria', 'error' => $e->getMessage()];

        }
    }

    public function edit(int $categoria_id) : View|RedirectResponse
    {
        try{
            $categoria = Categoria::findOrFail($categoria_id);
            return view('categoria.form', compact('categoria'));
        }catch(\Exception $e){
            return back()->with('messages', ['error' => ['Não foi possícel editar a categoria!']]);

        }
    }

    public function update(CategoriaRequest $request, int $categoria_id) : RedirectResponse
    {
        try {
            $this->categoriaRepository->update($request, $categoria_id);
            return redirect(route('categoria.index'))->with('messages', ['success' => ['Categoria atualizada com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar a categoria!']]);
        }
    }

    public function destroy(int $categoria_id) : RedirectResponse
    {
        try {
            $this->categoriaRepository->destroy($categoria_id);
            return back()->with('messages', ['success' => ['Categoria excluída com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível excluir a categoria!']]);
        }
    }

  
}

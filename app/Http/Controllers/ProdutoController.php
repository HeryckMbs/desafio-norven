<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::with(['fornecedor', 'marca', 'responsavel'])
            ->orderBy('id')
            ->when(request()->has('search') && request()->search != '', function ($query) {
                $request = request()->all();
                return $query->where('nome', 'like', '%' . $request['search'] . '%')
                    ->orWhere('codigo', 'like', '%' . $request['search'] . '%')
                    ->orWhere('descricao', 'like', '%' . $request['search'] . '%')
                    ->orWhereHas('responsavel', function ($query) use ($request) {
                        $query->where('nome', 'like', '%' . $request['search'] . '%');
                    });
            })
            ->withTrashed()
            ->paginate(request()->paginacao ?? 10);
        return view('produto.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $fornecedores = Fornecedor::all();
        return view('produto.form', compact('categorias', 'marcas', 'fornecedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {

        Produto::create([
            "nome" => $request->nome,
            "unidade_medida" => $request->unidade_medida,
            "categoria_id" => (int) $request->categoria,
            "marca_id" => (int) $request->marca,
            "fornecedor_id" => (int) $request->fornecedor,
            "descricao" => $request->descricao,
            "informacao_nutricional" => $request->informacaoNutricional,
            "created_by" => Auth::id()
        ]);
        return redirect(route('produto.index'))->with('messages', ['success' => ['Produto criado com sucesso!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $categorias = Categoria::all();
        $marcas = Marca::all();
        $fornecedores = Fornecedor::all();
        $produto = Produto::find($id);
        return view('produto.form', compact('produto', 'categorias', 'marcas', 'fornecedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, $id)
    {
        Produto::find($id)->update([
            "nome" => $request->nome,
            "unidade_medida" => $request->unidade_medida,

            "categoria_id" => (int) $request->categoria,
            "marca_id" => (int) $request->marca,
            "fornecedor_id" => (int) $request->fornecedor,
            "descricao" => $request->descricao,
            "informacao_nutricional" => $request->informacaoNutricional,
            "created_by" => Auth::id()
        ]);
        return redirect(route('produto.index'))->with('messages', ['success' => ['Produto atualizado com sucesso!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Produto::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
        return back()->with('messages', ['success' => ['Categoria excluída com sucesso!']]);
    }

    public function getProdutoIndividual(int $produto_id)
    {
        $produto = Produto::with(['fornecedor', 'marca', 'responsavel']
        )->where('id', '=', $produto_id)->first();
        $produto->saidas = $produto->produtosSairamEstoque->count();
        $produto->entradas = $produto->produtosEntraramEstoque->count();
        return response()->json(['success' => true, 'data' => $produto], 200);
    }
}

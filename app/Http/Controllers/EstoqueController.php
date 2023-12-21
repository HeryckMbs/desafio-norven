<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Estoque;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtosEmEstoque = Estoque::with(['produtoRelacionado', 'categoriaRelacionada'])->orderBy('id')
            ->when(request()->has('search'), function ($query) {
                $request = request()->all();
                return $query->whereHas('categoriaRelacionada', function ($query1) use ($request) {
                    $query1->where('categorias.nome', 'like', '%' . $request['search'] . '%');
                })->orWhereHas('produtoRelacionado', function ($query2) use ($request) {
                    $query2->where('produtos.nome', 'like', '%' . $request['search'] . '%')
                        ->orWhere('produtos.codigo', 'like', '%' . $request['search'] . '%');
                });
            })
            ->withTrashed()
            ->paginate(8);
        return view('estoque.index', compact('produtosEmEstoque',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('estoque.form',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getInfoProdutoEstoque(int $produto_estoque_id)
    {
        $produto = Estoque::with(['produtoRelacionado', 'categoriaRelacionada', 'localizacaoEstoque', 'marcaRelacionada', 'fornecedorRelacionado'])
            ->where('id', '=', $produto_estoque_id)->withTrashed()->first();
        $produto->lucro = (($produto->preco_venda/$produto->preco_custo) * 100) - 100;
        $produto->diasVendido = Carbon::parse($produto->data_entrada)->diffInDays($produto->deleted_at);
        $produto->diasVencimento = Carbon::now()->diffInDays($produto->data_validade);
        
        return response()->json(['success' => true, 'data' => $produto], 200);
    }

    
}

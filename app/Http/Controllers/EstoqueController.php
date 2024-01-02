<?php

namespace App\Http\Controllers;

use App\Enums\TipoLancamento;
use App\Http\Requests\EstoqueRequest;
use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\ProdutoEstoque;
use App\Models\Lote;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtosEmEstoque = ProdutoEstoque::with(['produtoRelacionado'])->orderBy('id')
            ->when(request()->has('search'), function ($query) {
                $request = request()->all();
                return $query->whereHas('produtoRelacionado', function ($query2) use ($request) {
                    $query2->where('produtos.nome', 'like', '%' . $request['search'] . '%');
                })->orWhere('id', 'like', '%' . $request['search'] . '%');
            })
            ->whereDoesntHave('lancamentos', function ($query3) {
                $query3->where('tipo', 'Saida');
            })
            ->paginate(request()->paginacao ?? 10);
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
        return view('estoque.form', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstoqueRequest $request)
    {
        $produto = Produto::find($request->produto);
        try {
            DB::beginTransaction();
            $lote = Lote::create([
                'data_fabricacao' => Carbon::parse($request->dataFabricacao),
                'data_validade' => Carbon::parse($request->dataValidade),
                'preco_custo_unitario' => (float) $request->preco_custo,
                'produto_id' => $produto->id,
                'created_by' => Auth::id()
            ]);

            foreach (range(1, $request->quantidade) as $numero) {
                $produtoEmEstoque = ProdutoEstoque::create([
                    'produto_id' => $produto->id,
                    'lote_id' => $lote->id,
                    'preco_venda' => $request->preco_venda,
                ]);
                Lancamento::create([
                    'tipo' => TipoLancamento::Entrada,
                    'produto_estoque_id'=> $produtoEmEstoque->id,
                    'created_by' => Auth::id()

                ]);
            }

            DB::commit();
            return redirect(route('estoque.index'))->with('messages', ['success' => ['Produtos cadastrados no estoque com sucesso!']]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('messages', ['error' => ['Requisição inválida']]);
        }
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
        $produto = ProdutoEstoque::with([
            'lote',
            'produtoRelacionado',
            'categoriaRelacionada',
            'marcaRelacionada',
            'fornecedorRelacionado'
        ])->where('id', '=', $produto_estoque_id)->withTrashed()->first();
        $produto->lucro = (($produto->preco_venda / $produto->lote->preco_custo_unitario) * 100) - 100;
        $produto->diasVendido = Carbon::parse($produto->lote->data_entrada)->diffInDays($produto->data_venda);

        return response()->json(['success' => true, 'data' => $produto], 200);
    }

    public function getProduto(int $produto_estoque_id)
    {
        $produtoEstoque = ProdutoEstoque::with(['produtoRelacionado'])->where('id', $produto_estoque_id)->first();
        $data = ['id' => $produtoEstoque->id, 'nome' => $produtoEstoque->produtoRelacionado->nome];
        return response()->json(['success' => true, 'data' => $data], 200);
    }
}

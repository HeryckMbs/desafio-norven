<?php

namespace App\Http\Controllers;

use App\Enums\TipoLancamento;
use App\Http\Requests\LoteRequest;
use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\ProdutoEstoque;
use App\Models\Lote;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtosEmEstoque = Lote::paginate(10);
        return view('lote.index', compact('produtosEmEstoque'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('lote.form', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoteRequest $request)
    {
        $produto = Produto::find($request->produto);
        try {
            DB::beginTransaction();
            $lote = Lote::create([
                'data_fabricacao' => Carbon::parse($request->dataFabricacao)->startOfDay(),
                'data_validade' => Carbon::parse($request->dataValidade)->startOfDay(),
                'preco_custo' => (float) $request->preco_custo,
                'preco_venda' => $request->preco_venda,
                'produto_id' => $produto->id,
                'created_by' => Auth::id()
            ]);

            Lancamento::create([
                'tipo' => TipoLancamento::Entrada,
                'quantidade' => $request->quantidade,
                'lote_id' => $lote->id,
                'created_by' => Auth::id()

            ]);



            DB::commit();
            return redirect(route('lote.index'))->with('messages', ['success' => ['Produtos cadastrados no estoque com sucesso!']]);
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
    public function show($lote_id)
    {
        try {
            $lote = Lote::with(['produto', 'produto.marca', 'produto.fornecedor', 'produto.categoria'])->findOrFail( $lote_id);
            return response()->json(['success' => true, 'data' => $lote], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => true, 'data' => null,'message' => 'Lote não encontrado'], 400);
            }
            return response()->json(['success' => true, 'data' => null,'message' => 'Erro ao processar requisição. Tente novamente mais tarde.'], 400);

        }
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
        $produto = Produto::infoProdutoEstoque($produto_estoque_id);
        return response()->json(['success' => true, 'data' => $produto], 200);
    }

    public function getProduto(int $produto_estoque_id)
    {
    }
}

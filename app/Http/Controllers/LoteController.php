<?php

namespace App\Http\Controllers;

use App\Enums\TipoLancamento;
use App\Http\Requests\LoteRequest;
use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\Lote;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoteController extends Controller
{

    public function index() : View
    {
        $lotes = Lote::when(request()->has('search'),function($q){
            return $q->whereHas('produto',function($q2){
                $q2->where('nome','like','%'.request()->search.'%');
            })->orWhere('id','like','%'.request()->search.'%');
        })->paginate(request()->paginacao ?? 10);
        return view('lote.index', compact('lotes'));
    }

    public function create() : View
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('lote.form', compact('categorias'));
    }

    public function store(LoteRequest $request) : RedirectResponse
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
            return back()->with('messages', ['error' => ['Não foi possível cadastrar o lote!']]);
        }
    }

    public function show(int $lote_id) : JsonResponse
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

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
    }

 
}

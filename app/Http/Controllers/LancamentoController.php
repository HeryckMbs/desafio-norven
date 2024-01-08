<?php

namespace App\Http\Controllers;

use App\Enums\TipoLancamento;
use App\Http\Requests\LancamentoRequest;
use App\Models\Lancamento;
use App\Models\Lote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LancamentoController extends Controller
{

    public function index()
    {
        $lancamentos = Lancamento::index();
        return view('lancamento.index', compact('lancamentos'));
    }


    public function create()
    {
        return view('lancamento.form');
    }


    public function store(LancamentoRequest $request)
    {
        try {
            
            $lote = Lote::findOrFail($request->lote_id);
            
            if($lote->quantidadeAtual == 0){
                return back()->with('messages', ['error' => ['Não é possível realizar lançamento de saída para lotes sem produtos!']]);
            }

            Lancamento::create([
                'tipo' => TipoLancamento::Saida,
                'lote_id' => $request->lote_id,
                'quantidade' => $request->quantidade,
                'created_by' => Auth::id()
            ]);
            return redirect(route('lancamento.index'))->with('messages', ['success' => ['Saídas lançadas com sucesso!']]);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return back()->with('messages', ['error' => ['Lote não encontrado!']]);
            }
            return back()->with('messages', ['error' => ['Não foi possível salvar o lançamento!']]);
        }
    }

    public function show($id)
    {
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

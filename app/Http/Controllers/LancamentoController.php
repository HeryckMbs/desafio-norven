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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lancamentos = Lancamento::with(['lote'])->when(request()->search != null, function ($query) {
            return $query->where('lote_id', (int)request()->search);
        })->paginate(request()->paginacao ?? 10);

        return view('lancamento.index', compact('lancamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lancamentosEmAberto = Lancamento::where('tipo', TipoLancamento::Entrada)->get();
        return view('lancamento.form', compact('lancamentosEmAberto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LancamentoRequest $request)
    {

        try {
           $lote =  Lote::findOrFail($request->lote_id);

            Lancamento::create([
                'tipo' => TipoLancamento::Saida,
                'lote_id' => $request->lote_id,
                'quantidade' => $request->quantidade,
                'created_by' => Auth::id()
            ]);
            return redirect(route('lancamento.index'))->with('messages', ['success' => ['Saídas lançadas com sucesso!']]);
        } catch (\Exception $e) {
            if($e instanceof ModelNotFoundException){
                return back()->with('messages', ['error' => ['Lote não encontrado!']]);

            }
            return back()->with('messages', ['error' => ['Requisição inválida!']]);

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $fornecedores = Fornecedor::orderBy('id')->get();
        return view('fornecedor.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornecedor.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Fornecedor::create(['nome' => $request->nome, 'cnpj' => $request->cnpj, 'ativo' => isset($request->ativo)]);
        return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor criado com sucesso!']]);
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
        $fornecedor = Fornecedor::find($id);
        return view('fornecedor.form', compact('fornecedor'));
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
        Fornecedor::find($id)->update(['nome' => $request->nome, 'cnpj' => $request->cnpj, 'ativo' => isset($request->ativo)]);
        return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor criado com sucesso!']]);
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
            Fornecedor::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
        return back()->with('messages', ['success' => ['Fornecedor excluído com sucesso!']]);
    }
}

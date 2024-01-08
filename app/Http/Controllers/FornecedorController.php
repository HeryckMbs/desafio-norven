<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{

    public function index()
    {
        $fornecedores = Fornecedor::index();
        return view('fornecedor.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('fornecedor.form');
    }


    public function store(FornecedorRequest $request)
    {
        try {
            if(!validar_cnpj($request->cnpj)){
                return back()->with('messages', ['error' => ['CNPJ Inválido!']])->withInput($request->all());
            }
            $cnpj = preg_replace('/[.\/-]/', '', $request->cnpj);
            Fornecedor::create(['nome' => $request->nome, 'cnpj' => $cnpj]);
            return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor criado com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível criar o fornecedor!']]);
        }
    }


    public function show($id)
    {
    }

    public function edit($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            return view('fornecedor.form', compact('fornecedor'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar o fornecedor!']]);
        }
    }

    public function update(FornecedorRequest $request, $id)
    {
        try {
            Fornecedor::find($id)->update(['nome' => $request->nome, 'cnpj' => $request->cnpj]);
            return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor atualizado com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar o fornecedor!'.$e->getMessage()]]);
        }

    }

    public function destroy($id)
    {
        try {
            Fornecedor::findOrFail($id)->delete();
            return back()->with('messages', ['success' => ['Fornecedor excluído com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
    }
}

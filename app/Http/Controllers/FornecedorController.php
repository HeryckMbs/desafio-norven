<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;
use App\Models\Fornecedor;
use App\Repositories\FornecedorRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    private FornecedorRepository $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository){
        $this->fornecedorRepository = $fornecedorRepository;
    }
    public function index() : View
    {
        $fornecedores = $this->fornecedorRepository->getIndex();
        return view('fornecedor.index', compact('fornecedores'));
    }

    public function create() : View
    {
        return view('fornecedor.form');
    }


    public function store(FornecedorRequest $request) : RedirectResponse
    {
        try {
            if(!validar_cnpj($request->cnpj)){
                return back()->with('messages', ['error' => ['CNPJ Inválido!']])->withInput($request->all());
            }

            $this->fornecedorRepository->store($request);

            return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor criado com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível criar o fornecedor!']]);
        }
    }


    public function show( int $id)
    {
    }

    public function edit( int $id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            return view('fornecedor.form', compact('fornecedor'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar o fornecedor!']]);
        }
    }

    public function update(FornecedorRequest $request, int $id) : RedirectResponse
    {
        try {
            $this->fornecedorRepository->update($request, $id);
            return redirect(route('fornecedor.index'))->with('messages', ['success' => ['Fornecedor atualizado com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar o fornecedor!'.$e->getMessage()]]);
        }

    }

    public function destroy(int $id) : RedirectResponse
    {
        try {
            $this->fornecedorRepository->destroy( $id );
            return back()->with('messages', ['success' => ['Fornecedor excluído com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Requisição inválida!']]);
        }
    }
}

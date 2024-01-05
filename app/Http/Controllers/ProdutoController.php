<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{

    public function index()
    {
        $produtos = Produto::index();
        return view('produto.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $fornecedores = Fornecedor::all();
        return view('produto.form', compact('categorias', 'marcas', 'fornecedores'));
    }

    public function store(ProdutoRequest $request)
    {
        try {
            $informacaoNutricional = [
                "porcao" => $request->porcao,
                "proteina" => $request->proteina,
                "carboidrato" => $request->carboidrato,
                "gordura_total" => $request->gordura_total,
            ];
            Produto::create([
                "nome" => $request->nome,
                "unidade_medida" => $request->unidade_medida,
                "categoria_id" => (int) $request->categoria,
                "marca_id" => (int) $request->marca,
                "fornecedor_id" => (int) $request->fornecedor,
                "descricao" => $request->descricao,
                "informacao_nutricional" => $informacaoNutricional,
                "created_by" => Auth::id(),
            ]);
            return redirect(route('produto.index'))->with('messages', ['success' => ['Produto criado com sucesso!']]);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => true, 'data' => null, 'message' => 'Produto não encontrado'], 400);
            }
            return response()->json(['success' => true, 'data' => null, 'message' => 'Erro ao processar requisição. Tente novamente mais tarde.'], 400);
        }
    }

    public function show($produto_id)
    {
        try {
            $produto = Produto::with(['fornecedor', 'marca', 'responsavel'])->findOrFail($produto_id);
            return response()->json(['success' => true, 'data' => $produto], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => true, 'data' => null, 'message' => 'Produto não encontrado'], 400);
            }
            return response()->json(['success' => true, 'data' => null, 'message' => 'Erro ao processar requisição. Tente novamente mais tarde.'], 400);
        }
    }

    public function edit($id)
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $fornecedores = Fornecedor::all();
        try {
            $produto = Produto::findOrFail($id);
            return view('produto.form', compact('produto', 'categorias', 'marcas', 'fornecedores'));
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível encontrar o produto!']]);
        }
    }

    public function update(ProdutoRequest $request, $id)
    {
        try {
            $informacaoNutricional = [
                "porcao" => $request->porcao,
                "proteina" => $request->proteina,
                "carboidrato" => $request->carboidrato,
                "gordura_total" => $request->gordura_total,
            ];
            Produto::find($id)->update([
                "nome" => $request->nome,
                "unidade_medida" => $request->unidade_medida,

                "categoria_id" => (int) $request->categoria,
                "marca_id" => (int) $request->marca,
                "fornecedor_id" => (int) $request->fornecedor,
                "descricao" => $request->descricao,
                "informacao_nutricional" => $informacaoNutricional,
                "created_by" => Auth::id()
            ]);
            return redirect(route('produto.index'))->with('messages', ['success' => ['Produto atualizado com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível atualizar o produto!']]);
        }
    }

    public function destroy($id)
    {
        try {
            Produto::findOrFail($id)->delete();
            return back()->with('messages', ['success' => ['Produto excluído com sucesso!']]);
        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível excluír o produto!']]);
        }
    }
}

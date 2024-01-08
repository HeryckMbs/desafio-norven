<?php

namespace App\Repositories;

use App\Http\Requests\ProdutoRequest;
use App\Interfaces\ProdutoRepositoryInterface;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    private Produto $produto;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }

    public function getIndex()
    {
        return $this->produto->index();
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProduto(int $produto_id)
    {
        try {
            return $this->produto->with(['fornecedor', 'marca', 'responsavel'])->withTrashed()->findOrFail($produto_id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(ProdutoRequest $request, int $id)
    {
        try {
            $informacaoNutricional = [
                "porcao" => $request->porcao,
                "proteina" => $request->proteina,
                "carboidrato" => $request->carboidrato,
                "gordura_total" => $request->gordura_total,
            ];
            Produto::findOrFail($id)->update([
                "nome" => $request->nome,
                "unidade_medida" => $request->unidade_medida,

                "categoria_id" => (int) $request->categoria,
                "marca_id" => (int) $request->marca,
                "fornecedor_id" => (int) $request->fornecedor,
                "descricao" => $request->descricao,
                "informacao_nutricional" => $informacaoNutricional,
                "created_by" => Auth::id()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(int $id) 
    {
        try {
            $this->produto->findOrFail($id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

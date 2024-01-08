<?php

namespace App\Repositories;

use App\Http\Requests\FornecedorRequest;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Fornecedor;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    private Fornecedor $fornecedor;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    public function getIndex()
    {
        return $this->fornecedor->index();
    }

    public function store(FornecedorRequest $request)
    {
        try {
            $cnpj = preg_replace('/[.\/-]/', '', $request->cnpj);
            $this->fornecedor->create(['nome' => $request->nome, 'cnpj' => $cnpj]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(FornecedorRequest $request, int $id)
    {

        try {
            $cnpj = preg_replace('/[.\/-]/', '', $request->cnpj);
            $this->fornecedor->findOrFail($id)->update(['nome' => $request->nome, 'cnpj' => $cnpj]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->fornecedor->findOrFail($id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

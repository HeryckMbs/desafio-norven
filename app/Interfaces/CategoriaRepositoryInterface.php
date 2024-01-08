<?php

namespace App\Interfaces;

use App\Http\Requests\CategoriaRequest;

interface CategoriaRepositoryInterface
{
    public function getIndex();
    public function update(CategoriaRequest $request, int $id);
    public function destroy(int $id);
    public function store(CategoriaRequest $request);
    public function getProdutosCategoria(int $categoria_id);
}

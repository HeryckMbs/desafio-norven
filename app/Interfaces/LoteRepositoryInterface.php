<?php

namespace App\Interfaces;

use App\Http\Requests\LoteRequest;
use App\Http\Requests\MarcaRequest;

interface LoteRepositoryInterface
{
    public function getIndex();
    public function update(LoteRequest $request, int $id);
    public function destroy(int $id);
    public function store(LoteRequest $request);
}

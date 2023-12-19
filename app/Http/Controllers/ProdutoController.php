<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function getProduto(int $produto_id)
    {
        $produto = Produto::with(['fornecedor','marca','responsavel'])->where('id', '=', $produto_id)->first();
        return response()->json(['success' => true, 'data' => $produto], 200);
    }
}

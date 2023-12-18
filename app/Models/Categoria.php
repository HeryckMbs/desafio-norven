<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public function produtos(){
        return $this->hasMany(Produto::class);
    }

    public function produtosEmEstoquePorCategoria(){
        return $this->hasManyThrough(Estoque::class,Produto::class);
        // $produtosPorCategoria= [];
        // foreach($this->produtos as $produto){
        //     $produtosPorCategoria[$produto->id] = $produto->produtosEmEstoque;
        // }
        // dd($produtosPorCategoria);
        // return $produtosPorCategoria;
    }
}

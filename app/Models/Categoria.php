<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nome','descricao','url_capa'];

    public function produtos(){
        return $this->hasMany(Produto::class);
    }

    public function produtosEmEstoquePorCategoria(){
        return $this->hasManyThrough(ProdutoEstoque::class,Produto::class);
        // $produtosPorCategoria= [];
        // foreach($this->produtos as $produto){
        //     $produtosPorCategoria[$produto->id] = $produto->produtosEmEstoque;
        // }
        // dd($produtosPorCategoria);
        // return $produtosPorCategoria;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function produtoEmEstoque(){
        return $this->hasOne(ProdutoEstoque::class,'id','produto_estoque_id');
    }
}

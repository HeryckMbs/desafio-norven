<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $appends = ['quantidadeEmEstoque'];
    use HasFactory;
    public function getQuantidadeEmEstoqueAttribute(){
        return $this->produtosEmEstoque->count();
    }

    public function produtosEmEstoque(){
        return $this->hasMany(Estoque::class,);
    }

    public function responsavel(){
        return $this->hasOne(User::class,'id','created_by');
    }

    public function fornecedor(){
        return $this->hasOne(Fornecedor::class,'id','fornecedor_id');
    }
    public function marca(){
        return $this->hasOne(Marca::class,'id','marca_id');
    }
}

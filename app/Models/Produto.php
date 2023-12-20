<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "nome",
        "codigo",
        "unidade_medida",
        "preco_custo",
        "preco_venda",
        "categoria_id",
        "marca_id",
        "fornecedor_id",
        "descricao",
        "informacao_nutricional",
        "created_by",
    ];
    protected $appends = ['quantidadeEmEstoque'];
    use HasFactory;
    public function getQuantidadeEmEstoqueAttribute()
    {
        return $this->produtosEmEstoque->count();
    }

    public function produtosEmEstoque()
    {
        return $this->hasMany(Estoque::class,);
    }

    public function responsavel()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function fornecedor()
    {
        return $this->hasOne(Fornecedor::class, 'id', 'fornecedor_id');
    }
    public function marca()
    {
        return $this->hasOne(Marca::class, 'id', 'marca_id');
    }
}

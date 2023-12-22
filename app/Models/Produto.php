<?php

namespace App\Models;

use App\Enums\TipoLancamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "nome",
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
    protected $appends = ['quantidadeEmEstoque',];
    use HasFactory;
    public function getQuantidadeEmEstoqueAttribute()
    {
        return $this->produtosEmEstoque->count();
    }

    public function produtosEmEstoque()
    {
        return $this->hasMany(ProdutoEstoque::class)->where('deleted_at', '=', null)->whereDoesntHave('lancamentos', function ($query) {
            return $query->where('tipo', TipoLancamento::Saida);
        });
    }

    public function produtosSairamEstoque(){
        return $this->hasMany(ProdutoEstoque::class)->where('deleted_at', '=', null)->whereHas('lancamentos', function ($query) {
            return $query->where('tipo', TipoLancamento::Saida);
        });
    }
    public function produtosEntraramEstoque(){
        return $this->hasMany(ProdutoEstoque::class)->where('deleted_at', '=', null)->whereHas('lancamentos', function ($query) {
            return $query->where('tipo', TipoLancamento::Entrada);
        });
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

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }
}

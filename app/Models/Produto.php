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
        return Estoque::where('produto_id',$this->id)->count();
    }

    public function produtosEmEstoque()
    {
        return $this->hasMany(Estoque::class,)->where('deleted_at','=',null);
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

    public function categoria(){
        return $this->hasOne(Categoria::class,'id','categoria_id');
    }
}

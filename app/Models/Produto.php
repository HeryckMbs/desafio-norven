<?php

namespace App\Models;

use App\Enums\TipoLancamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    protected $casts = [
        'informacao_nutricional' => 'array'
    ];
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
    use HasFactory;

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

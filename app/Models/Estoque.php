<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estoque extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['diasAteVencimento'];
    use HasFactory;
    public function getDiasAteVencimentoAttribute()
    {
        return Carbon::now()->diffInDays(Carbon::parse($this->lote->data_validade));
         
    }
    public function produtoRelacionado(){
        return $this->hasOne(Produto::class,'id','produto_id');
    }

    public function marcaRelacionada(){
        return $this->hasOneThrough(Marca::class,Produto::class,'id','id','produto_id','marca_id');
    }
    public function fornecedorRelacionado(){
        return $this->hasOneThrough(Fornecedor::class,Produto::class,'id','id','produto_id','fornecedor_id');
    }

    public function categoriaRelacionada(){
        return $this->hasOneThrough(Categoria::class,Produto::class,'id','id','produto_id','categoria_id');
    }

    public function localizacaoEstoque(){
        return $this->hasOne(Localizacao::class);
    }

    public function lote(){
        return $this->hasOne(Lote::class,'id','lote_id');
    }
}

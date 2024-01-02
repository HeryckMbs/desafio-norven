<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdutoEstoque extends Model
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
    public function produtoRelacionado()
    {
        return $this->hasOne(Produto::class, 'id', 'produto_id');
    }

    public function marcaRelacionada()
    {
        return $this->hasOneThrough(Marca::class, Produto::class, 'id', 'id', 'produto_id', 'marca_id');
    }
    public function fornecedorRelacionado()
    {
        return $this->hasOneThrough(Fornecedor::class, Produto::class, 'id', 'id', 'produto_id', 'fornecedor_id');
    }

    public function categoriaRelacionada()
    {
        return $this->hasOneThrough(Categoria::class, Produto::class, 'id', 'id', 'produto_id', 'categoria_id');
    }


    public function lote()
    {
        return $this->hasOne(Lote::class, 'id', 'lote_id');
    }

    public function lancamentos()
    {
        return $this->hasMany(Lancamento::class);
    }

    public function scopeIndex($query, $request)
    {
        return $query->with(['produtoRelacionado'])->orderBy('id')
            ->when($request->has('search'), function ($query2) use ($request) {
                return $query2->whereHas('produtoRelacionado', function ($query3) use ($request) {
                    $query3->where('produtos.nome', 'like', '%' . $request->search . '%');
                })->orWhere('id', 'like', '%' . $request->search . '%');
            })
            ->whereDoesntHave('lancamentos', function ($query4) {
                $query4->where('tipo', 'Saida');
            })
            ->paginate(request()->paginacao ?? 10);
    }

    public function scopeInfoProdutoEstoque($query, $produto_estoque_id){
        $produto = $query->with([
            'lote',
            'produtoRelacionado',
            'categoriaRelacionada',
            'marcaRelacionada',
            'fornecedorRelacionado'
        ])->where('id', '=', $produto_estoque_id)->withTrashed()->first();
        $produto->lucro = (($produto->preco_venda / $produto->lote->preco_custo_unitario) * 100) - 100;
        return $produto;
    }
}

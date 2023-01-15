<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model
{
    use HasFactory;
    protected $fillable = [
        'carro_id',
        'data_entrega',
        'descricao',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_entrega'
    ];

    public function carro()
    {
        return $this->belongsTo(Carro::class, 'carro_id');
    }

    public function servicos()
    {
        return Servico::join(
            'servicos_manutencoes',
            'servicos_manutencoes.servico_id',
            '=',
            'servicos.id'
        )
            ->where('servico_manutencoes.manutencao_id', '=', $this->id);
    }
}

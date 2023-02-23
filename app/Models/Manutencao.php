<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Manutencao extends Model
{
    use HasFactory;
    protected $fillable = [
        'carro_id',
        'data_entrega',
        'descricao',
        'status',
        'cliente_id',
        'valor'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_entrega'
    ];

    const STATUS = [
        "pendente" => "Pendente",
        "andamento" => "Em andamento",
        "concluido" => "Concluido",
        "recusado" => "Recusado"
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
            ->where('servicos_manutencoes.manutencao_id', '=', $this->id)->pluck('servicos_manutencoes.servico_id');
    }

}

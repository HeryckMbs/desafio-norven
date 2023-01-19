<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicosManutencoes extends Model
{
    use HasFactory;
    protected $fillable = ['manutencao_id','servico_id'];
}

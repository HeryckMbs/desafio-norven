<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    public function produtosEmEstoque(){
        return $this->hasMany(Estoque::class,);
    }

    public function responsavel(){
        return $this->hasOne(User::class,'id','created_by');
    }
}

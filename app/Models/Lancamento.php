<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function lote(){
        return $this->hasOne(Lote::class,'id','lote_id');
    }
}

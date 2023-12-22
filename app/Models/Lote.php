<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function responsavel()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Carro extends Model
{
    use HasFactory;


    protected $table = 'carros';
    protected $fillable = [
        'cor',
        'modelo',
        'marca_id',
        'dono_id',
        'descricao',
        'ano'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }


    public function store(Request $request)
    {
        dd($request);
        try {
        } catch(\Exception $e) {
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class apiController extends Controller
{
    public function getCarsbyBrand()
    {
        $myCars = Carro::where('dono_id', '=', Auth::id());
        dd($myCars);
    }
}

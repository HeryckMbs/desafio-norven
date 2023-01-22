<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(){
        $estados = json_decode(file_get_contents('http://enderecos.metheora.com/api/estados'));
       
        return view('clientes.index', compact('estados'));
    }
}

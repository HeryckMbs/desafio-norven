<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nome" => "required",
            "codigo" => "required",
            "unidade_medida" => "required",
            "preco_custo" => "required",
            "preco_venda" => "required",
            "categoria" => "gt:-1",
            "marca" => "gt:-1",
            "fornecedor" => "gt:-1",
            // "responsavel" => "required",
        ];
    }

    public function messages(){
        return [
            "nome.required" => "Obrigatório",
            "codigo.required" => "Obrigatório",
            "unidade_medida.required" => "Obrigatório",
            "preco_custo.required" => "Obrigatório",
            "preco_venda.required" => "Obrigatório",
            "categoria.gt" => "Obrigatório",
            "marca.gt" => "Obrigatório",
            "fornecedor.gt" => "Obrigatório",
            // "responsavel.required" => "O campo responsavel é obrigatório",
        ];
    }
}

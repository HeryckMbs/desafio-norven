<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstoqueRequest extends FormRequest
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
            'produto' => 'required|gt:0',
            'dataValidade' => 'required',
            'dataFabricacao' => 'required',
            'preco_custo' => 'required',
            'preco_venda' => 'required',
            "quantidade" => "gt:0",

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'produto.gt' => 'Obrigatório',
            'dataValidade.required' => 'Obrigatório',
            'dataFabricacao.required' => 'Obrigatório',
            'preco_custo.required' => 'Obrigatório',
            'preco_venda.required' => 'Obrigatório',
            "quantidade.gt" => "Deve ser maior que 0",

        ];
    }
}

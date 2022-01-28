<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|max:80|min:5',
            'capacidade' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'Quantidade mínima de caracteres do nome não atingida',
            'nome.max' => 'Quantidade máxima de caracteres do nome excedida',
            'capacidade.required' => 'O campo capacidade é obrigatório',
            'capacidade.numeric' => 'O campo capacidade deve ser numérico',
            'capacidade.min' => 'Quantidade mínima de caracteres do campo capacidade não atingida',
        ];
    }
}

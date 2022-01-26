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
        // dd($this);
        return [
            // 'nome' => 'required|max:80|min:5',
            'nome' => 'required',
            // 'capacidade' => 'required|numeric|min:1',
            'capacidade' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'Quantidade mínima de caracteres do nome não atingida',
            'nome.max' => 'Quantidade máxima de caracteres do nome excedida',
            'capacidade.required' => 'O campo capacidade é obrigatório',
            'capacidade.numeric' => 'O campo stcapacidadeatus deve ser numérico',
            'capacidade.min' => 'Quantidade mínima de caracteres do campo capacidade não atingida',
        ];
    }
}

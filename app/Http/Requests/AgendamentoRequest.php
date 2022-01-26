<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendamentoRequest extends FormRequest
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
            'data_inicio' => 'required|date|after:yesterday',
            'data_termino' => 'required|date|after:yesterday',
            'sala_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'data_inicio.required' => 'O campo Data Início é obrigatório',
            'data_inicio.date' => 'O campo Data Início deve ser uma data',
            'data_inicio.after' => 'O campo Data Início deve ser a partir de hoje',
            'data_termino.required' => 'O campo Data Termino é obrigatório',
            'data_termino.date' => 'O campo Data Termino deve ser uma data',
            'data_termino.after' => 'O campo Data Termino deve ser a partir de hoje',
            'sala_id.required' => 'O campo Sala é obrigatório',
            'sala_id.integer' => 'O campo Sala deve ser inteiro',
        ];
    }
}

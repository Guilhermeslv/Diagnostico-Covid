<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientesRequest extends FormRequest
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
        $dataHoje = strtotime(date('Y-m-d')); //Pega a data do dia atual e transforma para time
        $dataValidator = strtotime('-1 year', $dataHoje); //Subtrai 1 ano da data atual
        return [
            'nome_paciente'=>'required',
            'data_paciente'=>'required|before_or_equal:'.date('Y-m-d', $dataValidator),
            'cpf_paciente'=>'required|cpf',
            'whatsapp_paciente'=>'required', 
            'imagem_paciente'=>'image|mimes:jpg,png,jpeg|max:5120'
        ];
    }
    
    public function messages(){
        return [
        'nome_paciente.required' => 'Insira o Nome do paciente',
        'data_paciente.required'=>'Insira a data de Nascimento',
        'cpf_paciente.required'=>'Insira um CPF',
        'whatsapp_paciente.required'=>'Insira um CPF',
        'data_paciente.before_or_equal'=>'O paciente não pode ter menos de 1 ano',
        'cpf_paciente.cpf'=>'CPF Inválido'
        ];
        

    }
}

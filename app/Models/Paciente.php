<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = ['nome_paciente','data_paciente','cpf_paciente','whatsapp_paciente','imagem_paciente'];
    
    // public function setDataPacienteAttribute($value){        
    //     $this->attributes['data_paciente'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }
    // public function getDataPacienteAttribute($value){
    //     //dd($value);
    //     return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    // }

}

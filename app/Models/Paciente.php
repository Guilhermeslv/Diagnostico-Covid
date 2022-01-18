<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = ['nome_paciente','data_paciente','cpf_paciente','whatsapp_paciente','imagem_paciente'];
}

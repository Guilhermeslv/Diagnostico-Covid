<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use DataTables;

class PacientesController extends Controller
{
    //Lista de pacientes

    public function index(){
        return view('pacientes-list');
    }

    //Add novo paciente

    public function pacientesCad(Request $request){ //$request = new Request;
        //validação de campos do laravel que retorna um json para ser tratado pelo javascript
        $validator = \Validator::make($request->all(),[
            'nome_paciente'=>'required',
            'data_paciente'=>'required',
            'cpf_paciente'=>'required',
            'whatsapp_paciente'=>'required',
            'imagem_paciente'=>'required',     
        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);// Json retornado para o Javascript
        }else{
            //Inicio do cadastro pós validação
            $paciente = new Paciente();
            $paciente->nome_paciente = $request->nome_paciente;
            $paciente->data_paciente = $request->data_paciente;
            $paciente->cpf_paciente = $request->cpf_paciente;
            $paciente->whatsapp_paciente = $request->whatsapp_paciente;
            $paciente->imagem_paciente = $request->imagem_paciente;
            $query = $paciente->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Novo paciente cadastrado!']);
            }

        }

    }

    //Listar todos os pacientes
    public function getPacientesList(){
        $pacientes = Paciente::all();
        return DataTables::of($pacientes)
                            ->addIndexColumn() //substitui o id para não bagunçar a contagem na tabela
                            ->make(true);

    }

    //Fim listar
}

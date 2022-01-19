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
                            ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" id="editPacienteBtn" onClick="editarPaciente('.$row['id'].')">Update</button>
                                                <button class="btn btn-sm btn-danger" id="deleteCountryBt">Delete</button>
                                          </div>';
                              })
                            ->rawColumns(['actions'])
                            ->make(true);

    }

    //Fim listar

    public function pacienteDetalhes($id){
        $pacienteDetalhes = Paciente::find($id);
        return response()->json($pacienteDetalhes);
    }

    public function pacienteAtt(Request $request){
        //$pacienteAtt = new Paciente();
        //$pacienteAtt->find($request->pacienteid)->update($request->all());
        //return response()->json(['code'=>1,'msg'=>'Dados do paciente foram atualizados!']);
        
        $paciente_id = $request->pacienteid; //Requisita o id do campo hidden do modal

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
            $pacienteAtt = Paciente::find($paciente_id);
            $pacienteAtt->nome_paciente = $request->nome_paciente;
            $pacienteAtt->data_paciente = $request->data_paciente;
            $pacienteAtt->cpf_paciente = $request->cpf_paciente;
            $pacienteAtt->whatsapp_paciente = $request->whatsapp_paciente;
            $pacienteAtt->imagem_paciente = $request->imagem_paciente;
            $query = $pacienteAtt->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Dados do paciente atualizados!']);
            }
        }        
        
    }
}

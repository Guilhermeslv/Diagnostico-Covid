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
            'data_paciente'=>'required|before_or_equal:today',
            'cpf_paciente'=>'required|cpf',
            'whatsapp_paciente'=>'required',
            'imagem_paciente'=>'required',     
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);// Json retornado para o Javascript
        }else{
            //dd($request->all());
           $paciente = Paciente::create($request->all());
           
            if(!$paciente){
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
                                                <button class="btn btn-sm btn-primary" id="editPacienteBtn" onClick="editarPaciente('.$row['id'].')">Atualizar</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row->id.'" id="deletePacienteBtn">Apagar</button>
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
            'cpf_paciente'=>'required|cpf',
            'whatsapp_paciente'=>'required',
            'imagem_paciente'=>'required',     
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);// Json retornado para o Javascript
        }else{
            $pacienteAtt = Paciente::find($paciente_id);
            $pacienteAtt->update($request->all());

            if(!$pacienteAtt){
                return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Dados do paciente atualizados!']);
            }
        }        
        
    }

    public function pacienteDelete($id){
        $query = Paciente::find($id)->delete();
        if(!$query){
            return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
        }else{
            return response()->json(['code'=>1,'msg'=>'Paciente deletado!']);
        }
    }
}

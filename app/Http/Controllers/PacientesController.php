<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\PacienteRequest;
use App\Models\Paciente;
use DataTables;

class PacientesController extends Controller
{
    //Lista de pacientes

    public function index(){
        return view('pacientes-list');
    }

    //Add novo paciente

    public function pacientesCad(Request $request){
        $dataHoje = strtotime(date('Y-m-d')); //Pega a data do dia atual e transforma para time
        $dataValidator = strtotime('-1 year', $dataHoje); //Subtrai 1 ano da data atual
        $validator = \Validator::make($request->all(),[
            'nome_paciente'=>'required',
            'data_paciente'=>'required|before_or_equal:'.date('Y-m-d', $dataValidator),
            'cpf_paciente'=>'required|cpf',
            'whatsapp_paciente'=>'required', 
            'imagem_paciente'=>'required|image|mimes:jpg,png,jpeg|max:5120'    
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);// Json retornado para o Javascript
        }else{
           $paciente = new Paciente($request->all());
           if ($imagem = $request->imagem_paciente) {
            $nomeImagem = $request['imagem_paciente']->getClientOriginalName() . strtotime('now') . "." . $imagem->getClientOriginalExtension();
            $imagem->move('img/Pacientes', $nomeImagem);
            $paciente['imagem_paciente'] = $nomeImagem;
            } 

           $paciente->save();
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
                            // ->addIndexColumn() //substitui o id para não bagunçar a contagem na tabela                                                            
                            // $dataHoje = strtotime(date('Y-m-d'));
                            // $nascimento = strtotime($dataPaciente->data_paciente);
                            // $idade = date_diff($dataHoje, $nascimento);
                            ->addColumn('idade',function($dataPaciente){
                                return '<h3>'.$dataPaciente->data_paciente.'</h3>';
                            })
                            ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" id="editPacienteBtn" onClick="editarPaciente('.$row['id'].')">Atualizar</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row->id.'" id="deletePacienteBtn">Apagar</button>
                                          </div>';
                              })
                            ->rawColumns(['actions'])
                            ->make(true);

    }

    //Exibir detalhes do paciente
    public function pacienteDetalhes(Request $request, $id){
        $pacienteDetalhes = Paciente::find($id);
        return response()->json($pacienteDetalhes);
    }

    public function pacienteAtt(Request $request){
        $paciente_id = $request->pacienteid; //Requisita o id do campo hidden do modal
        $dataHoje = strtotime(date('Y-m-d')); //Pega a data do dia atual e transforma para time
        $dataValidator = strtotime('-1 year', $dataHoje); //Subtrai 1 ano da data atual
        $validator = \Validator::make($request->all(),[
            'nome_paciente'=>'required',
            'data_paciente'=>'required|before_or_equal:'.date('Y-m-d', $dataValidator),
            'cpf_paciente'=>'required|cpf',
            'whatsapp_paciente'=>'required',
            'imagem_paciente'=>'image|mimes:jpg,png,jpeg|max:5120'   
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);// Json retornado para o Javascript
        }else{
            $requestComImagem = $request->all();                       
            if ($imagem = $request->imagem_paciente) {
            $nomeImagem = $request['imagem_paciente']->getClientOriginalName() . strtotime('now') . "." . $imagem->getClientOriginalExtension();
            $imagem->move('img/Pacientes', $nomeImagem);
            $requestComImagem['imagem_paciente'] = $nomeImagem;
            }
            $pacienteAtt = Paciente::find($paciente_id)->update($requestComImagem);    
            
                
            
            if(!$pacienteAtt){
                //Passa o valor da imagem que já está no banco para o $requestComImg caso ele não contenha
                
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

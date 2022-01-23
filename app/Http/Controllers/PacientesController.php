<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PacientesRequest;
use App\Models\Paciente;
use App\Models\Sintoma;
use DataTables;

class PacientesController extends Controller
{
    //Lista de pacientes

    public function index(){
        return view('pacientes-list');
    }

    public function cadAtendimento(Request $request, $id){
        $paciente = Paciente::find($id);
        $sintomas = $request->all();
        
        if($paciente->sintoma){
            //$sintomaOBJ = Sintoma::where('paciente_id', $id);
            $sintomaDoPaciente = $paciente->sintoma;
            $sintomaDoPaciente->sintomas = $sintomas['sintoma'];
            $sintomaDoPaciente->update();
            return response()->json(['msg'=>'Atendimento cadastrado!']);
        }else{
            $sintomaOBJ = new Sintoma($sintomas['sintoma']);
            $sintomaOBJ->sintomas = $request->sintoma;
            $paciente->sintoma()->save($sintomaOBJ);
            return response()->json(['msg'=>'Atendimento cadastrado!']);
        }
        
    }
    public function fichaPaciente(Request $request, $id){
        $pacienteSintomas = Paciente::with('sintoma')->find($id);
        return response()->json($pacienteSintomas);
    }
    //Add novo paciente
    public function pacientesCad(PacientesRequest $request){
            $paciente = Paciente::make($request->all());
            if ($imagem = $request->imagem_paciente) {
                $nomeImagem = $request['imagem_paciente']->getClientOriginalName() . strtotime('now') . "." . $imagem->getClientOriginalExtension();
                $imagem->move('img/Pacientes', $nomeImagem);
                $paciente['imagem_paciente'] = $nomeImagem;
            } 

           $paciente->save();
           return response()->json(['code'=>1,'msg'=>'Dados do paciente atualizados!']);
    }

    //Listar todos os pacientes
    public function getPacientesList(){
        $pacientes = Paciente::all();
        return DataTables::of($pacientes)
                            ->addColumn('ficha', function($row){
                                return '<div class="btn-group">
                                            <button class="btn btn-sm btn-warning" data-id="'.$row['id'].'" id="fichaBTN">Ver ficha</button>
                                        </div>';
                            })
                            ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" id="editPacienteBtn" onClick="editarPaciente('.$row['id'].')">Atualizar</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row->id.'" id="deletePacienteBtn">Apagar</button>
                                                <button class="btn btn-sm btn-success" data-id="'.$row['id'].'" id="atendimento">Atendimento</button>
                                          </div>';
                              })
                            ->rawColumns(['actions', 'ficha'])
                            ->make(true);

    }

    //Exibir detalhes do paciente
    public function pacienteDetalhes(Request $request, $id){
        $pacienteDetalhes = Paciente::find($id);
        return response()->json($pacienteDetalhes);
    }

    public function pacienteAtt(PacientesRequest $request){
            $paciente_id = $request->pacienteid; //Requisita o id do campo hidden do modal
            if ($request->hasFile('imagem_paciente')){
                $BdImg = Paciente::find($paciente_id);//Resgata o nome da imagem original no BD
                $caminhoImg ='img/Pacientes/'.$BdImg['imagem_paciente'];//Define o Path para imagem
                unlink($caminhoImg);//Exclui a imagem
            }
            $paciente = $request->validated(); 
            if ($imagem = $request->imagem_paciente) {
                $nomeImagem = $request['imagem_paciente']->getClientOriginalName() . strtotime('now') . "." . $imagem->getClientOriginalExtension();
                $imagem->move('img/Pacientes', $nomeImagem);
                $paciente['imagem_paciente'] = $nomeImagem;
            }
            Paciente::find($paciente_id)->update($paciente);   
            return response()->json(['code'=>1,'msg'=>'Dados do paciente atualizados!']);
    }

    public function pacienteDelete($id){
        $query = Paciente::find($id);
        $caminhoImg ='img/Pacientes/'.$query->imagem_paciente;
        if(isset($query->sintoma)){
            $query->sintoma->delete();
        }
        unlink($caminhoImg);
        $query->delete();
        if(!$query){
            return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
        }else{
            return response()->json(['code'=>1,'msg'=>'Paciente deletado!']);
        }
    }
}

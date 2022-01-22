<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PacientesRequest;
use App\Models\Paciente;
use DataTables;

class PacientesController extends Controller
{
    //Lista de pacientes

    public function index(){
        return view('pacientes-list');
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
                            ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" id="editPacienteBtn" onClick="editarPaciente('.$row['id'].')">Atualizar</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row->id.'" id="deletePacienteBtn">Apagar</button>
                                          </div>';
                              })
                            ->rawColumns(['actions','idade'])
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
                $caminhoImg ='img/pacientes/'.$BdImg['imagem_paciente'];//Define o Path para imagem
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
        $caminhoImg ='img/pacientes/'.$query->imagem_paciente;
        unlink($caminhoImg);
        $query->delete();
        if(!$query){
            return response()->json(['code'=>0,'msg'=>'Aconteceu um erro!']);
        }else{
            return response()->json(['code'=>1,'msg'=>'Paciente deletado!']);
        }
    }
}

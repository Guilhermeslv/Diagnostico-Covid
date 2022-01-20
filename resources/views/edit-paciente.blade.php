<div class="modal editPacientes" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Informações do paciente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('paciente.att'); }}" method="post"  id="att-paciente">
          @csrf
        <div class="modal-body">            
                <input type="hidden" name="pacienteid">                
                <div class="form-group">
                    <label for="">Nome do Paciente</label>
                    <input type="text" class="form-control" name="nome_paciente"placeholder="Digite o nome do paciente">
                    <span class="text-danger error-text nome_paciente_error"></span>
                </div>
                <div class="form-group">    
                    <label for="">Data de nascimento</label>
                    <input type="date" class="form-control" name="data_paciente"placeholder="Digite a data de nascimento do paciente">
                    <span class="text-danger error-text data_paciente_error"></span>
                  </div>
                <div class="form-group">    
                    <label for="">CPF do Paciente</label>
                    <input type="text" class="form-control cpf_paciente" name="cpf_paciente"placeholder="Digite o CPF do paciente">
                    <span class="text-danger error-text cpf_paciente_error"></span>
                  </div>
                <div class="form-group">    
                    <label for="">Whatsapp</label>
                    <input type="text" class="form-control whatsapp_paciente" name="whatsapp_paciente"placeholder="Digite o whatsapp do paciente">
                    <span class="text-danger error-text whatsapp_paciente_error"></span>
                  </div>
                <div class="form-group">    
                    <label for="">Imagem</label>
                    <input type="text" class="form-control" name="imagem_paciente"placeholder="Insira uma imagem do paciente">
                    <span class="text-danger error-text imagem_paciente_error"></span>
                  </div>            
                  
        </div>
        <div class="modal-footer">  
          <div class="form-group">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
          </div>   
        </div>
      </form>
      </div>
    </div>
  </div>
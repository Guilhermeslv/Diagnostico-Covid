<div class="modal editPacientes" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Informações do paciente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <form action="">
                <input type="hidden" name="pacienteid">
                
                <div class="form-group">
                    <label for="">Nome do Paciente</label>
                    <input type="text" class="form-control" name="nome_paciente" placeholder="Digite o nome do paciente">
                </div>
                <div class="form-group">    
                    <label for="">Data de nascimento</label>
                    <input type="text" class="form-control" name="data_paciente" placeholder="Digite a data de nascimento do paciente">
                </div>
                <div class="form-group">    
                    <label for="">CPF do Paciente</label>
                    <input type="text" class="form-control" name="cpf_paciente" placeholder="Digite o CPF do paciente">
                </div>
                <div class="form-group">    
                    <label for="">Whatsapp</label>
                    <input type="text" class="form-control" name="whatsapp_paciente" placeholder="Digite o whatsapp do paciente">
                </div>
                <div class="form-group">    
                    <label for="">Imagem</label>
                    <input type="text" class="form-control" name="imagem_paciente" placeholder="Insira uma imagem do paciente">
                </div>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
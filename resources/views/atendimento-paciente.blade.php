<div class="modal atendimentoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selecione os sintomas do paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="atendimento-form">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="pacienteid">          
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Febre" class="form-check-input">
              <label for="" class="form-check-label">Febre</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Coriza" class="form-check-input">
              <label for="" class="form-check-label">Coriza</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Nariz Entupido" class="form-check-input">
              <label for="" class="form-check-label">Nariz Entupido</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Cansaço" class="form-check-input">
              <label for="" class="form-check-label">Cansaço</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Tosse" class="form-check-input">
              <label for="" class="form-check-label">Tosse</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Dor de cabeça" class="form-check-input">
              <label for="" class="form-check-label">Dor de cabeça</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Dores no corpo" class="form-check-input">
              <label for="" class="form-check-label">Dores no corpo</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Mal estar geral" class="form-check-input">
              <label for="" class="form-check-label">Mal estar geral</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Dor de garganta" class="form-check-input">
              <label for="" class="form-check-label">Dor de garganta</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Dificuldade de respirar" class="form-check-input">
              <label for="" class="form-check-label">Dificuldade de respirar</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Falta de paladar" class="form-check-input">
              <label for="" class="form-check-label">Falta de paladar</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Falta de olfato" class="form-check-input">
              <label for="" class="form-check-label">Falta de olfato</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Dificuldade de locomoção" class="form-check-input">
              <label for="" class="form-check-label">Dificuldade de locomoção</label>            
            </div>
            <div class="form-check">
              <input type="checkbox" name="sintoma[]" value="Diarréia" class="form-check-input">
              <label for="" class="form-check-label">Diarréia</label>            
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>        
          <button type="submit" class="btn btn-primary" id="sintomasAtendimentoBTN">Salvar sintomas</button>
        </div>
    </form>
    </div>
  </div>
</div>
<div class="modal ficha" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ficha do paciente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          @csrf
          <div class="modal-body">
            <h3 class="statusDoPaciente"></h1>
                <br>
            <ul class="list-group lista-sintomas">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
          </div>
      </div>
    </div>
  </div>
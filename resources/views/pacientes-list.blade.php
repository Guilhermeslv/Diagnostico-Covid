<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csfr-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de pacientes</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pacientes</div>
                    <div class="card-body">
                        <table class="table table-hover table-condensed" id="pacientes_table">
                            <thead>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>CPF</th>
                                <th>Whatsapp</th>
                                <th>Imagem</th>
                                <th>Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Cadastro de Pacientes</div>
                    <div class="card-body">
                        <form action="{{ route('pacientes.cad') }}" method="post" id="pacientes-cad-form">
                            @csrf
                            <div class="form-group">
                                <label for="">Nome do Paciente</label>
                                <input type="text" class="form-control" name="nome_paciente" placeholder="Digite o nome do paciente">
                                <span class="text-danger error-text nome_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Data de nascimento</label>
                                <input type="text" class="form-control" name="data_paciente" placeholder="Digite a data de nascimento do paciente">
                                <span class="text-danger error-text data_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">CPF do Paciente</label>
                                <input type="text" class="form-control" name="cpf_paciente" placeholder="Digite o CPF do paciente">
                                <span class="text-danger error-text cpf_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Whatsapp</label>
                                <input type="text" class="form-control" name="whatsapp_paciente" placeholder="Digite o whatsapp do paciente">
                                <span class="text-danger error-text whatsapp_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Imagem</label>
                                <input type="text" class="form-control" name="imagem_paciente" placeholder="Insira uma imagem do paciente">
                                <span class="text-danger error-text imagem_paciente_error"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success" id="cad-paciente">Cadastrar</button>
                            </div>
                        </form>
                    </div>                
            </div>
        </div>
    </div>
    @include('edit-paciente')
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script>

        toastr.options.preventDuplicates = true;
                
        $.ajaxSetup({ //Referencia o token csrf de uma maneira global
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            }
        });
        
        $(function(){
            //Adicionar novo paciente
            $("#pacientes-cad-form").on("submit", function(e){
                e.preventDefault(); //Previne o comportamento padrão do botão submit de enviar o formulário
                var form = this;                
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    
                    //Inicio da Validação de campos

                    beforeSend:function(){
                        $(form).find('span.error-text').text('');
                        //Localiza o campos span antes do formulário ser enviado
                    },
                    success:function(data){
                        if(data.code == 0){//Validação baseada no código de erro retornado pelo json do pacientesCad()
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]); //Preenche o campo span de erro com o erro retornado pelo json
                            });
                        }else{
                            $(form)[0].reset();
                            //alert('data.msg'); 
                            $('#pacientes_table').DataTable().ajax.reload(null, false); //Recarrega a tabela quando é realizado o cadastro
                            toastr.success(data.msg); //Notificação de sucesso
                        }
                    //Fim da validação de campos
                    }
                });
            })
           
            //Listar todos os pacientes

            $('#pacientes_table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.pacientes.list') }}",
                "pageLenght":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]], //Configura os padrões de exibição da tabela
                columns:[
                    //{data:'id', name:'id'}, //Traz o id do banco de dados
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'nome_paciente', name:'nome_paciente'},
                    {data:'data_paciente', name:'data_paciente'},
                    {data:'cpf_paciente', name:'cpf_paciente'},
                    {data:'whatsapp_paciente', name:'whatsapp_paciente'},
                    {data:'imagem_paciente', name:'imagem_paciente'},
                    {data:'actions', name:'actions'},
                ]
            });
            
            //Script btn edit
           
        });//Final $(function
        function editarPaciente(id){
                //console.log(id);
                var paciente_id = id;
                //console.log(paciente_id);
                let url_edit = "{{ route('paciente.detalhes', ':id') }}";
                url_edit = url_edit.replace(':id', id);
                $.ajax({
                    url: url_edit,
                    method:'GET',
                    dataType:'json',
                    contentType:false,
                    success:function(details){
                        console.log(details);
                        $('.editPacientes').find('input[name="pacienteid"]').val(details.nome_paciente);
                        $('.editPacientes').find('input[name="nome_paciente"]').val(details.nome_paciente);
                        $('.editPacientes').find('input[name="data_paciente"]').val(details.data_paciente);
                        $('.editPacientes').find('input[name="cpf_paciente"]').val(details.cpf_paciente);
                        $('.editPacientes').find('input[name="whatsapp_paciente"]').val(details.whatsapp_paciente);
                        $('.editPacientes').find('input[name="imagem_paciente"]').val(details.imagem_paciente);
                        $('.editPacientes').modal('show');
                    },
                    error:function(details){
                        console.log(details);
                    },
            });
            }
    </script>
</body>
</html>
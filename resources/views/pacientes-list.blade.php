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
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Ficha</th>
                                {{-- <th>Data</th>
                                <th>CPF</th>
                                <th>Whatsapp</th>
                                <th>Imagem</th> --}}
                                <th>Ações</th>
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
                        <form action="{{ route('pacientes.cad') }}" method="post" id="pacientes-cad-form" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="" >Nome do Paciente</label>
                                <input type="text" class="form-control" name="nome_paciente" placeholder="Digite o nome do paciente">
                                <span class="text-danger error-text nome_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_paciente" placeholder="Digite a data de nascimento do paciente">
                                <span class="text-danger error-text data_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">CPF do Paciente</label>
                                <input type="text" class="form-control cpf_paciente" name="cpf_paciente" placeholder="Digite o CPF do paciente">
                                <span class="text-danger error-text cpf_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Whatsapp</label>
                                <input type="text" class="form-control whatsapp_paciente" name="whatsapp_paciente" placeholder="Digite o whatsapp do paciente">
                                <span class="text-danger error-text whatsapp_paciente_error"></span>
                            </div>
                            <div class="form-group">    
                                <label for="">Imagem</label>
                                <input type="file" class="form-control" name="imagem_paciente">
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
    @include('edit-paciente');
    @include('atendimento-paciente')
    @include('ficha')
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('jquery-mask/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.cpf_paciente').mask('000.000.000-00', {reverse:true, placeholder:'___.___.___-__'});
            $('.whatsapp_paciente').mask('(00) 00000-0000', {placeholder:'(__) _____-____'});
        });
    </script>
    <script>

        toastr.options.preventDuplicates = true;
                
        $.ajaxSetup({ //Referencia o token csrf de uma maneira global
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            }
        });
            //Calcular Status do paciente
            function calcularStatus(qtdSintomas){
                var sintomas = qtdSintomas;
                var totalSintomas = 14;
                var porcentagem = (sintomas*100)/totalSintomas;

                if (porcentagem<40){ return('SINTOMAS INSUFICIENTES'); } 
                else if (porcentagem>=40 && porcentagem<60){ return('POTENCIAL INFECTADO'); }
                else if (porcentagem>=60){ return('POSSÍVEL INFECTADO'); } 
                else{ return('Houve algum erro!'); } 
            }
            //Modal de atendimento
            $(document).on('click','#atendimento',function(e){
                e.preventDefault();
                var paciente_id = $(this).data("id");
                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Essa ação irá iniciar um novo atendimento",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim!'
                    }).then((result) => {
                    if (result.isConfirmed) {                        
                        $('.atendimentoModal').modal('show');
                        $('#atendimento-form').on('submit',function(e){
                            e.preventDefault();
                            var urlCadAtendimento = '{{ route("cad.atendimento",":id") }}';
                            urlCadAtendimento = urlCadAtendimento.replace(':id', paciente_id);
                            var form = this;
                            $('#atendimento-form').find('input[name="pacienteid"]').val(paciente_id);
                            $.ajax({                    
                                url:urlCadAtendimento,                    
                                method:$(form).attr('method'),
                                data:new FormData(form),
                                processData:false,
                                dataType:'json',
                                contentType:false,
                                success:function(data){

                                        $('.atendimentoModal').modal('hide');
                                        $("form#atendimento-form")[0].reset();
                                        //$('input[name="sintoma[]"]').reset();
                                        toastr.success(data.msg);
                                    
                                },
                                error:function(data){
                                    console.log(data);
                                }
                            });
                            //Fim AJAX
                        });
                    }
                    });

            });

            //Modal de ficha
            $(document).on('click','#fichaBTN',function(e){
                e.preventDefault();
                var paciente_id = $(this).data("id");
                let url_edit = "{{ route('ficha.atendimento', ':id') }}";
                url_edit = url_edit.replace(':id', paciente_id);
                $.ajax({
                    url: url_edit,
                    method:'GET',
                    dataType:'json',
                    contentType:false,
                    success:function(data){
                        if(data.sintoma==null){
                            toastr.error('Você precisa iniciar um atendimento para ver a ficha do paciente!');
                        }else{
                            var arraySintomas = data.sintoma['sintomas'];
                            var qtdSintomas = arraySintomas.length;
                            form = $('.ficha');
                            // Percorre o array para exibir na lista
                            contador = 0;
                            $(form).find('.statusDoPaciente').text(calcularStatus(qtdSintomas));
                            $.each(arraySintomas, function(prefix, val){ 
                                str = '<li class="list-group-item">'+arraySintomas[contador]+'</li>';
                                html = $.parseHTML(str);
                                $(form).find('.lista-sintomas').append(html);
                                contador++;
                            });
                            contador=0;

                            //Abre o modal
                            $('.ficha').modal('show');
                            $(".ficha").on("hidden.bs.modal", function () {//Captura o evento de fechar o modal
                                $("ul").empty();//Define a Ul como vazia
                                $(".statusDoPaciente").empty();//Define o Status como vazio
                            });                            
                            
                        }
                    },
                    error:function(data){
                        console.log(details);
                    },
                });                
            });
            
            //Calcular idade
            function calcularIdade (nascimento) {
                nascimento = new Date(nascimento);
                var hoje = new Date();

                var anos = (hoje.getFullYear() - nascimento.getFullYear());

                if (hoje.getMonth() < nascimento.getMonth() || 
                    hoje.getMonth() == nascimento.getMonth() && hoje.getDate() < nascimento.getDate()) {
                    anos--;
                }

                return anos;
            }

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
                    success:function(data){
                            $('#pacientes_table').DataTable().ajax.reload(null, false); //Recarrega a tabela quando é realizado o cadastro
                            $('#pacientes-cad-form')[0].reset();
                            toastr.success(data.msg); //Notificação de sucesso
                    },
                    error:function(data){
                        if(data.status == 422){//Validação baseada no status da requisição 422 Unprocessable content                 
                            $.each(data.responseJSON.errors, function(prefix, val){ //Para cada campo vazio a função mostra o span de erro
                                $(form).find('span.'+prefix+'_error').text(val); //Preenche o campo span de erro com o erro retornado pelo json                            
                            });
                        }
                    }
                });
            });
           
            //Listar todos os pacientes
            $('#pacientes_table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.pacientes.list') }}",
                pageLenght:5,
                aLengthMenu:[[5,10,25,50,-1],[5,10,25,50,"All"]], //Configura os padrões de exibição da tabela
                columns:[
                    // {data:'id', name:'id'}, //Traz o id do banco de dados
                    // {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},
                    {data:'imagem_paciente', name:'imagem_paciente', orderable:false, searchable:false,
                            "render": function (data) {
                                return '<img src="img/Pacientes/' + data + '" alt="' + data + '"height="50" width="50" style="img{border-radius:50%;}"/>';
                            }
                    },
                    {data:'nome_paciente', name:'nome_paciente'},
                    {data:'data_paciente', name:'data_paciente', "render": function(data){return calcularIdade(data);}},
                    {data:'ficha', name:'ficha'},//Preenchendo a coluna status... Resgatar do banco de dados
                    {data:'actions', name:'actions', orderable:false, searchable:false},                 
                    
                ]
            });

            //Script botão para abrir o modal de edição com as informações do paciente
            function editarPaciente(id){
                    var paciente_id = id;
                    let url_edit = "{{ route('paciente.detalhes', ':id') }}";

                    url_edit = url_edit.replace(':id', id);
                    //view editar paciente
                    $.ajax({
                        url: url_edit,
                        method:'GET',
                        dataType:'json',
                        contentType:false,
                        success:function(details){

                            $('.editPacientes').find('input[name="pacienteid"]').val(details.id);
                            $('.editPacientes').find('input[name="nome_paciente"]').val(details.nome_paciente);
                            $('.editPacientes').find('input[name="data_paciente"]').val(details.data_paciente);
                            $('.editPacientes').find('input[name="cpf_paciente"]').val(details.cpf_paciente);
                            $('.editPacientes').find('input[name="whatsapp_paciente"]').val(details.whatsapp_paciente);
                            $('.imagem_paciente').attr('src', 'public/Pacientes/'+details.imagem_paciente);
                            $('.editPacientes').modal('show');
                        },
                        error:function(details){
                            console.log(details);
                        },
                });
            }      

            //Botão de atualizar paciente
            $('#att-paciente').on('submit',function(e){
                e.preventDefault();
                var form = this;
                $.ajax({                    
                    url:$(form).attr('action'),                    
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    success:function(data){
                            $('#pacientes_table').DataTable().ajax.reload(null, false); //Recarrega a tabela quando é realizado o cadastro
                            $('.editPaciente').modal('hide');
                            $('#pacientes-cad-form')[0].reset(); 
                            toastr.success(data.msg); //Notificação de sucesso
                    },
                    error:function(data){
                        if(data.status == 422){//Validação baseada no status da requisição 422 Unprocessable content                 
                            $.each(data.responseJSON.errors, function(prefix, val){ //Para cada campo vazio a função mostra o span de erro
                                $(form).find('span.'+prefix+'_error').text(val); //Preenche o campo span de erro com o erro retornado pelo json                            
                            });
                        }
                    }
                });
            });

            //Botão de deletar
            $(document).on('click', '#deletePacienteBtn', function () {
                var paciente_id = $(this).data("id");
                var urlDelete = '{{ route("paciente.delete",":id") }}';
                urlDelete = urlDelete.replace(':id', paciente_id);
                console.log(urlDelete);
                //Sweet Alert
                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Gostaria de DELETAR esse paciente?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim, deletar!'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({                    
                            url: urlDelete,
                            method:'get',
                            dataType:'json',
                            processData:false,
                            contentType:false,
                            success:function(data){
                                $('#pacientes_table').DataTable().ajax.reload(null, false); //Recarrega a tabela quando é realizado o cadastro
                                toastr.success(data.msg);
                            },
                            error:function(data){
                                toastr.error(data.msg);
                            },
                        });

                    }
                    });
                    //fim sweet alert 
            });
    </script>
</body>
</html>
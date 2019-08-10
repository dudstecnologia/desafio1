@extends('adminlte::page')

@section('title', 'Aluno')

@section('content_header')
    <h1 style="display: inline;">Aluno</h1>

    @if(!isset($aluno))
    <div class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add">Novo Aluno</button>
        <a class="btn btn-success" href="{{ url('/relatorio') }}">Relatorio</a>
    </div>
    @endif
@stop

@section('content')

<div class="modal fade" id="modal-delete">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center">Atenção</h4>
            </div>
            <div class="modal-body">
              <p class="text-center"> Deseja mesmo excluir este Aluno? </p>
            </div>

            <div class="modal-footer">
                    <form id="formDelete" action="" method="post">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sim</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Novo Aluno</h4>
                </div>
                <div class="modal-body">
                    <form role="form-horizontal" method="POST" action="{{ isset($aluno) ? url('aluno/' . $aluno->id_encrypt) :  url('/aluno') }}">
                        <div class="box-body">
    
                            {{ csrf_field() }}
    
                            <div class="row">
                                <div class="col-sm-5">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="{{ isset($aluno) ? $aluno->nome : '' }}" required>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <label>Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento" value="{{ isset($aluno) ? $aluno->data_nascimento : '' }}" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Curso</label>
                                    <select class="form-control" name="id_curso" required>
                                        @foreach ($cursos as $c)
                                            <option value="{{ $c->id_encrypt }}" {{ isset($aluno) && $aluno->id_curso_encrypt == $c->id_encrypt ? 'selected' : '' }}>{{ $c->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-2">
                                    <label>Cep</label>
                                    <input type="text" class="form-control" id="cep" name="cep" onblur="buscaCep(this.value)" value="{{ isset($aluno) ? $aluno->cep : '' }}">
                                </div>

                                <div class="col-sm-4">
                                    <label>Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ isset($aluno) ? $aluno->logradouro : '' }}">
                                </div>
                                <div class="col-sm-2">
                                    <label>Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" value="{{ isset($aluno) ? $aluno->numero : '' }}">
                                </div>
                                <div class="col-sm-4">
                                    <label>Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="{{ isset($aluno) ? $aluno->bairro : '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ isset($aluno) ? $aluno->cidade : '' }}">
                                </div>

                                <div class="col-sm-4">
                                    <label>Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" value="{{ isset($aluno) ? $aluno->estado : '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-danger" id="alerta-cep"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <label>&nbsp; &nbsp;</label>
                                    <button type="submit" class="form-control btn btn-primary">Salvar</button>
                                </div>

                                <div class="col-sm-2">
                                    <label>&nbsp; &nbsp;</label>
                                    <a class="form-control btn btn-danger" href="{{ url('/') }}">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    @if(isset($alunos))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Professor</th>
                        <th>Opções</th>
                    </tr>
                
                    @foreach ($alunos as $a)
                        <tr>
                            <td>{{ $a->nome_aluno }}</td>
                            <td>{{ $a->nome_curso }}</td>
                            <td>{{ $a->nome_professor }}</td>
                            <td> 
                                <a class="btn btn-info btn-xs" href="aluno/{{ $a->id_encrypt }}">Editar</a>
                                <button class="btn btn-danger btn-xs" data-id="{{ $a->id_encrypt }}" data-toggle="modal" data-target="#modal-delete">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                
                </tbody>

            </table>

            </div>
            <!-- /.box-body -->

            <div class="box-footer clearfix">
                    {{ $alunos->links() }}
            </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
    @endif

@stop

@section('js')

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    @if(isset($aluno)) <script>$('#modal-add').modal({backdrop: 'static', keyboard: false});</script> @endif

    <script>
        
        function buscaCep(cep) {
            
            axios.get(`http://api.postmon.com.br/v1/cep/${cep}`)
                .then(response => {
                    
                    var end = response.data;

                    $("#logradouro").val(end.logradouro);
                    $("#bairro").val(end.bairro);
                    $("#cidade").val(end.cidade);
                    $("#estado").val(end.estado_info.nome);
                    $("#alerta-cep").text("");
                    $("#numero").focus();
                })
                .catch(error => {
                    
                    $("#alerta-cep").text("Endereço não encontrado");
                });
        }

        $('#modal-delete').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);

            var id = button.data('id');

            $('#formDelete').attr("action", "{{ url('/aluno') }}" + "/" + id);
        });
    </script>
@stop
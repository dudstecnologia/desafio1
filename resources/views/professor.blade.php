@extends('adminlte::page')

@section('title', 'Professor')

@section('content_header')
    <h1>Professor</h1>
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
              <p class="text-center"> Deseja mesmo excluir este professor? </p>
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

    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <!-- form start -->
                <form role="form-horizontal" method="POST">
                    <div class="box-body">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-5">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="nome" value="{{ isset($professor) ? $professor->nome : '' }}" required>
                            </div>
                            <div class="col-sm-3 col-md-2">
                                <label>Data de Nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" value="{{ isset($professor) ? $professor->data_nascimento : '' }}" required>
                            </div>
                            <div class="col-sm-2">
                                <label>&nbsp; &nbsp;</label>
                                <button type="submit" class="form-control btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- /.row -->
    
    @if(isset($professores))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Nome</th>
                        <th style="width: 150px">Data de Nascimento</th>
                        <th style="width: 150px">Data de Criação</th>
                        <th>Opções</th>
                    </tr>
                
                    @forelse ($professores as $p)
                        <tr>
                            <td>{{ $p->nome }}</td>
                            <td>{{ $p->data_nascimento }}</td>
                            <td>{{ $p->data_criacao }}</td>
                            <td> 
                                <a class="btn btn-info btn-xs" href="professor/{{ $p->id_encrypt }}">Editar</a>
                                <button class="btn btn-danger btn-xs" data-id="{{ $p->id_encrypt }}" data-toggle="modal" data-target="#modal-delete">Excluir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"><p class="text-center text-danger">Nenhum Professor Cadastrado<p></td>
                        </tr>
                    @endforelse
                
                </tbody>

            </table>

            </div>
            <!-- /.box-body -->

            <div class="box-footer clearfix">
                    {{ $professores->links() }}
            </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
    @endif
@stop

@section('js')
    <script>
    $('#modal-delete').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);

        var id = button.data('id');

        $('#formDelete').attr("action", "{{ url('/professor') }}" + "/" + id);
    });
    </script>
@stop
@if($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <!-- <h4><i class="icon fa fa-check"></i> Sucesso!</h4> -->
    {{ $message }}
</div>
@endif

@if($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <!-- <h4><i class="icon fa fa-ban"></i> Erro!</h4> -->
    {{ $message }}
</div>
@endif

@if($message = Session::get('alert'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <!-- <h4><i class="icon fa fa-ban"></i> Erro!</h4> -->
    {{ $message }}
</div>
@endif
@extends('admin.layout')
@section('titulo', 'Editar Sector')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Sector: {{ $sector->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		{!!Form::model($sector,['method'=>'PATCH','route'=>['sectores.update',$sector->id]])!!}
        {{Form::token()}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$sector->nombre}}" >
            </div>
        </div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="ambiente">Ambiente</label>
                    <select name="idambiente" id="idambiente" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguna</option>
                        @foreach ($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}" {{ $ambiente->id == $sector->idambiente ? 'selected="selected"' : '' }}>{{$ambiente->nombre}}</option>
                        @endforeach
                    </select>
        </div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="subambiente">Subambiente</label>
                    <select name="idsubambiente" id="idsubambiente" class="select2" style="width: 100%;" class="form-control" required>
                    <option value="0">Ninguna</option>
                        @foreach ($subambientes as $subambiente)
                            <option value="{{$subambiente->id}}" {{ $subambiente->id == $sector->idsubambiente ? 'selected="selected"' : '' }}>{{$subambiente->nombre}}</option>
                        @endforeach
                    </select>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="comentarios">Comentarios</label>
            	<input type="text" name="comentarios" class="form-control" value="{{$sector->comentarios}}" >
            </div>
        </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
	           	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
        </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
@section('script')
<script>  
    
$(document).ready(function() {
            //Busca subambiente con el ambiente
            $('#idambiente').on('change', function() {
            var idambiente = $(this).val();
            var ruta='{{asset('buscarSubambientesConIdAmbiente')}}/'+idambiente;
            if(idambiente) {
                $.ajax({
                    url: ruta,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {

                    var sel = $("#idsubambiente");
                    var selected="";
                    sel.empty();
                    sel.append('<option value="" >Seleccione un Subambiente</option>');
                    for (var i=0; i<data.length; i++) {
                        sel.append('<option value="' + data[i].id + '" '+selected+'>' + data[i].nombre + '</option>');
                    }
                  }
                });
            }else{
              $('#idsector').empty();
            }

        });
    });
</script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>

<script>
$(function () {
//Initialize Select2 Elements
$('.select2').select2()
})
</script>
@endsection

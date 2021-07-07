@extends('admin.layout')
@section('titulo', 'Registrar Sectores')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Sector</h3>
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
    </div>

	{!!Form::open(array('url'=>'admin/sectores','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="nombre">Nombre</label>
               	<input type="text" name="nombre" class="form-control" placeholder="Nombre..." required="required">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="ambiente">Ambiente</label>
                    <select name="idambiente" id="idambiente" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Seleccione un Ambiente</option>
                        @foreach ($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}">
                                {{$ambiente->nombre }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="subambiente">Subambiente</label>
                  <select name="idsubambiente" id="idsubambiente" class="form-control" required="required">
            		<option value="" selected> Seleccione un Subambiente </option>
				</select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="comentarios">Comentarios</label>
                <textarea  maxlength="1000" name="comentarios" class="form-control" placeholder="Ingrese comentarios"></textarea>
            </div>  
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<button class="btn btn-primary" type="submit">Guardar</button>
               	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
        </div>
    </div>
	{!!Form::close()!!}
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
                    //console.log(data); 

                    sel.empty();
                    sel.append('<option value="" >Seleccione un Subambiente</option>');
                    for (var i=0; i<data.length; i++) {
                        sel.append('<option value="' + data[i].id + '" '+selected+'>' + data[i].nombre + '</option>');
                    }
                  }
                });
            }else{
              $('#idsubambiente').empty();
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

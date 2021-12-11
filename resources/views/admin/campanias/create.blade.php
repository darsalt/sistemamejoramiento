@extends('admin.layout')
@section('titulo', 'Registrar Campaña')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva Campaña</h3>
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

	{!!Form::open(array('url'=>'admin/campanias','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="nombre">Nombre</label>
               	<input type="text" name="nombre" class="form-control" placeholder="Año..." required="required">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de Inicio </label><br>
                <input class="form-control" name="fechainicio" id="fechaevaluacion" type="date">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de Finalización </label><br>
                <input class="form-control" name="fechafin" id="fechafin" type="date">
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
              	<button class="btn btn-primary" type="submit" id="btnSave">Guardar</button>
               	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
        </div>
    </div>
	{!!Form::close()!!}
</div>

@endsection

@section('script')
    <script>
        $('#btnSave').click(function(){
            Swal.fire({
                title: 'Creando campaña',
                text: 'Se están asociando los tachos activos a la campaña creada. Por favor espere...',
                didOpen: () => {
                    Swal.showLoading()
                },
                allowOutsideClick: false
            });
        });
    </script>
@endsection
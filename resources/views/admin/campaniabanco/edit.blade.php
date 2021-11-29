@extends('admin.layout')
@section('titulo', 'Editar Campaña de Banco de Germoplasma')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Campaña Banco de Germoplasma: {{ $campaniabanco->nombre}}</h3>
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
		{!!Form::model($campaniabanco,['method'=>'PATCH','route'=>['campaniabanco.update',$campaniabanco->id]])!!}
        {{Form::token()}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$campaniabanco->nombre}}" >
            </div>
        </div>
		<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
        	        <label for="fechainicio">Fecha de Inicio</label>
            	       <input type="date" name="fechainicio" class="form-control" value="{{$campaniabanco->fechainicio}}" >
                </div>
            </div>
        </div>
		<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
        	        <label for="fechafin">Fecha de Finalización</label>
            	       <input type="date" name="fechafin" class="form-control" value="{{$campaniabanco->fechafin}}" >
                </div>
            </div>
        </div>        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="comentarios">Comentarios</label>
            	<input type="text" name="comentarios" class="form-control" value="{{$campaniabanco->comentarios}}" >
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
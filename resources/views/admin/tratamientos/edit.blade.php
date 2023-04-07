@extends('admin.layout')
@section('titulo', 'Editar Tratamiento')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Tratamiento: {{ $tratamiento->nombre}}</h3>
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
		{!!Form::model($tratamiento,['method'=>'PATCH','route'=>['tratamientos.update',$tratamiento->idtratamiento], 'enctype'=>'multipart/form-data'])!!}
        {{Form::token()}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Tratamiento</label>
            	<input type="text" name="nombre" class="form-control" value="{{$tratamiento->nombre}}" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="descripcion">Descripción</label>
            	<input type="text" name="descripcion" class="form-control" value="{{$tratamiento->descripcion}}" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <input type="file" name="registros" class="form-control" id="registros">
                <label class="custom-file-label" for="registros">Seleccionar archivo</label>
            </div>
	    </div>

		<div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
	           	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
			
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Amanecer</th>
					<th>Atardecer</th>
					<th>Fotoperiodo</th>
				</thead>
               @foreach ($registros as $t)
				<tr>
					<td>{{ $t->fecha }}</td>
					<td>{{ $t->amanecer }}</td>
					<td>{{ $t->atardecer }}</td>
					<td>{{ $t->fotoperiodo }}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>


            
        </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
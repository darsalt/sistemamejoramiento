@extends('admin.layout')
@section('titulo', 'Editar Subambiente')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Submbiente: {{ $subambiente->nombre}}</h3>
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
		{!!Form::model($subambiente,['method'=>'PATCH','route'=>['subambientes.update',$subambiente->id]])!!}
        {{Form::token()}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$subambiente->nombre}}" >
            </div>
        </div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="ambiente">Ambiente</label>
                    <select name="idambiente" id="idambiente" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguna</option>
                        @foreach ($ambientes as $ambiente)
                            <option value="{{$ambiente->id}}" {{ $ambiente->id == $subambiente->idambiente ? 'selected="selected"' : '' }}>{{$ambiente->nombre}}</option>

                        @endforeach
                    </select>
        </div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="comentarios">Comentarios</label>
            	<input type="text" name="comentarios" class="form-control" value="{{$subambiente->comentarios}}" >
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
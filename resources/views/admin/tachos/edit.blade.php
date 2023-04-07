@extends('admin.layout')
@section('titulo', 'Editar Tacho')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Tacho: {{ $tacho->codigotacho}}</h3>
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
		{!!Form::model($tacho,['method'=>'PATCH','route'=>['tachos.update',$tacho->idtacho]])!!}
        {{Form::token()}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="codigo">Tacho</label>
            	<input type="text" name="codigo" class="form-control" value="{{$tacho->codigo}}" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="subcodigo">Subtacho</label>
            	<input type="text" name="subcodigo" class="form-control" value="{{$tacho->subcodigo}}" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="variedad">Clones</label>
                    <select name="idvariedad" id="idvariedad" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguno</option>
                        @foreach ($variedades as $variedad)
                            <option value="{{$variedad->idvariedad}}" {{ $variedad->idvariedad == $tacho->idvariedad ? 'selected="selected"' : '' }}>{{$variedad->nombre}}</option>

                        @endforeach
                    </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="destino">Destino</label>
                    <select name="destino" id="destino" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="1" {{ 1 == $tacho->destino ? 'selected="selected"' : '' }}>Tachos de progenitores</option>
                        <option value="2" {{ 2 == $tacho->destino ? 'selected="selected"' : '' }}>Cuarentena</option>

                    </select>
        </div>        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            <label for="estado">Estado</label>
                    <select name="inactivo" id="inactivo" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0" {{ 0 == $tacho->inactivo ? 'selected="selected"' : '' }}>Activo</option>
                        <option value="1" {{ 1 == $tacho->inactivo ? 'selected="selected"' : '' }}>Inactivo</option>

                    </select>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="fechaalta">Fecha Alta</label>
                <input type="date" name="fechaalta" class="form-control" value="{{$tacho->fechaalta}}" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
            	<label for="observaciones">Observaciones</label>
            	<input type="text" name="observaciones" class="form-control" value="{{$tacho->observaciones}}" >
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
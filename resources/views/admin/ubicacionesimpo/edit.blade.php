@extends('admin.layout')
@section('titulo', 'Editar Ubicación')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Box: {{ $ubicacion->nombreubicacion}}</h3>
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
        {!!Form::model($ubicacion,['method'=>'PATCH','route'=>['ubicacionesimpo.update',$ubicacion->idubicacion]])!!}
        {{Form::token()}}
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="box">Nombre de la ubicación</label>
                        <input type="text" name="nombreubicacion" id="nombreubicacion" class="form-control" value="{{$ubicacion->nombreubicacion}}" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default">
                        <div class="card-body">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Seleccione los tachos para asociar al box</label>
                              <select class="duallistbox" multiple="multiple" name="tachos[]" id="tachos">
                                @foreach ($tachos as $tacho)
                                <option value="{{$tacho->idtacho}}" {{ $tacho->idubicacion>0 ? 'selected="selected"' : '' }}>{{$tacho->nombretacho}}</option>
                                @endforeach
                              </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>      
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
            	       <label for="observaciones">Observaciones</label>
            	       <input type="text" name="observaciones" id="observaciones" class="form-control" value="{{$ubicacion->observaciones}}" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
	           	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                </div>
            </div>
        </div>

			{!!Form::close()!!}		
            
	</div>
@endsection

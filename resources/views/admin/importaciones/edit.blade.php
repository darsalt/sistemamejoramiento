@extends('admin.layout')
@section('titulo', 'Editar importación')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar datos de la importación: {{ $importacion->nombrevariedad}}</h3>
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
			{!!Form::model($importacion,['method'=>'PATCH','route'=>['importaciones.update',$importacion->idimportacion]])!!}
            {{Form::token()}}

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                          <label for="variedad">Variedad</label>
                            <select name="idvariedad" id="idvariedad" class="select2" style="width: 100%;" class="form-control" required>
                                <option value="">Seleccione una Variedad</option>
                                @foreach ($variedades as $variedad)
                                    <option value="{{$variedad->idvariedad}}" {{ $variedad->idvariedad == $importacion->idvariedad ? 'selected="selected"' : '' }}>{{$variedad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                          <label for="tacho">Tachos</label>
                            <select name="idtacho" id="idtacho" class="select2" style="width: 100%;"  class="form-control" required>
                                <option value="">Seleccione un Tacho</option>
                                @foreach ($tachos as $tacho)
                                    <option value="{{$tacho->idtacho}}" {{ $tacho->idtacho == $importacion->idtacho ? 'selected="selected"' : '' }}>
                                        {{$tacho->codigo}} - {{$tacho->subcodigo}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Ubicación</label>
                          <select name="idubicacion" id="idubicacion" class="form-control select" style="width: 100%;" required>
                            <option value="0">Seleccione una Ubicación</option>
                                    @foreach ($ubicaciones as $ubicacion)
                                    <option value="{{$ubicacion->idubicacion}}" {{ $ubicacion->idubicacion == $importacion->idubicacion ? 'selected="selected"' : '' }}>
                                        {{$ubicacion->nombreubicacion}}
                                    </option>
                                @endforeach
                          </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Lote</label>
                          <select name="idlote" id="idlote" class="form-control select" style="width: 100%;" required>
                            <option value="0">Seleccione un Lote</option>
                                    @foreach ($lotes as $lote)
                                    <option value="{{$lote->idlote}}" {{ $lote->idlote == $importacion->idlote ? 'selected="selected"' : '' }}>
                                        {{$lote->nombrelote}}
                                    </option>
                                @endforeach
                          </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="date">Fecha Ingreso </label><br>
                        <input class="form-control" name="fechaingreso" id="fechaingreso" type="date" required="required" value="{{$importacion->fechaingreso}}">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="date">Fecha Egreso </label><br>
                        <input class="form-control" name="fechaegreso" id="fechaegreso" type="date" value="{{$importacion->fechaegreso}}">
                    </div>
                </div>
<!--                 <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" id="estado" class="form-control select" style="width: 100%;" required>
                            <option value="0">Seleccione un Estado</option>
                            <option value="1">Sigue en Cuarentena</option>
                            <option value="2">Salió de Cuarentena</option>
                          </select>
                    </div>
                </div> -->
            </div> 
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea  maxlength="1000" name="observaciones" class="form-control" placeholder="Ingrese observaciones" >{{$importacion->observaciones}}</textarea>
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
	</div>
@endsection
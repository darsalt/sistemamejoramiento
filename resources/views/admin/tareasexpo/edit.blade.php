@extends('admin.layout')
@section('titulo', 'Editar Tarea')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Tarea: {{ $tarea->codigotarea}}</h3>
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
			{!!Form::model($tarea,['method'=>'PATCH','route'=>['tareas.update',$tarea->idtarea]])!!}
            {{Form::token()}}

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                          <label for="tacho">Tacho</label>
                            <select name="idtacho" id="idtacho" class="select2" style="width: 100%;"  class="form-control" required>
                                <option value="">Seleccione un Tacho</option>
                                @foreach ($tachos as $tacho)
                                    <option value="{{$tacho->idtacho}}">
                                        {{$tacho->codigo}} - {{$tacho->subcodigo}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                          <label for="variedad">Variedad</label>
                            <select name="idvariedad" id="idvariedad" class="select2" style="width: 100%;" class="form-control" required>
                                <option value="">Seleccione una Variedad</option>
                                @foreach ($variedades as $variedad)
                                    <option value="{{$variedad->idvariedad}}">
                                        {{$variedad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Tipo Tarea</label>
                          <select name="idtipotarea" id="idtipotarea" class="form-control select" style="width: 100%;" required>
                            <option value="">Seleccione el tipo de tarea</option>
                            <option value="1">Fertilización</option>
                            <option value="2">Limpieza</option>
                            <option value="3">Corte</option>
                            <option value="4">Aplicaciones</option>
                          </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
            	       <label for="fechaalta">Fecha Realización</label>
            	       <input type="date" name="fecharealizacion" class="form-control" value="{{$tarea->fecharealizacion}}" >
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Estado Tarea</label>
                        <select name="idestado" id="idestado" class="form-control select" style="width: 100%;" required>
                        <option value="">Seleccione el tipo de tarea</option>
                            <option value="">Seleccione un estado</option>
                            <option value="1">Pendiente</option>
                            <option value="2">En ejecución</option>
                            <option value="3">Finalizada</option>
                            <option value="4">Cancelada</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divproducto">
                    <div class="form-group">
                        <label for="producto">Producto</label>
                        <input type="text" name="producto" id="producto" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divdosis">
                    <div class="form-group">
                        <label for="dosis">Dosis</label>
                        <input type="text" name="dosis" id="dosis" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
            	       <label for="observaciones">Observaciones</label>
            	       <input type="text" name="observaciones" class="form-control" value="{{$tarea->observaciones}}" >
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
@section('script')
    <script>
        $(document).ready(function(){
            $('#idtipotarea').on('change', function() {
                var idtipotarea = $(this).val();
                if(idtipotarea==1 || idtipotarea==4){
                    $("#divproducto").css("display", "block");
                    $("#divdosis").css("display", "block");
                }
                else{
                    $("#divproducto").css("display", "none");
                    $("#divdosis").css("display", "none");
                }
            }).change();;

        
        });

    </script>


    
@endsection
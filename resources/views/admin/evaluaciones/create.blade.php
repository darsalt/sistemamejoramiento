@extends('admin.layout')
@section('titulo', 'Registrar Evaluación')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Evaluación</h3>
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

		{!!Form::open(array('url'=>'admin/evaluaciones','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}
        <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                  <label for="tacho">Tachos</label>
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
                <label>Tipo de Evaluación</label>
                  <select name="idtipoevaluacion" id="idtipoevaluacion" class="form-control select" style="width: 100%;" required>
                    <option value="">Seleccione un tipo de evaluación</option>
                    <option value="1">Sanitaria</option>
                    <option value="2">otra</option>
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de evaluación </label><br>
                <input class="form-control" name="fechaevaluacion" id="fechaevaluacion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Estado de la Evaluación</label>
                  <select name="idestado" id="idestado" class="form-control select" style="width: 100%;" required>
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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divsanitaria">
            <div class="form-group">
                <label for="roya">Roya</label>
                <input type="number" name="roya" id="roya" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divotra">
            <div class="form-group">
                <label for="algo">Algo</label>
                <input type="text" name="algo" id="algo" class="form-control" placeholder="Algo...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" class="form-control" placeholder="Ingrese observaciones"></textarea>
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
        $(document).ready(function(){
            $('#idtipoevaluacion').on('change', function() {
                var idtipoevaluacion = $(this).val();
                if(idtipoevaluacion==1){
                    $("#divsanitaria").css("display", "block");
                    $("#divotra").css("display", "block");
                }
                else{
                    $("#divsanitaria").css("display", "none");
                    $("#divotra").css("display", "none");
                }
            }).change();;

        
        });

    </script>


    
@endsection
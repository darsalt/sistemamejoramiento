@extends('admin.layout')
@section('titulo', 'Evaluaciones')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Evaluaciones realizadas sobre la variedad <b>{{$importacion[0]->nombrevariedad}}</b> en el tacho <b>{{$importacion[0]->codigo}}-{{$importacion[0]->subcodigo}}</b>, ubicado en el Box <b>{{$importacion[0]->idubicacion}}</b>.</h3>
	</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

    <fieldset style="border-width: 1px; border-style: solid; border-color: #337ab7; padding: 15px">
		<legend>Evaluaciones Realizadas</legend>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-condensed table-hover">
							<thead>
								<th>Tipo Evaluación</th>
								<th>Fecha</th>
								<th>Observaciones</th>
							</thead>
			               @foreach ($evaluacionesasociadas as $t)
							<tr>
								<td>{{ $t->nombre}}</td>
								<td>{{ $t->fechaevaluacion}}</td>
								<td>{{ $t->observaciones}}</td>
							</tr>
							@endforeach
						</table>
					</div>
					{{$evaluacionesasociadas->render()}}
				</div>
			</div>
		</div>
	</fieldset>

   	<fieldset style="border-width: 1px; border-style: solid; border-color: #337ab7; padding: 15px">
	<legend>Nueva Evaluación</legend>
	<div class="panel-body">
		{!!Form::open(array('url'=>'admin/evaluaciones','method'=>'POST','autocomplete'=>'off'))!!}
	    {{Form::token()}}
	    <input type="hidden" value="{{$importacion[0]->idvariedad}}" id="idvariedad" name="idvariedad">
			<input type="hidden" value="{{$importacion[0]->idtacho}}" id="idtacho" name="idtacho">
		<input type="hidden" value="{{$importacion[0]->idubicacion}}" id="idubicacion" name="idubicacion">
		<input type="hidden" value="{{$importacion[0]->idimportacion}}" id="idimportacion" name="idimportacion">
	    <input type="hidden" value="1" id="portacho" name="portacho">

		<div class="row">
	        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	            <div class="form-group">
	                <label>Tipo de Evaluación</label>
	                  <select name="idtipoevaluacion" id="idtipoevaluacion" class="form-control select" style="width: 100%;" required>
	                    <option value="0">Seleccione un tipo de evaluación</option>
	                    <option value="1">Evaluaciones sanitaria</option>
	                    <option value="2">Otras Evaluaciones</option>
	                  </select>
	            </div>
	        </div>
	      	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<div class="form-group">
	                <label for="date">Fecha de evaluación </label><br>
	                <input class="form-control" name="fechaevaluacion" id="fechaevaluacion" type="date" required="required">
            	</div>
        	</div>
	    </div>
	    <div id="divsanitaria">
		    <div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="carbon">Carbón</label>
		                <input type="text" name="carbon" id="carbon" class="form-control">
		            </div>
		        </div>
		       	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="escaladura">Escaladura</label>
		                <input type="text" name="escaladura" id="escaladura" class="form-control">
		            </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="estriaroja">Estria roja</label>
		                <input type="text" name="estriaroja" id="estriaroja" class="form-control">
		            </div>
		        </div>
		       	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="mosaico">Mosaico</label>
		                <input type="text" name="mosaico" id="mosaico" class="form-control">
		            </div>
		        </div>
		    </div>	
		   	<div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="royamarron">Roya Marrón</label>
		                <input type="text" name="royamarron" id="royamarron" class="form-control">
		            </div>
		        </div>
		       	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="amarillamiento">amarillamiento</label>
		                <input type="text" name="amarillamiento" id="amarillamiento" class="form-control">
		            </div>
		        </div>
		    </div>	    
		</div>
		<div   id="divotra">
	   	    <div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="altura">Altura</label>
		                <input type="text" name="altura" id="altura" class="form-control">
		            </div>
		        </div>
		       	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divotra">
		            <div class="form-group">
		                <label for="floracion">Floración</label>
		                <input type="text" name="floracion" id="floracion" class="form-control">
		            </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		            <div class="form-group">
		                <label for="grosor">Grosor</label>
		                <input type="text" name="grosor" id="grosor" class="form-control">
		            </div>
		        </div>
		       	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divotra">
		            <div class="form-group">
		                <label for="macollaje">Macollaje</label>
		                <input type="text" name="macollaje" id="macollaje" class="form-control">
		            </div>
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
	</div>
	</fieldset>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#idtipoevaluacion').on('change', function() {
                var idtipoevaluacion = $(this).val();
                if(idtipoevaluacion==0){
                    $("#divsanitaria").css("display", "none");
                    $("#divotra").css("display", "none");
                }
                if(idtipoevaluacion==1){
                    $("#divsanitaria").css("display", "block");
                    $("#divotra").css("display", "none");
                }
                if(idtipoevaluacion==2){
                    $("#divsanitaria").css("display", "none");
                    $("#divotra").css("display", "block");
                }
            }).change();;

        
        });

    </script>
@endsection
@extends('admin.layout')
@section('titulo', 'Inspecciones')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Inspecciones realizadas sobre la ubicación <b>{{$ubicacion[0]->nombreubicacion}}</b>.</h3>
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
    <legend>Tachos en la ubicación {{$ubicacion[0]->nombreubicacion}}:</legend>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Tacho</th>
                                <th>Variedad</th>
                            </thead>
                           @foreach ($tachos as $t)
                            <tr>
                                <td>{{ $t->nombretacho}}</td>
                                <td>{{ $t->nombrevariedad}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$inspeccionesasociadas->render()}}
                </div>
            </div>
        </div>
    </fieldset>

   	<fieldset style="border-width: 1px; border-style: solid; border-color: #337ab7; padding: 15px">
	<legend>Registrar Inspecciones a los tachos de un Box</legend>
	<div class="panel-body">
	{!!Form::open(array('url'=>'admin/inspecciones','files' => 'true','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <input type="hidden" value="{{$ubicacion[0]->idubicacion}}" id="idubicacion" name="idubicacion">
    <input type="hidden" value="{{$tachos}}" id="tachos" name="tachos[]">

    <input type="hidden" value="0" id="portacho" name="portacho">

     <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de inspección </label><br>
                <input class="form-control" name="fechainspeccion" id="fechainspeccion" type="date" required="required">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="certificado">Certificado</label>&nbsp;&nbsp;&nbsp;
<!--  -->
                <input id="certificado" type="file" class="form-control" name="certificado">
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
	</fieldset>
</div>

@endsection
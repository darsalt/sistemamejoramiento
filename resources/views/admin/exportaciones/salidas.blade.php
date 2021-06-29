@extends('admin.layout')
@section('titulo', 'Salidas')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Exportaciones realizadas sobre la variedad <b>{{$exportacion[0]->nombrevariedad}}</b></h3>
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
        <legend>Exportaciones Realizadas</legend>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>País</th>
                                <th>Programa</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                            </thead>
                           @foreach ($salidasasociadas as $t)
                            <tr>
                                <td>{{ $t->pais}}</td>
                                <td>{{ $t->programa}}</td>
                                <td>{{ $t->fecharealizacion}}</td>
                                <td>{{ $t->observaciones}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$salidasasociadas->render()}}
                </div>
            </div>
        </div>
    </fieldset>

   	<fieldset style="border-width: 1px; border-style: solid; border-color: #337ab7; padding: 15px">
	<legend>Nueva Salida</legend>
	<div class="panel-body">
	{!!Form::open(array('url'=>'admin/salidas','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <input type="hidden" value="{{$exportacion[0]->idvariedad}}" id="idvariedad" name="idvariedad">
	<input type="hidden" value="{{$exportacion[0]->idexportacion}}" id="idexportacion" name="idexportacion">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Destino</label>
                  <select name="pais" id="pais" class="form-control select" style="width: 100%;" required>
                    <option value="">Seleccione un País</option>
                    <option value="Australia">Australia</option>
                    <option value="Brasil">Brasil</option>
                    <option value="Francia">Francia</option>
                    <option value="Italia">Italia</option>
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="programa">Programa</label>
                <input type="text" name="programa" id="programa" class="form-control" >
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de realización </label><br>
                <input class="form-control" name="fecharealizacion" id="fecharealizacion" type="date" required="required">
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
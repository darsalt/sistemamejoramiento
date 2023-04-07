@extends('admin.layout')
@section('titulo', 'Tareas')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Tareas realizadas sobre el lote <b>{{$lote[0]->nombrelote}}</b>.</h3>
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
    <legend>Tarea Realizadas</legend>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Tipo Tarea</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                            </thead>
                           @foreach ($tareasasociadas as $t)
                            <tr>
                                <td>{{ $t->nombre}}</td>
                                <td>{{ $t->fecharealizacion}}</td>
                                <td>{{ $t->observaciones}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$tareasasociadas->render()}}
                </div>
            </div>
        </div>
    </fieldset>

   	<fieldset style="border-width: 1px; border-style: solid; border-color: #337ab7; padding: 15px">
	<legend>Nueva Tarea</legend>
	<div class="panel-body">
	{!!Form::open(array('url'=>'admin/tareas','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <input type="hidden" value="{{$lote[0]->idlote}}" id="idlote" name="idlote">

     <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Lote</label>
                  <select name="idtipotarea" id="idtipotarea" class="form-control select" style="width: 100%;" required>
                    <option value="">Seleccione un lote</option>
                    <option value="1">Lote 1</option>
                    <option value="2">Lote 2</option>
                    <option value="3">Lote 3</option>
                    <option value="4">Lote 4</option>
                  </select>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Tipo de Tarea</label>
                  <select name="idtipotarea" id="idtipotarea" class="form-control select" style="width: 100%;" required>
                    <option value="">Seleccione un tipo de tarea</option>
                    <option value="1">Fertilización</option>
                    <option value="2">Limpieza</option>
                    <option value="3">Corte</option>
                    <option value="4">Aplicaciones</option>
                  </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha de realización </label><br>
                <input class="form-control" name="fecharealizacion" id="fecharealizacion" type="date" required="required">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divproducto">
            <div class="form-group">
                <label for="producto">Producto</label>
                <input type="text" name="producto" id="producto" class="form-control" placeholder="Producto...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="divdosis">
            <div class="form-group">
                <label for="dosis">Dosis</label>
                <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Dosis...">
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
@extends('admin.layout')
@section('titulo', 'Inspecciones')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Inspecciones realizadas sobre la variedad <b>{{$importacion[0]->nombrevariedad}}</b> en el tacho <b>{{$importacion[0]->codigo}}-{{$importacion[0]->subcodigo}}</b>, ubicado en el Box <b>{{$importacion[0]->idubicacion}}</b>.</h3>
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
    <legend>Inspecciones Realizadas</legend>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Fecha</th>
                                <th>Certificado</th>
                                <th>Observaciones</th>
                            </thead>
                           @foreach ($inspeccionesasociadas as $t)
                            <tr>
                                <td>{{ $t->fechainspeccion}}</td>
                                <td>@if (!is_null( $t->certificado))
                                        <a target="_blank" href="{{asset('/certificados/'.$t->certificado.'')}}">{{ $t->certificado}}</a>
                                    @endif

                                </td>
                                <td>{{ $t->observaciones}}</td>
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
	<legend>Nueva Inspección</legend>
	<div class="panel-body">
	{!!Form::open(array('url'=>'admin/inspecciones','files' => 'true','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

    <input type="hidden" value="{{$importacion[0]->idvariedad}}" id="idvariedad" name="idvariedad">
	<input type="hidden" value="{{$importacion[0]->idtacho}}" id="idtacho" name="idtacho">
	<input type="hidden" value="{{$importacion[0]->idubicacion}}" id="idubicacion" name="idubicacion">
	<input type="hidden" value="{{$importacion[0]->idimportacion}}" id="idimportacion" name="idimportacion">
    <input type="hidden" value="1" id="portacho" name="portacho">


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
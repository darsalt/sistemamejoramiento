@extends('admin.layout')
@section('titulo', 'Registrar Box')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva ubicación para exportación</h3>
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

	{!!Form::open(array('url'=>'admin/ubicacionesexpo','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <input type="hidden" name="area" id="area" value="expo">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre de la ubicación</label>
                <input type="text" name="nombreubicacion" id="nombreubicacion" class="form-control" placeholder="Nombre de la ubicación...">
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-default">
                <div class="card-body">
                    <div class="form-group">
                      <label>Seleccione los tachos para asociar al box</label>
                      <select class="duallistbox" multiple="multiple" name="tachos[]" id="tachos">
                        @foreach ($tachos as $tacho)
                        <option value="{{$tacho->idtacho}}">{{$tacho->nombretacho}}</option>
                        @endforeach
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
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


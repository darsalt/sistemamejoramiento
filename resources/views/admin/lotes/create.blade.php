@extends('admin.layout')
@section('titulo', 'Registrar Lote')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Lote</h3>
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

	{!!Form::open(array('url'=>'admin/lotes','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombrelote">Lote</label>
                <input type="text" name="nombrelote" id="nombrelote" class="form-control" placeholder="Nombre del lote...">
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label>Seleccione los tachos para asociar al lote</label>
                      <select class="duallistbox" multiple="multiple">
                        <option selected>Tacho 1A</option>
                        <option>Tacho 1B</option>
                        <option>Tacho 1C</option>
                        <option>Tacho 1D</option>
                        <option>Tacho 2A</option>
                        <option>Tacho 2B</option>
                        <option>Tacho 2C</option>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
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


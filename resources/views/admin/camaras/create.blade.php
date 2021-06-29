@extends('admin.layout')
@section('titulo', 'Registrar Tratamientos')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Tratamientos</h3>
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

	<form action="{{ url('admin/tratamientos') }}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="nombre">Nombre</label>
               	<input type="text" name="nombre" class="form-control" placeholder="Nombre..." required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea  maxlength="1000" name="descripcion" class="form-control" placeholder="Ingrese la descripción" required></textarea>
            </div>  
        </div>
    </div>
    <div class="row">
        <label for="registros"> Cargar archivo</label>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <input type="file" name="registros" class="form-control" id="registros" required accept=".xls,.xlsx">
                <label id="registro" class="custom-file-label" for="registros" >Seleccionar archivo</label>
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
    </form>


</div>

@endsection
@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Proveedor: {{ $proveedor->nombreproveedor}}</h3>
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
			{!!Form::model($proveedor,['method'=>'PATCH','route'=>['proveedor.update',$proveedor->idproveedor]])!!}
            {{Form::token()}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="codigo">Código</label>
            	<input type="text" name="codigo" class="form-control" value="{{$proveedor->Codigo}}" >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$proveedor->NombreProveedor}}" >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="cuit">CUIT</label>
            	<input type="text" name="cuit" class="form-control" value="{{$proveedor->CUIT}}" >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="domicilio">Domicilio</label>
            	<input type="text" name="domicilio" class="form-control" value="{{$proveedor->Domicilio}}" >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="telefono">Teléfono</label>
            	<input type="text" name="telefono" class="form-control" value="{{$proveedor->Telefono}}" >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
            	<label for="email">Email</label>
            	<input type="text" name="correoelectronico" class="form-control" value="{{$proveedor->CorreoElectronico}}" >
            </div>
        </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
	           	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
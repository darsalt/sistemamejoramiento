@extends('layouts.admin')
@section('contenido')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Proveedor <a href="proveedor/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('almacen.proveedor.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Código</th>
					<th>Nombre</th>
					<th>CUIT</th>
					<th>Domicilio</th>
					<th>Teléfono</th>
					<th>E-mail</th>
				</thead>
               @foreach ($proveedores as $e)
				<tr>
					<td>{{ $e->Codigo}}</td>
					<td>{{ $e->NombreProveedor}}</td>
					<td>{{ $e->CUIT}}</td>
					<td>{{ $e->Domicilio}}</td>
					<td>{{ $e->Telefono}}</td>
					<td>{{ $e->CorreoElectronico}}</td>
					<td>
					
						<a href="{{URL::action('ProveedorController@edit',$e->idproveedor)}}"><button class="btn btn-info">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{$e->idproveedor}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('almacen.proveedor.modal')
				@endforeach
			</table>
		</div>
		{{$proveedores->render()}}
	</div>
</div>

@endsection
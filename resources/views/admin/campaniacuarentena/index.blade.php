@extends('admin.layout')
@section('titulo', 'Campañas de Cuarentena')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado Campañas de Cuarentena  <a href="campaniacuarentena/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.campaniacuarentena.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($campaniacuarentena as $c)
				<tr>
					<td>{{ $c->nombre}}</td>
					<td>{{ $c->fechainicio}}</td>
					<td>{{ $c->fechafin}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('CampaniaCuarentenaController@edit',$c->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$c->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.campaniacuarentena.modal')
				@endforeach
			</table>
		</div>
		{{$campaniacuarentena->render()}}
	</div>
</div>
@include('admin.campaniacuarentena.view')
@endsection
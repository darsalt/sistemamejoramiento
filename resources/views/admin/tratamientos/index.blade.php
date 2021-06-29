@extends('admin.layout')
@section('titulo', 'Tratamientos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Tratamientos <a href="tratamientos/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.tratamientos.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tratamiento</th>
					<th>nombre</th>
					<th>Descripción</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($tratamientos as $t)
				<tr>
					<td>{{ $t->idtratamiento}}</td>
					<td>{{ $t->nombre}}</td>
					<td>{{ $t->descripcion}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('TratamientoController@edit',$t->idtratamiento)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$t->idtratamiento}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.tratamientos.modal')
				@endforeach
			</table>
		</div>
		{{$tratamientos->render()}}
	</div>
</div>
@include('admin.tratamientos.view')
@endsection
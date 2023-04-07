@extends('admin.layout')
@section('titulo', 'Tareas')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Tareas <a href="tareas/create">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
		@include('admin.tareas.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tacho</th>
					<th>Variedad</th>
					<th>Tipo Tarea</th>
					<th>Fecha</th>
					<th>Estado</th>
					<th>Observaciones</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($tareas as $t)
				<tr>
					<td>{{ $t->codigo}} - {{ $t->subcodigo}}</td>
					<td>{{ $t->nombrevariedad}}</td>
					<td>{{ $t->idtipotarea}}</td>
					<td>{{ $t->fecharealizacion}}</td>
					<td>{{ $t->idestado}}</td>
					<td>{{ $t->observaciones}}</td>
					<td>
					    <a href="" data-target="#modal-delete-{{$t->idtarea}}" data-toggle="modal">  <i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('TareaController@edit',$t->idtarea)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$t->idtarea}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.tareas.modal')
				@endforeach
			</table>
		</div>
		{{$tareas->render()}}
	</div>
</div>

@endsection
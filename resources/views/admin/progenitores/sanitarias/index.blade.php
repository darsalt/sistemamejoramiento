@extends('admin.layout')
@section('titulo', 'Evaluaciones Sanitarias')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Evaluaciones Sanitarias a tachos de progenitores <a href="sanitariasp/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.progenitores.sanitarias.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Campaña</th>
					<th>Fecha Generación</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($sanitariasp as $t)
				<tr>
					<td>{{ $t->nombre}}</td>
					<td>{{$t->nombre_campania}}</td>
					<td>{{ $t->fechageneracion}}</td>
					<td>{{ $t->observaciones}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('ProgenitoresSanitariaController@edit',$t->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

					    <a href="" data-target="#modal-delete-{{$t->id}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('ProgenitoresSanitariaController@datosasociados',$t->id)}}"><i class="fa fa-table fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.progenitores.sanitarias.modal')
				@endforeach
			</table>
		</div>
		{{$sanitariasp->render()}}
	</div>
</div>
@include('admin.progenitores.sanitarias.view')
@endsection
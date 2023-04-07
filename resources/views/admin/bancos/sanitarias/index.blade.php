@extends('admin.layout')
@section('titulo', 'Evaluaciones Sanitarias')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Evaluaciones Sanitarias <a href="sanitarias/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.bancos.sanitarias.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Banco</th>
					<th>Nombre</th>
					<th>Fecha Generación</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($sanitarias as $t)
				<tr>
					<td>{{ $t->banco}}</td>
					<td>{{ $t->nombre}}</td>
					<td>{{ $t->fechageneracion}}</td>
					<td>{{ $t->observaciones}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('SanitariaController@edit',$t->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

					    <a href="" data-target="#modal-delete-{{$t->id}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('SanitariaController@datosasociados',$t->id)}}"><i class="fa fa-table fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.bancos.sanitarias.modal')
				@endforeach
			</table>
		</div>
		{{$sanitarias->render()}}
	</div>
</div>
@include('admin.bancos.sanitarias.view')
@endsection
@extends('admin.layout')
@section('titulo', 'Exportaciones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de variedades a exportar <a href="exportaciones/create">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
		@include('admin.exportaciones.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Variedad</th>
					<th>Tacho</th>
					<th>Box</th>
					<th>Ingreso a Cuarentena</th>
					<!-- <th>Fecha Egreso</th> -->
					<th>Operaciones</th>
				</thead>
               @foreach ($exportaciones as $t)
				<tr>
					<td>{{ $t->nombrevariedad}}</td>
					<td>{{ $t->codigo}}-{{ $t->subcodigo}}</td>
					<td>{{ $t->idubicacion}}</td>
					<td>{{ $t->fechaingreso}}</td>
					<!-- <td>{{ $t->fechaegreso}}</td> -->
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@edit',$t->idexportacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						<a href="" data-target="#modal-delete-{{$t->idexportacion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@salidasasociadas',$t->idexportacion)}}"><i class="fa fa-plus fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@tareasasociadas',$t->idexportacion)}}"><i class="fa fa-tasks fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@evaluacionesasociadas',$t->idexportacion)}}"><i class="fa fa-calculator fa-lg"></i></a>&nbsp;&nbsp;


<!-- 					    <a href="" data-target="#modal-delete-{{$t->idexportacion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a> -->
					</td>
				</tr>
				@include('admin.exportaciones.modal')
				@endforeach
			</table>
		</div>
		{{$exportaciones->render()}}
	</div>
</div>
@include('admin.exportaciones.view')
@endsection
@extends('admin.layout')
@section('titulo', 'importaciones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de variedades a importar <a href="{{route('importaciones.ingresos.create')}}">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
		{{-- @include('admin.importaciones.search') --}}
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Box</th>
					<th>Tacho</th>
					<th>Fecha ingreso</th>
					<th>Lote cuarentenario</th>
					<th>Origen</th>
					<th>Estado</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($importaciones as $i)
				<tr>
					<td>{{$i->box->nombre}}</td>
					<td>{{$i->tacho->codigo . ' ' . $i->tacho->subcodigo}}</td>
					<td>{{$i->fechaingreso}}</td>
					<td>{{$i->lote_cuarentenario}}</td>
					<td>{{$i->origen}}</td>
					<td>{{$i->estado}}</td>
					<td>
{{--  					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ImportacionController@edit',$t->idimportacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						<a href="" data-target="#modal-delete-{{$t->idimportacion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('ImportacionController@tareasasociadas',$t->idimportacion)}}"><i class="fa fa-tasks fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ImportacionController@evaluacionesasociadas',$t->idimportacion)}}"><i class="fa fa-calculator fa-lg"></i></a>&nbsp;&nbsp; 
						<a href="{{URL::action('ImportacionController@inspeccionesasociadas',$i->idimportacion)}}"><i class="fa fa-glasses fa-lg"></i></a> --}}

 					    <a href="" data-target="#modal-delete-{{$i->idimportacion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a> &nbsp; &nbsp;
						@if ($i->tacho->estado != 'Baja')
							<a href="" title="Dar de baja tacho" data-target="#modal-bajatacho-{{$i->idimportacion}}" data-toggle="modal">  <i class="fa fa-arrow-down fa-lg"></i></a>
					 	@endif
					</td>
				</tr>
				@include('admin.importaciones.modal')
				@endforeach
			</table>
		</div>
		{{$importaciones->render()}}
	</div>
</div>
@include('admin.importaciones.view')
@endsection
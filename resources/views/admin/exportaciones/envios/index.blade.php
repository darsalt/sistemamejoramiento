@extends('admin.layout')
@section('titulo', 'Envíos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Envíos <a href="{{route('exportaciones.envios.create')}}">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		{{-- @include('admin.exportaciones.search') --}}
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Box</th>
					<th>Tacho</th>
					<th>Cantidad de yemas</th>
					<th>Fecha</th>
					<th>Programa de mejoramiento</th>
					<th>Pais destino</th>
                    <th></th>
				</thead>
               @foreach ($envios as $e)
				<tr>
					<td>{{$e->box->nombre}}</td>
					<td>{{$e->tacho->codigo . ' ' . $e->tacho->subcodigo}}</td>
					<td>{{$e->cant_yemas}}</td>
					<td>{{$e->fecha}}</td>
					<td>{{$e->programa}}</td>
                    <td>{{$e->destino}}</td>
					<td>
					   	{{-- <i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp; --}}
{{-- 						<a href="{{URL::action('ExportacionController@edit',$e->idexportacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@salidasasociadas',$e->idexportacion)}}"><i class="fa fa-plus fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@tareasasociadas',$e->idexportacion)}}"><i class="fa fa-tasks fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('ExportacionController@evaluacionesasociadas',$e->idexportacion)}}"><i class="fa fa-calculator fa-lg"></i></a>&nbsp;&nbsp; --}}
						<a href="" title="Eliminar envío" data-target="#modal-delete-{{$e->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a> &nbsp; &nbsp;
{{-- 						@if ($e->tacho->estado != 'Baja')
							<a href="" title="Dar de baja tacho" data-target="#modal-bajatacho-{{$e->idexportacion}}" data-toggle="modal">  <i class="fa fa-arrow-down fa-lg"></i></a>
						@endif --}}
					</td>
				</tr>
				@include('admin.exportaciones.envios.modal')
				@endforeach
			</table>
		</div>
		{{$envios->render()}}
	</div>
</div>
@endsection
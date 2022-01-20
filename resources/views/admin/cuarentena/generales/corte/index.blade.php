@extends('admin.layout')
@section('titulo', 'Tareas de corte')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Tareas de corte<a href="{{route('cuarentena.generales.corte.create')}}">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña</th>
					<th>Fecha</th>
					<th>Box</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($cortes as $l)
				<tr>
					<td>{{$l->nombre_campania}}</td>
					<td>{{$l->fecha}}</td>
					<td>
						@if ($l->idboximpo)
							Importacion - {{$l->boximpo}}	
						@else
							Exportacion - {{$l->boxexpo}}
						@endif
					</td>
					<td>{{$l->observaciones}}</td>
					<td>
						<a href="{{route('cuarentena.generales.corte.edit', $l->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						<a href="" data-target="#modal-delete-{{$l->id}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.cuarentena.generales.corte.modal')
				@endforeach
			</table>
		</div>
		{{$cortes->render()}}
	</div>
</div>
@endsection
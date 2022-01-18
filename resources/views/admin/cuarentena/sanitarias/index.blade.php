@extends('admin.layout')
@section('titulo', 'Evaluaciones Sanitarias Cuarentena')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Evaluaciones sanitarias Cuarentena <a href="{{route('cuarentena.sanitarias.create')}}">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña</th>
					<th>Fecha Generación</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($sanitarias as $s)
				<tr>
					<td>{{$s->campania->nombre}}</td>
					<td>{{$s->fecha}}</td>
					<td>{{$s->observaciones}}</td>
					<td>
					    <a href="" data-target="#modal-delete-{{$s->id}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{route('cuarentena.sanitarias.datosasociados',$s->id)}}"><i class="fa fa-table fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.cuarentena.sanitarias.modal')
				@endforeach
			</table>
		</div>
		{{$sanitarias->render()}}
	</div>
</div>
@endsection
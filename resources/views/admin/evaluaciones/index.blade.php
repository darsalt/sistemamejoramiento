@extends('admin.layout')
@section('titulo', 'Evaluaciones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Evaluaciones <a href="evaluaciones/create">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
		@include('admin.evaluaciones.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tacho</th>
					<th>Variedad</th>
					<th>Observaciones</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($evaluaciones as $t)
				<tr>
					<td>{{ $t->codigo}} - {{ $t->subcodigo}}</td>
					<td>{{ $t->nombrevariedad}}</td>
					<td>{{ $t->observaciones}}</td>
					<td>
					    <a href="{{URL::action('EvaluacionController@edit',$t->idtacho)}}"><i class="fa fa-plus fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('EvaluacionController@edit',$t->idevaluacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					</td>
				</tr>
				@include('admin.evaluaciones.modal')
				@endforeach
			</table>
		</div>
		{{$evaluaciones->render()}}
	</div>
</div>

@endsection
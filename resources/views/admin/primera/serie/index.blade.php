@extends('admin.layout')
@section('titulo', 'Series')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Series <a href="serie/create">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
		@include('admin.primera.serie.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Año Plantación</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($series as $c)
				<tr>
					<td>{{ $c->nombre}}</td>
					<td>{{ $c->anio}}</td>
					<td>{{ $c->fechainicio}}</td>
					<td>{{ $c->fechafin}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('SerieController@edit',$c->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$c->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.primera.serie.modal')
				@endforeach
			</table>
		</div>
		{{$series->render()}}
	</div>
</div>
@include('admin.primera.serie.view')
@endsection
@extends('admin.layout')
@section('titulo', 'Fertilizaciones de Tachos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Fertilizaciones realizadas<a href="fertilizaciones/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.tachos.fertilizaciones.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Fecha Fertilización</th>
					<th>Campaña</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($fertilizaciones as $f)
				<tr>
					<td>{{ $f->producto}}</td>
					<td>{{ $f->cantidad}}</td>
					<td>{{ $f->fechafertilizacion}}</td>
					<td>{{$f->nombre_campania}}</td>
					<td>{{ $f->observaciones}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('FertilizacionController@edit',$f->idfertilizacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						
					    <a href="" data-target="#modal-delete-{{$f->idfertilizacion}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.tachos.fertilizaciones.modal')
				@endforeach
			</table>
		</div>
		{{$fertilizaciones->render()}}
	</div>
</div>
@include('admin.tachos.fertilizaciones.view')
@endsection
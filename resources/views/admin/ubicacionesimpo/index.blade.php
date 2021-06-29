@extends('admin.layout')
@section('titulo', 'Ubicaciones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de boxes de importación <a href="ubicacionesimpo/create?area=impo">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.ubicacionesimpo.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Box</th>
					<th>Observaciones</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($ubicaciones as $b)
				<tr>
					<td>{{ $b->nombreubicacion}}</td>
					<td>{{ $b->observaciones}}</td>
					<td>

 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('UbicacionimpoController@edit',$b->idubicacion)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$b->idubicacion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{URL::action('UbicacionimpoController@tareasasociadas',$b->idubicacion)}}"><i class="fa fa-tasks fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('UbicacionimpoController@evaluacionesasociadas',$b->idubicacion)}}"><i class="fa fa-calculator fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('UbicacionimpoController@inspeccionesasociadas',$b->idubicacion)}}"><i class="fas fa-glasses fa-lg"></i></a>&nbsp;&nbsp;
						
					</td>
				</tr>







				@include('admin.ubicacionesimpo.modal')
				@endforeach
			</table>
		</div>
		{{$ubicaciones->render()}}
	</div>
</div>
@include('admin.ubicacionesimpo.view')
@endsection
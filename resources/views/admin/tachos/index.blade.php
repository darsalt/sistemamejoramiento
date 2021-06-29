@extends('admin.layout')
@section('titulo', 'Tachos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Tachos <a href="tachos/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.tachos.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tacho</th>
					<th>Subtacho</th>
					<th>Fecha Alta</th>
					<th>Variedad</th>
<!-- 					<th>Observaciones</th>
 -->					<th>Estado</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($tachos as $t)
				<tr>
					<td>{{ $t->codigo}}</td>
					<td>{{ $t->subcodigo}}</td>
					<td>{{ $t->fechaalta}}</td>
					<td>{{ $t->nombrevariedad}}</td>
<!-- 					<td>{{ $t->observaciones}}</td>
 -->					<td>{{ $t->estado}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('TachoController@edit',$t->idtacho)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$t->idtacho}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.tachos.modal')
				@endforeach
			</table>
		</div>
		{{$tachos->render()}}
	</div>
</div>
@include('admin.tachos.view')
@endsection
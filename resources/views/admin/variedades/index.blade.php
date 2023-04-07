@extends('admin.layout')
@section('titulo', 'Clones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Clones <a href="variedades/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.variedades.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Madre</th>
					<th>Padre</th>
					<th>Fecha Alta</th>
<!-- 					<th>Tacho</th>
 -->					<th>Estado</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($variedades as $t)
				<tr>
					<td>{{ $t->nombre}}</td>
					<td>{{ $t->madre}}</td>
					<td>{{ $t->padre}}</td>
					<td>{{ $t->fechaalta}}</td>
<!--					<td>{{ $t->idtacho}}</td>
 --> 					
 					@if($t->estado == 0)
					 <td>Inactivo</td>
					@else
					<td>Activo</td>
					 @endif 
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('VariedadController@edit',$t->idvariedad)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

					    <a href="" data-target="#modal-delete-{{$t->idvariedad}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.variedades.modal')
				@endforeach
			</table>
		</div>
		{{$variedades->render()}}
	</div>
</div>
@include('admin.variedades.view')
@endsection
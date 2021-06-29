@extends('admin.layout')
@section('titulo', 'Bancos de Germoplasma')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Bancos de Germoplasma <a href="bancos/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.bancos.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Año</th>
					<th>Fecha Generación</th>
					<th>Tablas</th>
					<th>Tablitas</th>
					<th>Surcos</th>
   					<th>Parcelas</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($bancos as $t)
				<tr>
					<td>{{ $t->nombre}}</td>
					<td>{{ $t->anio}}</td>
					<td>{{ $t->fechageneracion}}</td>
					<td>{{ $t->tablas}}</td>
					<td>{{ $t->tablitas}}</td>
					<td>{{ $t->surcos}}</td>
					<td>{{ $t->parcelas}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('BancoController@edit',$t->idbanco)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

					    <a href="" data-target="#modal-delete-{{$t->idbanco}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<!-- <a href="{{URL::action('BancoController@ubicacionesasociadas',$t->idbanco)}}"><i class="fa fa-table fa-lg"></i></a> -->
						<a href="{{url('ubicaciones',$t->idbanco)}}"><i class="fa fa-table fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.bancos.modal')
				@endforeach
			</table>
		</div>
		{{$bancos->render()}}
	</div>
</div>
@include('admin.bancos.view')
@endsection
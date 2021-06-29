@extends('admin.layout')
@section('titulo', 'Lotes')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Lotes <a href="lotes/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.lotes.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Lote</th>
					<th>Observaciones</th>
					<th>Operaciones</th>
				</thead>
               @foreach ($lotes as $l)
				<tr>
					<td>{{ $l->nombrelote}}</td>
					<td>{{ $l->observaciones}}</td>
					<td>

 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('LoteController@edit',$l->idlote)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$l->idlote}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('LoteController@tareasasociadas',$l->idlote)}}"><i class="fa fa-tasks fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('LoteController@evaluacionesasociadas',$l->idlote)}}"><i class="fa fa-calculator fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('LoteController@evaluacionesasociadas',$l->idlote)}}"><i class="fas fa-glasses fa-lg"></i></a>&nbsp;&nbsp;
						
					</td>
				</tr>
				@include('admin.lotes.modal')
				@endforeach
			</table>
		</div>
		{{$lotes->render()}}
	</div>
</div>
@include('admin.lotes.view')
@endsection
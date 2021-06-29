@extends('admin.layout')
@section('titulo', 'Cortes de Tachos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Cortes realizados<a href="cortes/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		@include('admin.tachos.cortes.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha Corte</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($cortes as $c)
				<tr>
					<td>{{ $c->fechacorte}}</td>
					<td>{{ $c->observaciones}}</td>
					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;

						<a href="{{URL::action('CorteController@edit',$c->idcorte)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;

					    <a href="" data-target="#modal-delete-{{$c->idcorte}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.tachos.cortes.modal')
				@endforeach
			</table>
		</div>
		{{$cortes->render()}}
	</div>
</div>
@include('admin.tachos.cortes.view')
@endsection
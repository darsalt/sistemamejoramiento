@extends('admin.layout')
@section('titulo', 'Fertilizaciones de Tachos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Fertilizacion cuarentena<a href="{{route('cuarentena.generales.fertilizacion.create')}}">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña</th>
					<th>Fecha</th>
                    <th>Box</th>
					<th>Producto</th>
					<th>Dosis</th>
					<th>Observaciones</th>
 					<th>Operaciones</th>
				</thead>
               @foreach ($fertilizaciones as $f)
				<tr>
					<td>{{$f->campania->nombre}}</td>
					<td>{{$f->fecha}}</td>
                    <td>
						@if ($f->idboximpo)
							Importacion - {{$f->boximpo->nombre}}	
						@else
							Exportacion - {{$f->boxexpo->nombre}}
						@endif
					</td>
					<td>{{$f->producto}}</td>
					<td>{{$f->dosis}}</td>
					<td>{{$f->observaciones}}</td>
					<td>
						<a href="{{route('cuarentena.generales.fertilizacion.edit', $f->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
						<a href="" data-target="#modal-delete-{{$f->id}}" data-toggle="modal"> <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.cuarentena.generales.fertilizacion.modal')
				@endforeach
			</table>
		</div>
		{{$fertilizaciones->render()}}
	</div>
</div>
@endsection
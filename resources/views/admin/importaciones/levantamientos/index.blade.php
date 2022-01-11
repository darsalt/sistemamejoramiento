@extends('admin.layout')
@section('titulo', 'Levantamiento cuarentena')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Levantamiento cuarentena <a href="{{route('importaciones.levantamientos.create')}}">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha levantamiento</th>
					<th>Campaña</th>
					<th>Box</th>
					<th>Observaciones</th>
					<th>Descarga archivo</th>
                    <th></th>
				</thead>
               @foreach ($levantamientos as $l)
				<tr>
					<td>{{$l->fechalevantamiento}}</td>
					<td>{{$l->campania->nombre}}</td>
					<td>{{$l->box->nombre}}</td>
					<td>{{$l->observaciones}}</td>
					<td>
                        @if (!is_null( $l->archivo))
                            <a target="_blank" href="{{asset('/levantamientos/'.$l->archivo)}}">{{ $l->archivo}}</a>
                        @endif
					</td>
                    <td>
                        <a href="" data-target="#modal-delete-{{$l->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
                    </td>
				</tr>
				@include('admin.importaciones.levantamientos.modal')
				@endforeach
			</table>
		</div>
		{{$levantamientos->render()}}
	</div>
</div>
@endsection
@extends('admin.layout')
@section('titulo', 'inspecciones')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Inspecciones <a href="{{route('importaciones.inspecciones.create')}}">&nbsp;<button class="btn btn-success">Nueva</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha inspeccion</th>
					<th>Campaña</th>
					<th>Box</th>
					<th>Observaciones</th>
					<th>Descarga certificado</th>
                    <th></th>
				</thead>
               @foreach ($inspecciones as $i)
				<tr>
					<td>{{$i->fechainspeccion}}</td>
					<td>{{$i->campania->nombre}}</td>
					<td>{{$i->box->nombre}}</td>
					<td>{{$i->observaciones}}</td>
					<td>
                        @if (!is_null( $i->certificado))
                            <a target="_blank" href="{{asset('/certificados/'.$i->certificado)}}">{{ $i->certificado}}</a>
                        @endif
					</td>
                    <td>
                        <a href="" data-target="#modal-delete-{{$i->idinspeccion}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
                    </td>
				</tr>
				@include('admin.inspecciones.modal')
				@endforeach
			</table>
		</div>
		{{$inspecciones->render()}}
	</div>
</div>
@endsection
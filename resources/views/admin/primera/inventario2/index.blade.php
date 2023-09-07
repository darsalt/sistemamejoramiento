@extends('admin.layout')
@section('titulo', 'Inventario')
@section('content')

@php
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>
			@if ($origen == 'pc')
				Inventario Primera Clonal
			@else
				@if ($origen == 'sc')
					Inventario Segunda Clonal
				@else
					Inventario MET
				@endif
			@endif
		</h3>
		    <div class="row">
		    </div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Año</th>
					@if ($origen != 'met')
						<th>Serie</th>
					@endif
					<th>Ambiente</th>
					<th>Subambiente</th>
					<th>Sector</th>
					<th>Cant. seedlings</th>
					<th></th>					
				</thead>
               @foreach ($inventarioFinal as $linea)
				<tr>
					<td>{{$linea->anio}}</td>
					@if ($origen != 'met')
						<td>{{$linea->nombre_serie}}</td>
					@endif
                    <td>{{$linea->nombre_ambiente}}</td>
					<td>{{$linea->nombre_subambiente}}</td>
					<td>{{$linea->nombre_sector}}</td>
                    <td>{{$linea->cant_seedlings}}</td>
                    <td>
						<a href="{{$origen == 'pc' ? route('primeraclonal.index', [$linea->idserie, $linea->idsector]) : ($origen == 'sc' ? route('segundaclonal.index', [$linea->idserie, $linea->idsector]) : 
						route('met.index', [$linea->anio, $linea->idsector]))}}"><i class="fas fa-search"></i></a>
					</td>
				</tr>
				@if (count($linea->evaluacionesCS) > 0 || count($linea->evaluacionesLab) > 0)
					<tr>
						<td colspan="{{$origen != 'met' ? "7" : "6"}}">
							<table class="table table-sm">
								<thead>
									<th>Mes</th>
									<th>Evaluacion</th>
									<th>Planta</th>
									<th>Soca 1</th>
									<th>Soca 2</th>
								</thead>
								<tbody>
									@foreach ($linea->evaluacionesCS as $evaluacion)
										<tr>
											<td>{{$meses[$evaluacion->mes]}}</td>
											<td>Campo-Sanidad</td>
											<td>{{$evaluacion->planta}}</td>
											<td>{{$evaluacion->soca1}}</td>
											<td>{{$evaluacion->soca2}}</td>
										</tr>
									@endforeach
									@foreach ($linea->evaluacionesLab as $evaluacion)
										<tr>
											<td>{{$meses[$evaluacion->mes]}}</td>
											<td>Laboratorio</td>
											<td>{{$evaluacion->planta}}</td>
											<td>{{$evaluacion->soca1}}</td>
											<td>{{$evaluacion->soca2}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</td>
					</tr>
				@endif
				@endforeach
			</table>
		</div>
	</div>
</div>

@endsection
@extends('admin.layout')
@section('titulo', 'Inventario')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Inventario</h3>
		    <div class="row">
		    </div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña</th>
					<th>Ambiente</th>
					<th>Subambiente</th>
					<th>Sector</th>
					<th>Cant. parcelas</th>
					<th>Cant. cruzas</th>
					<th>Cant. surcos</th>
					<th>Cant. seedlings</th>
					<th></th>					

				</thead>
               @foreach ($inventario as $linea)
				<tr>
					<td>{{$linea->nombre_campania}}</td>
                    <td>{{$linea->nombre_ambiente}}</td>
					<td>{{$linea->nombre_subambiente}}</td>
					<td>{{$linea->nombre_sector}}</td>
					<td>{{$linea->cant_parcelas}}</td>
                    <td>{{$linea->cant_cruzas}}</td>
                    <td>{{$linea->cant_surcos}}</td>
                    <td>{{$linea->cant_seedlings}}</td>
                    <td>
						<a href="{{route('individual.index', [$linea->idcampania, $linea->idsector])}}"><i class="fas fa-search"></i></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

@endsection
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
					<th>Cruza</th>
					<!-- <th>Fecha</th> -->
					<th>Cubículo</th>
					<th>Madre</th>
					<th>Padre</th>
					<th>Poder Germinativo</th>
					<th>Plantines Potenciales</th>
					<th>Stock Inicial</th>
					<th>Stock Actual</th>					

				</thead>
               @foreach ($semillas as $c)
				<tr>
					<td>{{ $c->campania}}</td>
					<td>{{ $c->cruza}}</td>
                    <!-- <td>{{ $c->fechacruzamiento}}</td> -->
					<td>{{ $c->cubiculo}}</td>
					<td>{{ $c->cm}}-{{ $c->sm}}-{{$c->vm}}</td>
					<td>{{ $c->cp}}-{{$c->sp}}-{{$c->vp}}</td>
                    <td>{{ $c->podergerminativo}}</td>
                    <td>{{ $c->plantines}}</td>
                    <td>{{ $c->gramos}}</td>
                    <td>{{ $c->stockactual}}</td>

					<td>
<!--  					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$c->idsemilla}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a> -->
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ingresos</h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Nombre</th>
					<th>Fecha ingreso</th>
					<th>Madre</th>
					<th>Padre</th>
					<th>Poder Germinativo</th>
					<th>Procedencia</th>
					<th>Stock Inicial</th>
					<th>Stock Actual</th>					

				</thead>
				<tbody>
					@foreach ($semillasIngresos as $c)
						<tr>
							<td>{{ $c->nombre}}</td>
							<td>{{ $c->fechaingreso}}</td>
							<td>{{ $c->madre}}</td>
							<td>{{ $c->padre}}</td>
							<td>{{ $c->podergerminativo}}</td>
							<td>{{ $c->procedencia}}</td>
							<td>{{ $c->stockinicial}}</td>
							<td>{{ $c->stockactual}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
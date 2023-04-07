@extends('admin.layout')
@section('titulo', 'Inventario Semillados')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Inventario Semillados</h3>
		    <div class="row">
		    </div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña Semillado</th>
					<th>Ordenes</th>
					<th>Gramos</th>
					<th>Plantas</th>
					<th>Poder Germinativo</th>
					<th>Cajones</th>
					<th>Repicadas</th>
				</thead>
				@foreach ($inventario as $i)
				<tr>
					<td>{{ $i->nombre}}</td>
					<td>{{ $i->cantidad}}</td>
					<td>{{ $i->gramos}}</td>
					<td>{{ $i->plantas}}</td>
					<td>{{ $i->poder}}</td>
					<td>{{ $i->cajones}}</td>
					<td>{{ $i->repicadas}}</td>



				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

@endsection
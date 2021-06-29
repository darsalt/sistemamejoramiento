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
					<th>Fecha</th>
					<th>Cubículo</th>
					<th>Madre</th>
					<th>Padre</th>
					<th>Poder Germinativo</th>
					<th>Plantines Potenciales</th>
					<th>Stock Inicial</th>
					<th>Stock Actual</th>					

				</thead>
               @foreach ($cruzamientos as $c)
				<tr>
					<td>{{ $c->campania}}</td>
                    <td>{{ $c->fechacruzamiento}}</td>
					<td>{{ $c->cubiculo}}</td>
					<td>{{ $c->cm}}-{{ $c->sm}}-{{$c->vm}}</td>
					<td>{{ $c->cp}}-{{$c->sp}}-{{$c->vp}}</td>
                    <td>{{ $c->poder}}</td>
                    <td>{{ $c->plantines}}</td>
                    <td>{{ $c->gramos}}</td>
                    <td>{{ $c->stock}}</td>

					<td>
<!--  					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$c->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a> -->
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

@endsection
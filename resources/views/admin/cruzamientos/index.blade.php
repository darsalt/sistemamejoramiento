@extends('admin.layout')
@section('titulo', 'Cruzamientos')
@section('content')


<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Cruzamientos <a href="cruzamientos/create">&nbsp;<button class="btn btn-success">Nuevo</button></a></h3>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="form-group">
                <label for="campania">Campaña:</label>
                <select class="form-control" id="campania" name="campania">
				@foreach ($campanias as $camp)
					<option value='{{$camp->nombre}}'>{{$camp->nombre}}</option>
				@endforeach	
                </select>
            </div>
        </div>
		@include('admin.cruzamientos.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tipo Cruzamiento</th>
					<th>Cubículo</th>
					<th>Nro. de cruzamientos</th>
					<th>Padre</th>
					<th>Madre</th>
					<th>Fecha Cruzamiento</th>
				</thead>
               @foreach ($cruzamientos as $c)
				<tr>
					<td>{{ $c->tipocruzamiento}}</td>
					<td>{{ $c->cubiculo}}</td>
					<td>{{ $c->cruza}}</td>
					<?php if ($c->codigo != 0) {
						$padre = $c->codigo . $c->subcodigo . ' - ' . $c->nombre;
					} else {
						$padre = 'poli';
					}
					?>
					<td>{{$padre}}</td>
					<?php $tachomadre=DB::table('tachos')
							->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
							->select('codigo','subcodigo','tachos.idvariedad','variedades.nombre')
            				->where('tachos.idtacho',$c->idmadre)
							->first();
						  if ($tachomadre) {
							if ($c->idmadre == $c->idtacho) {
								$madre = 'auto';
							} else {
								$madre = $tachomadre->codigo . $tachomadre->subcodigo . ' - ' . $tachomadre->nombre;
							}
						  } else {
							$madre ='auto';
							
						  }	
					?>			
					<td>{{ $madre }}</td>		
                    <td>{{ $c->fechacruzamiento}}</td>
					<td>
 					    <a href="{{URL::action('CruzamientoController@show', $c->id)}}" data-target="#view"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
						<a href="{{URL::action('CruzamientoController@edit',$c->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
					    <a href="" data-target="#modal-delete-{{$c->id}}" data-toggle="modal">  <i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				@include('admin.cruzamientos.modal')
				@endforeach
			</table>
		</div>
		{{$cruzamientos->render()}}
	</div>
</div>

@endsection
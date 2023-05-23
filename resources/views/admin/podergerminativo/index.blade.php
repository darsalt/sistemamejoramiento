@extends('admin.layout')
@section('titulo', 'Poder Germinativo')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Poder Germinativo de los Cruzamientos {{$idCampania}}
			<a href="{{URL::action('CruzamientoController@podergerminativo',$idCampania)}}">&nbsp;<button class="btn btn-success">Carga</button></a></h3>
		<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<form action="{{url('/admin/podergerminativo')}}" method='GET'>
				<div class="form-group">
					<label for="campania">Campaña:</label>
					<select class="form-control" id="campania" name="campania" onchange="this.form.submit()">
						@foreach ($campanias as $c)
							<option value="{{$c->id}}" {{$c->id == $idCampania ? 'selected' : ''}}>{{$c->nombre}}</option>
						@endforeach	
					</select>
				</div>
			</form>
        </div>
    </div>@include('admin.cruzamientos.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Cruza</th>
					<th>Cubículo</th>
					<th>Padre</th>
					<th>Madre</th>
					<th>Fecha Cruzamiento</th>
					<th>Gramos</th>
					<th>Conteo</th>
					<th>Poder Germinativo</th>
					<th>Plantines Potenciales</th>

				</thead>
               @foreach ($cruzamientos as $c)
				<tr>
					<td>{{ $c->cruza}}</td>
					<td>{{ $c->cubiculo}}</td>
					<td>{{ $c->cp}}-{{$c->sp}}-{{$c->vp}}</td>
					<td>{{ $c->cm}}-{{ $c->sm}}-{{$c->vm}}</td>
                    <td>{{ $c->fechacruzamiento}}</td>
                    <td>{{ $c->gramos}}</td>
                    <td>{{ $c->conteo}}</td>
                    <td>{{ $c->poder}}</td>
                    <td>{{ $c->plantines}}</td>

					<td>
 					    <a href="" data-target="#view" data-toggle="modal"> 
					   	<i class="fa fa-search fa-lg"></i></a>&nbsp;&nbsp;
<!-- 						<a href="{{URL::action('CruzamientoController@edit',$c->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp; -->
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
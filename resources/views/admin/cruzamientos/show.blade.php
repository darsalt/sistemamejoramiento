@extends('admin.layout')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Tallos </a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Tacho</th>
					<th>Número</th>
                    <th>Fecha Floración</th>
                    <th>Pólen</th>
                    <th>Enmasculado</th>
				</thead>
               @foreach ($tallos as $t)
				<tr>
					<td>{{ $t->codp}} {{ $t->subcodp}}</td>
					<td>{{ $t->tpn}} {{ $t->tmn}}</td>
                    <td>{{ $t->tpf}} {{ $t->tmf}}</td>
                    <td>{{ $t->tpp}} {{ $t->tmp}}</td>
                    <td>{{ $t->tpe}} {{ $t->tme}}</td>
				</tr>
				
				@endforeach
			</table>
		</div>

	</div>
</div>

<div class="col-sm-3 col-md-3 pull-rigth">
       
        <div class="sidebar-module text">
            <a href="" onclick="history.go(-1); return false;">Lista de cruzamientos</a>
        </div>
    </div>    

@endsection
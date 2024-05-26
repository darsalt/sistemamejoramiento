@extends('admin.layout')
@section('titulo', 'Marcotado')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Marcotado</h3>

	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		@include('admin.marcotado.search')
	</div>
</div>


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">


    <table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<tr><th>Camara</th>
					<th> Zorra  </th>
          <th>Ubicacion</th>
          <th>Tacho</th>
          <th>Clon</th>
          <th>Tallos iniciales</th>
          <th>tallo 1</th>
          <th>tallo 2</th>
          <th>tallo 3</th>
          <th>tallo 4</th>
          <th>tallo 5</th>

        </tr></thead>
        <tbody>
          @foreach($ubicaciones as $ubicacion )
          <tr>
					<td>{{ $ubicacion->nombrecamara }}</td>
					<td>{{ $ubicacion->zorranombre }}</td>
					<td>{{ $ubicacion->nombre }}</td>
          <td>{{ $ubicacion->tacho }}</td>
          <td>{{ $ubicacion->variedad }}</td>
          <td>
          <form action="{{ url('admin/marcotado') }}" method="post" enctype="multipart/form-data">
            @csrf
              <input type="text" value="{{$ubicacion->idtacho}}" name="idtacho" id="idtacho" hidden>
              <input type="number" name="cantidadTallos" id="cantidadTallos" max="10" min="0" @if($ubicacion->cantidadtallos === NULL) value="0" @else value="{{ $ubicacion->cantidadtallos }}" @endif
              onchange="guardarCantidadTallos({{ $ubicacion->idtacho }}, this.value)">                         
            <!-- 
          <input name='cantidad' type="number" class="form-control" value="0" style="text-align: center;" 
          onchange="habilitarDate(this.value,{{$ubicacion->idtacho}});" min="0" max="10">
          -->
          </td>
          
          
          @foreach($posiciones as $posicion)
            <td>
            {{$tallo=NULL}}
            @foreach($tallos as $tallo)
                    @if($tallo->idtacho === $ubicacion->idtacho)
                      @if($tallo->numero === $posicion)
                        @break
                      @endif                        
                    @endif
            @endforeach
            <input type="text" name="idtacho" value="{{ $ubicacion->idtacho }}" hidden>
            @if($tallo !== NULL)
                @if($tallo->idtacho === $ubicacion->idtacho)
                  @if($tallo->numero === $posicion)
                  <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                      value="{{ $tallo->fechafloracion }}" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}},{{$idcampania}});">
                  @else
                  <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}},{{$idcampania}});">
                  @endif                        
                @else
                  <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}},{{$idcampania}});">
                @endif
            @else
            <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}},{{$idcampania}});">
            @endif
            </td>    
          @endforeach
          
          </form>
          </tr>
          @endforeach
        
				</tbody>
    </table>
			
		
		</div>
		
	</div>





</div>

@endsection

@section('script')
<script type="text/javascript">
function guardarFecha(fecha,idtacho,posicion,campania){
      var id_tacho = idtacho;
      var posicion = posicion;
      var fecha = fecha;
      var campania = campania;

      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo route('guardar-fecha') ?>",
          method: 'POST',
          data: {id_tacho:id_tacho, _token:token, posicion:posicion, fecha:fecha, campania:campania},
          success: function(data) {
            //console.log(data);
          },
          error: function(data){
          }
      });
  }

  function guardarCantidadTallos(idtacho,cantidad){
      var id_tacho = idtacho;
      var cantidad = cantidad;
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo route('guardar-cantidad-tallo') ?>",
          method: 'POST',
          data: {id_tacho:id_tacho, _token:token, cantidad:cantidad},
          success: function(data) {

          }
      });
  }
</script>
@endsection

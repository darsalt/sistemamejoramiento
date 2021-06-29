@extends('admin.layout')
@section('titulo', 'Marcotado')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Marcotado</h3>
    <div class="form-group" style="text-align:center;">
      <label for="campaña">Campaña</label>
      <form action="{{url('admin/marcotado/campania')}}" method="GET">
        <select name="campanias" id="campanias" class="select2" style="width: 100%; " class="form-control" required onchange="this.form.submit()">
          
          <option value="{{ $idcampania }}">{{ $nombrecampania }}</option>
          
        @foreach($campanias as $c)
            @if($c->id != $idcampania)      
                <option value="{{ $c->id }}" >{{ $c->nombre }}</option>
            @endif
        @endforeach
       </select>
       
       </form>
      </div>
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
          <th>Variedad</th>
          <th>Tallos iniciales</th>
          <th>tallo 1</th>
          <th>tallo 2</th>
          <th>tallo 3</th>
          <th>tallo 4</th>
          <th>tallo 5</th>
          <th>tallo 6</th>
          <th>tallo 7</th>
          <th>tallo 8</th>
          <th>tallo 9</th>
          <th>tallo 10</th>
        </tr></thead>
        <tbody>
          @foreach($ubicaciones as $ubicacion )
          <tr>
					<td>{{ $ubicacion->nombrecamara }}</td>
					<td>{{ $ubicacion->zorranombre }}</td>
					<td>{{ $ubicacion->nombre }}</td>
          <td>{{ $ubicacion->codigo }}-{{ $ubicacion->subcodigo }}</td>
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
                      value="{{ $tallo->fechafloracion }}" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}});">
                  @else
                  <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}});">
                  @endif                        
                @else
                  <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}});">
                @endif
            @else
            <input class="form-control" name="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" id="tacho{{$ubicacion->idtacho}}fechageneracion{{$posicion}}" type="date" 
                    value="" onchange="guardarFecha(this.value,'{{ $ubicacion->idtacho }}',{{$posicion}});">
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
function guardarFecha(fecha,idtacho,posicion){
      var id_tacho = idtacho;
      var posicion = posicion;
      var fecha = fecha;
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo route('guardar-fecha') ?>",
          method: 'POST',
          data: {id_tacho:id_tacho, _token:token, posicion:posicion, fecha:fecha},
          success: function(data) {
            console.log(data);
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

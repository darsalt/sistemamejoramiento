@extends('admin.layout')
@section('titulo', 'Cámaras')
@section('content')


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Cámaras</h3>
    <div class="form-group" style="text-align:center;">
      <label for="campaña">Campaña</label>
      <form action="{{url('admin/camaras/campania')}}" method="GET">
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

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


		<div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <!-- Creacion de camaras -->
                @foreach($camaras as $camara)
                  <li class="nav-item">
                    @if($camara->id == $idcamara)
                    <a class="nav-link active" id="camara-{{$camara->id}}-tab"  href="{{url('admin/camaras/'.$camara->id.'/'.$idcampania)}}" role="tab"  aria-selected="true">{{ $camara->nombre }} </a>
                    @else
                    <a class="nav-link" id="camara-{{$camara->id}}-tab"  href="{{url('admin/camaras/'.$camara->id.'/'.$idcampania)}}" role="tab"  aria-selected="false">{{ $camara->nombre }}</a>
                    @endif
                  </li>
                @endforeach
                  <!-- Fin de camaras -->
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  @foreach($camaras as $camara)
                  @if($camara->id == $idcamara )
                  <div class="tab-pane fade active show" id="camara-{{$camara->id}}" role="tabpanel" aria-labelledby="camara-{{$camara->id}}-tab">
                    <div>
                     <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label for="tratamiento{{$camara->id}}">Tratamiento</label>
                                  <select name="tratamiento{{$camara->id}}" id="tratamiento{{$camara->id}}" class="select2 form-control" style="width: 100%;" required 
                                  onchange="guardarTratamiento(this.value,{{$camara->id}},{{ $idcampania }});">
                                    @foreach($cctu as $cmr)
                                        @if($cmr->idcamara === $camara->id)
                                          <option value="{{ $cmr->idtratamiento }}"> {{ $cmr->tratamiento }}</option>
                                        @endif
                                    @endforeach
                                    <option value="0">Ninguna</option>
                                    @foreach($tratamientos as $tratamiento)
                                      <option value="{{ $tratamiento->idtratamiento }}">
                                        {{ $tratamiento->nombre }}     

                                      </option>
                                    @endforeach
                                  </select>
                              </div>
                          </div>

                      </div>
                      @if($camara->id === 6)
                     <!-- Van la tabla de tachos -->
                     <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th>Tacho</th>
                                  <th>Subtacho</th>
                                  <th>Variedad</th>
                                  <th>Fecha Alta</th>
                                  <th>Estado</th>
                               </thead>
                                      @foreach ($tachos as $t)
                                <tr>
                                  <td>{{ $t->codigo}}</td>
                                  <td>{{ $t->subcodigo}}</td>
                                  <td>{{ $t->variedad}}</td>
                                  <td>{{ $t->fechaalta}}</td>
                                  <td>{{ $t->estado}}</td>
                                </tr>
                                @include('admin.tachos.modal')
                                @endforeach
                              </table>
                            </div>
                            
                          </div>
                        </div>
                     @else
                        @include('admin.zorras.index')
                     @endif
                      </div>
                  </div>
                  
                  @endif
                  @endforeach
                </div>
              </div>

	</div>
</div>
</div>
</div>
</div>
@include('admin.tratamientos.view')
@endsection
@section('script')
<script type="text/javascript">
  function guardarTratamiento(idtratamiento,idcamara,idcampania){
    var idcamara = idcamara;
    var idtratamiento = idtratamiento;
    var idcampania = idcampania;
    var token = $("input[name='_token']").val();
    $.ajax({
          url: "<?php echo route('select-tratamiento') ?>",
          method: 'POST',
          data: {idtratamiento:idtratamiento, _token:token, idcamara:idcamara, idcampania:idcampania},
          success: function(data) {
            console.log(data);
          }
      });
  }

  function guardarTacho(idtacho,ubicacion,idzorra,idcamara,idcampania){
      var idtacho = idtacho;
      var idcamara = idcamara;
      var idcampania = idcampania;
      var ubicacion = ubicacion;
      var idzorra = idzorra;
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "<?php echo route('select-tacho') ?>",
          method: 'POST',
          data: {_token:token, idtacho:idtacho, ubicacion:ubicacion, idcamara:idcamara , idcampania:idcampania, idzorra:idzorra},
          success: function(tachos) {
            var selectOrigen = document.getElementById('camara'+idcamara+'zorra'+idzorra+''+ubicacion);
            
            var indexSelect = selectOrigen.options.selectedIndex;
            var valueSelect = selectOrigen.options[indexSelect].innerText;
            
                                   
            
            var zorra = ((idcamara * 4) + 1) - 4 ;
              if(idcamara == 5){
                var finZorra = (idcamara * 4) + 2;
              }else{
                var finZorra = (idcamara * 4);
              }
              console.log('Inicio de la zorra : ' + zorra);
              console.log('Fin de la zorra : ' + finZorra);
              //zorras
              while(zorra <= finZorra){

                for(var l = 1 ; l <= 24 ; l ++){
                    var select = document.getElementById('camara'+idcamara+'zorra'+zorra+''+l);
                    if(selectOrigen !== select){
                        if(select.options[0].value != 0){
                          select.remove(indexSelect+1);
                        }else{
                          select.remove(indexSelect);
                        }
                    }
                    
                  }
                console.log('Actualizacion de la zorra : ' + zorra);
                zorra = zorra + 1; 
              }

              
              var select = document.getElementById('camara'+idcamara+'zorra'+idzorra+''+ubicacion);
                    for (var i = select.options.length - 1 ; i >= 0 ; i--){
                        select.remove(i);
                      }
              $('#camara'+idcamara+'zorra'+idzorra+''+ubicacion).append($('<option>',{value:idtacho, text:valueSelect}));
              $('#camara'+idcamara+'zorra'+idzorra+''+ubicacion).append($('<option>',{value:0, text:'Ninguna'}));

              $.each(tachos, function(k, v) {
                      v.forEach(element => 
                          $('#camara'+idcamara+'zorra'+idzorra+''+ubicacion).append($('<option>', 
                          {value:element['idtacho'], text:element['codigo'] + ' - ' + element['subcodigo'] + ' - ' + element['variedad']}
                          ))
                      );
                    });

             
          }
      });
  }
</script>
@endsection


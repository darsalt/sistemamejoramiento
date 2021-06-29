@extends('admin.layout')
@section('titulo', 'Registrar Exportación')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva variedad a cuarentena para exportación</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
    </div>

		{!!Form::open(array('url'=>'admin/exportaciones','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="variedad">Variedad</label>
                    <select name="idvariedad" id="idvariedad" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="">Seleccione una Variedad</option>
                        @foreach ($variedades as $variedad)
                            <option value="{{$variedad->idvariedad}}">
                                {{$variedad->nombre }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="tacho">Tacho</label>
                    <select name="idtacho" id="idtacho" class="select2" style="width: 100%;"  class="form-control" required>
                        <option value="">Seleccione un Tacho</option>
                        @foreach ($tachos as $tacho)
                            <option value="{{$tacho->idtacho}}">
                                {{$tacho->codigo}} - {{$tacho->subcodigo}}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Ubicación</label>
                  <select name="idubicacion" id="idubicacion" class="form-control select" style="width: 100%;" required>
                    <option value="">Seleccione una Ubicación</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->idubicacion}}">
                                {{$ubicacion->nombreubicacion}}
                            </option>
                        @endforeach
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Ingreso a Cuarentena</label><br>
                <input class="form-control" name="fechaingreso" id="fechaingreso" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Egreso a Cuarentena</label><br>
                <input class="form-control" name="fechaegreso" id="fechaegreso" type="date" >
            </div>
        </div>
<!--         <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Estado</label>
                  <select class="form-control select2" style="width: 100%;" required>
                    <option value="">Seleccione un Estado</option>
                    <option>Activa</option>
                    <option>otro</option>
                    <option>estado</option>
                    <option>posible</option>
                  </select>
            </div>
        </div> -->
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" class="form-control" placeholder="Ingrese observaciones"></textarea>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<button class="btn btn-primary" type="submit">Guardar</button>
               	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
        </div>
    </div>
	{!!Form::close()!!}
</div>
</section>

@endsection
@section('script')
<script>  
    
$(document).ready(function() {
  
  $('#idvariedad').on('change', function() {
             var idvariedad = $(this).val();
             var ruta='{{asset('BuscarTachosConIdvariedad')}}/'+idvariedad;
             if(idvariedad) {
                 $.ajax({
                     url: ruta,
                     type: "GET",
                     data : {"_token":"{{ csrf_token() }}"},
                     dataType: "json",
                     success:function(data) {
                        console.log(data);
                         var sel = $("#idtacho");
                         sel.empty();
                         for (var i=0; i<data.length; i++) {
                           sel.append('<option value="' + data[i].idtacho + '">' + data[i].codigo + ' - ' + data[i].subcodigo + '</option>');
                         }
                   }
                 });

             }else{
               $('#idtacho').empty();
             }
   });  

   // $('#idtacho').on('change', function() {
   //           var idtacho = $(this).val();
   //           var ruta='{{asset('BuscarVariedadConIdTacho')}}/'+idtacho;
   //           if(idtacho) {
   //               $.ajax({
   //                   url: ruta,
   //                   type: "GET",
   //                   data : {"_token":"{{ csrf_token() }}"},
   //                   dataType: "json",
   //                   success:function(data) {
   //                      console.log(data);
   //                       var sel = $("#idvariedad");
   //                       sel.empty();
   //                       for (var i=0; i<data.length; i++) {
   //                         sel.append('<option value="' + data[i].idvariedad + '">' + data[i].nombre +'</option>');
   //                       }
   //                 }
   //               });

   //           }else{
   //             $('#idtacho').empty();
   //           }
   // });    

});

//$(document).ready(function() {

             // var idvariedad = $(this).val();
             // var ruta='{{asset('o/buscarProyectosConIdArea')}}/'+iddestino;
             // if(iddestino) {
             //     $.ajax({
             //         url: ruta,
             //         type: "GET",
             //         data : {"_token":"{{ csrf_token() }}"},
             //         dataType: "json",
             //         success:function(data) {
             //            console.log(data);
             //             var sel = $("#idproyecto");
             //             sel.empty();
             //             for (var i=0; i<data.length; i++) {
             //               sel.append('<option value="' + data[i].idproyecto + '">' + data[i].nombreproyecto + '</option>');
             //             }
             //       }
             //     });

             // }else{
             //   $('#proyecto').empty();
             // }
//}
</script>
@endsection
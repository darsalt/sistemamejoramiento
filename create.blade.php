@extends('layout')
@section('titulo', 'Registrar Inspección')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Nueva Inspección</h3>
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
    <div class = "contenedor" > 
    <div class = "fila" > 
    <div class = "col-md-12" >
       {!!Form::open(array('url'=>'inspecciones','method'=>'POST','files'=>'true','enctype' => 'multipart/form-data', 'id' => 'dropzone' , 'class' => 'dropzone', 'autocomplete'=>'off'))!!}
        {{Form::token()}}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                  <label for="idtipoinspeccion">Tipo de Inspección</label>
                    <select name="idtipoinspeccion" id="idtipoinspeccion" class="select2" style="width: 100%;"  class="form-control" required>
                        <option value="">Seleccione un Tipo de Inspección</option>
                        @foreach ($tiposinspeccion as $tiposinspeccion)
                            <option value="{{$tiposinspeccion->idtipoinspeccion}}">
                                {{$tiposinspeccion->idtipoinspeccion}} - {{$tiposinspeccion->nombretipoinspeccion}}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                  <label for="idobjetoinspeccion">Objeto de Inspección</label>
                    <select name="idobjetoinspeccion" id="idobjetoinspeccion" class="select2" style="width: 100%;"  class="form-control" required>
                        <option value="">Seleccione un Objeto de Inspección</option>

                    </select>
            </div>
        </div>
    </div>
        <div id="divizaje">
         
        </div>
        <div id="divepi">

        </div>
        <div id="divavanti">

        </div>
        <div id="divform">

        </div>
    <br>
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

@endsection

@section('script')
    <script>
        $(document).ready(function() {
          Dropzone.options.dropzoneForm = {

    autoProcessQueue : false,
    acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",

    init:function(){
      var submitButton = document.querySelector("#submit-all");
      myDropzone = this;

      submitButton.addEventListener('click', function(){

        myDropzone.processQueue();
      });

      this.on("complete", function(){
        if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
        {
          var _this = this;
          _this.removeAllFiles();
        }
        load_images();
      });

    }

  };

  load_images();

  function load_images()
  {
    var idinspeccion = $("#idinspeccion").val();

    var ruta='{{asset('dropzone/fetch')}}/'+idinspeccion;
    $.ajax({
      url:ruta,
      success:function(data)
      {
        $('#uploaded_image').html(data);
      }
    })
  }

  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    var idinspeccion = $("#idinspeccion").val();
    var ruta='{{asset('dropzone/delete')}}/'+idinspeccion;
    $.ajax({
      url:ruta,
      data:{name : name},
      success:function(data){
        load_images();
          }
    })
  });
  
  $('#idtipoinspeccion').on('change', function() {

    var idtipoinspeccion = $(this).val();
    var ruta='{{asset('BuscarObjetosConIdTipo')}}/'+idtipoinspeccion;

    if(idtipoinspeccion) {
      $.ajax({
        url: ruta,
        type: "GET",
        data : {"_token":"{{ csrf_token() }}"},
        dataType: "json",
        success:function(data) {
          var sel = $("#idobjetoinspeccion");
          sel.empty();
          sel.append('<option value="">Seleccione un Objeto de Inspección</option>');
          for (var i=0; i<data.length; i++) {
            sel.append('<option value="' + data[i].idobjetoinspeccion + '"> ' + data[i].nombreobjetoinspeccion + '</option>');
          }
        }
      });
    }else{
          $('#idobjetoinspeccion').empty();
    }

    var idtipoinspeccion = $(this).val();
    if(idtipoinspeccion==0){
      $("#divizaje").css("display", "none");
      $("#divepi").css("display", "none");
      $("#divavanti").css("display", "none");
    }
    if(idtipoinspeccion==1){
      $("#divizaje").css("display", "block");
      $("#divepi").css("display", "none");
      $("#divavanti").css("display", "none");
    }
    if(idtipoinspeccion==2){
      $("#divizaje").css("display", "none");
      $("#divepi").css("display", "block");
      $("#divavanti").css("display", "none");
    }
    if(idtipoinspeccion==3){
      $("#divizaje").css("display", "none");
      $("#divepi").css("display", "none");
      $("#divavanti").css("display", "block");
    }

  }).change();; 

  $('#idobjetoinspeccion').on('change', function() {
    var idobjeto = $(this).val();
    var ruta='{{asset('ArmarFormConIdTipo')}}/'+idobjeto;
    var div1="";
    var div2="";
    var div3="";
    var div4="";
    var div5="";
    var div6="";
    var div7="";
    $.ajax({
      url: ruta,
      type: "GET",
      data : {"_token":"{{ csrf_token() }}"},
      dataType: "json",
      success:function(data) {
      var idtipo = data[0][0].idtipoinspeccion;
      if(idtipo==1){ 
            div1 = div1 + '<div class="row">';
            div1  = div1 + '<div class="col-2 contenedor"><div class="contenido"><img src="{{ asset("adminlte/img/logo.png") }}"></div></div>';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><b> FORMULARIO PARA LA INSPECCIÓN DE '+data[0][0].nombretipoinspeccion+' - '+ data[0][0].nombre +'  </b></div></div>';
            div1 = div1 + '<div class="col-2 contenedor"><div class="contenido">'+data[0][0].codigo+'<br>Versión 00<!-- <br>Página 1 de 2 --></div></div>';
            div1 = div1 + '</div>';
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-12 contenedor"><div class="contenido"><b><p>CHECK LIST DE '+ data[0][0].nombre +'</p></b></div></div></div>';
      }
      if(idtipo==2){ 
            div1 = div1 + '<div class="row">';
            div1  = div1 + '<div class="col-2 contenedor"><div class="contenido"><img src="{{ asset("adminlte/img/logo.png") }}"></div></div>';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><b> FICHA DE REVISIÓN   <br><br> SISTEMA DE GESTIÓN </b></div></div>';
            div1 = div1 + '<div class="col-2 contenedor"><div class="contenido">'+data[0][0].codigo+'<br>Versión 00<!-- <br>Página 1 de 2 --></div></div>';
            div1 = div1 + '</div>';
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-12" style="border: 1px solid #000000;"><div class="form-group"><ul><li>Además de las revisiones habituales después de cada utilización, regularmente, un EPI debe ser objeto de una revisión en profundidad, realizada por una persona competente. GSE recomienda una revisión cada 12 meses y después de cualquier circunstancia excepcional en la vida útil del producto.</li><li>La revisión de un EPI se debe realizar con la ficha técnica proporcionada por el fabricante.</li><ul></div></div>';
            div1 = div1 + '<div class="col-12 contenedor"><div class="contenido"><b><p>'+ data[0][0].nombre +'</p></b></div></div>';
           div1 = div1 + '</div>';
      }
      if(idtipo==3){ 
            div1 = div1 + '<div class="row">';
            div1  = div1 + '<div class="col-2 contenedor"><div class="contenido"><img src="{{ asset("adminlte/img/logo.png") }}"></div></div>';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><b> CHECK LIST DE INSPECCIÓN DE '+ data[0][0].nombre +' AVANTI  <br><br> SISTEMA DE GESTIÓN </b></div></div>';
            div1 = div1 + '<div class="col-2 contenedor"><div class="contenido">'+data[0][0].codigo+'<br>Versión 00<!-- <br>Página 1 de 2 --></div></div>';
            div1 = div1 + '</div>';
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-12 contenedor"><div class="contenido"><b><p></p></b></div></div></div>';
      }

      for (var i=0; i<data[1].length; i++) {//ENCABEZADO
        switch(data[1][i].idtipoconsigna) {
          case 1:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><input type="text" class="form-control" name="' + data[1][i].idconsigna + '"></div></div>';
            div1 = div1 + '</div>';
          break;
          case 2:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-10 contenedor"><div class="contenido"><p>'+data[1][i].texto+'</p></div></div>';
            div1 = div1 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="si' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value=1><label for="si' + data[1][i].idconsigna + '" class="custom-control-label">SI</label></div></div>';
            div1 = div1 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="no' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value=0><label for="no' + data[1][i].idconsigna + '" class="custom-control-label">NO</label></div></div>';
            div1 = div1 + '</div>';
          break;
          case 3:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-1 contenedor"><div class="contenido"><p> ' + parseInt(i+1) + ' </p></div></div>';
            div1 = div1 + '<div class="col-5 contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
            div1 = div1 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="si' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value=1><label for="si' + data[1][i].idconsigna + '" class="custom-control-label"></label></div></div>';
            div1 = div1 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="no' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value=0><label for="no' + data[1][i].idconsigna + '" class="custom-control-label"></label></div></div>';
            div1 = div1 + '<div class="col-4 contenedor"><div class="contenido"><textarea class="form-control" rows="2" name="obs' + data[1][i].idconsigna + '"></textarea></div>';  
            div1 = div1 + '</div>';
          break;
          case 4:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-7 contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
            div1 = div1 + '<div class="col-1 contenedor" align="center"><input type="radio" id="1' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value="1"></div>';
            div1 = div1 + '<div class="col-1 contenedor" align="center"><input type="radio" id="2' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value="2"></div>';
            div1 = div1 + '<div class="col-1 contenedor" align="center"><input type="radio" id="3' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value="3"></div>';
            div1 = div1 + '<div class="col-1 contenedor" align="center"><input type="radio" id="4' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '" value="4"></div>';
            div1 = div1 + '<div class="col-1 contenedor" align="center"><input type="radio" id="5' + data[1][i].idconsigna + '" ame="' + data[1][i].idconsigna + '" value="5"></div>';
            div1 = div1 + '</div>';
          break;
          case 5:
            div1 = div1 + '<div class="row"><div class="col-5 contenedor"><div class="contenido">' + data[1][i].texto + '</div></div><div class="col-2 contenedor"><div class="contenido"> <b><p><div class="icheck-primary d-inline"><input type="checkbox" id="' + data[1][i].idconsigna + '" name="' + data[1][i].idconsigna + '"></div></p></b></div></div><div class="col-5 contenedor"><textarea rows="3" cols="60" name="' + data[1][i].idconsigna + '" ></textarea></div></div>';  
              break;
          case 6:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
            div1 = div1 + '<div class="col contenedor"><div class="contenido"><input type="date" class="form-control" name="fecha' + data[2][i].idconsigna + '" id="fecha' + data[1][i].idconsigna + '" required="required"></div></div>';
            div1 = div1 + '</div>';
          break;

          case 7:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-12 contenedor"><div class="contenido"><b><p>' + data[1][i].texto + '</p></b></div></div>';
            div1 = div1 + '</div>';
          break;
          case 8:
            div1 = div1 + '<div class="row">';
            div1 = div1 + '<div class="col-7 contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
            div1 = div1 + '<div class="col-5 contenedor"><div class="contenido"><textarea rows="4" cols="50" name="' + data[1][i].idconsigna + '" ></textarea></div></div>';
            div1 = div1 + '</div>';
          break;
          case 9:
              div1 = div1 + '<div class="row">';
              div1 = div1 + '<div class="col contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
              div1 = div1 + '<div class="col contenedor"><div class="contenido"><div id="inspectores"></div></div></div>';
              div1 = div1 + '</div>';                
          break;
          case 10:
              div1 = div1 + '<div class="row">';
              div1 = div1 + '<div class="col contenedor"><div class="contenido"><p>' + data[1][i].texto + '</p></div></div>';
              div1 = div1 + '<div class="col contenedor"><div class="contenido"><div id="responsables"></div></div></div>';
              div1 = div1 + '</div>';                
          break;
          case 11:
              div1 = div1 + '<div class="row"><div class="col-5 contenedor"><div class="contenido"> <b><p>' + data[1][i].texto + '</p></b></div></div><div class="col-2 contenedor"><div class="contenido"> <b><p>STATUS</p></b></div></div><div class="col-5 contenedor"><div class="contenido"><b><p>DESCRIPCIÓN DEL PROBLEMA /COMENTARIOS</p></b></div></div></div>';
          break;

          }
        }

      if(idtipo==2){ 
          div2 = div2 + '<div class="col-12 contenedor"><div class="dist"><div align="center"><img src="{{ asset("adminlte/img/buen estado.png") }}"><br><label>Buen estado (B)</label></div><div align="center"><img src="{{ asset("adminlte/img/estado a vigilar.png") }}"><br><label>Estado a vigilar (V)</label></div><div align="center"><img src="{{ asset("adminlte/img/accion a efectuar.png") }}"><br><label>Accion a efectuar (R)</label></div><div align="center"><img src="{{ asset("adminlte/img/no utilizar.png") }}"><br><label>No utilizar, desechar (D)</label></div><div align="center"><img src="{{ asset("adminlte/img/no aplicable.png") }}"><br><label>No aplicable</label></div></div>';
          div2 = div2 + '<div class="row"><div class="col-7 contenedor" align="center"></div><div class="col-1 contenedor" align="center"><img src="{{ asset("adminlte/img/buen estado.png") }}"></div><div class="col-1 contenedor" align="center"><img src="{{ asset("adminlte/img/estado a vigilar.png") }}"></div><div class="col-1 contenedor" align="center"><img src="{{ asset("adminlte/img/accion a efectuar.png") }}"></div><div class="col-1 contenedor" align="center"><img src="{{ asset("adminlte/img/no utilizar.png") }}"></div><div class="col-1 contenedor" align="center"><img src="{{ asset("adminlte/img/no aplicable.png") }}"></div></div>';
      }

      for (var i=0; i<data[2].length; i++) {//CUERPO
        switch(data[2][i].idtipoconsigna) {
          case 1:
            div3 = div3 + '<div class="row">';
            div3 = div3 + '<div class="col contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
            div3 = div3 + '<div class="col contenedor"><div class="contenido"><input type="text" class="form-control" name="' + data[2][i].idconsigna + '"></div></div>';
            div3 = div3 + '</div>';
          break;
          case 2:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col-10 contenedor"><div class="contenido"><p>'+data[2][i].texto+'</p></div></div>';
                div3 = div3 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="si' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value=1><label for="si' + data[2][i].idconsigna + '" class="custom-control-label">SI</label></div></div>';
                div3 = div3 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="no' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value=0><label for="no' + data[2][i].idconsigna + '" class="custom-control-label">NO</label></div></div>';
                div3 = div3 + '</div>'; 
          break;
          case 3:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col-1 contenedor"><div class="contenido"><p> ' + parseInt(i+1) + ' </p></div></div>';
                div3 = div3 + '<div class="col-5 contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
                div3 = div3 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="si' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value=1><label for="si' + data[2][i].idconsigna + '" class="custom-control-label"></label></div></div>';
                div3 = div3 + '<div class="col-1 contenedor"><div class="custom-control custom-radio contenido"><input class="custom-control-input" type="radio" id="no' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value=0><label for="no' + data[2][i].idconsigna + '" class="custom-control-label"></label></div></div>';
                div3 = div3 + '<div class="col-4 contenedor"><div class="contenido"><textarea class="form-control" rows="2" name="obs' + data[2][i].idconsigna + '"></textarea></div></div>';  
                div3 = div3 + '</div>';
          break;
          case 4:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col-7 contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
                div3 = div3 + '<div class="col-1 contenedor" align="center"><input type="radio" id="1' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value="1"></div>';
                div3 = div3 + '<div class="col-1 contenedor" align="center"><input type="radio" id="2' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value="2"></div>';
                div3 = div3 + '<div class="col-1 contenedor" align="center"><input type="radio" id="3' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value="3"></div>';
                div3 = div3 + '<div class="col-1 contenedor" align="center"><input type="radio" id="4' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value="4"></div>';
                div3 = div3 + '<div class="col-1 contenedor" align="center"><input type="radio" id="5' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '" value="5"></div>';
                div3 = div3 + '</div>';
          break;
          case 5:
              div3 = div3 + '<div class="row"><div class="col-5 contenedor"><div class="contenido">' + data[2][i].texto + '</div></div><div class="col-2 contenedor"><div class="contenido"> <b><p><div class="icheck-primary d-inline"><input type="checkbox" id="' + data[2][i].idconsigna + '" name="' + data[2][i].idconsigna + '"></div></p></b></div></div><div class="col-5 contenedor"><textarea rows="3" cols="60" name="' + data[2][i].idconsigna + '" ></textarea></div></div>';  
              break;
          case 6:
            div3 = div3 + '<div class="row">';
            div3 = div3 + '<div class="col contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
            div3 = div3 + '<div class="col contenedor"><div class="contenido"><input type="date" class="form-control" name="fecha' + data[2][i].idconsigna + '" id="fecha' + data[2][i].idconsigna + '" required="required"></div></div>';
            div3 = div3 + '</div>';
          
          break;
          case 7:
            titulo=data[2][i].texto;

            if(titulo.indexOf("CRITERIO")!=-1){ 
              div3 = div3 + '<div class="row"><div class="col-6 contenedor"><div class="contenido"> <b><p>CRITERIO DE DESCARTE</p></b></div></div><div class="col-1 contenedor"><div class="contenido"> <b><p>SI</p></b></div></div><div class="col-1 contenedor"><div class="contenido"><b><p>NO</p></b></div></div><div class="col-4 contenedor"><div class="contenido"><b><p>Observaciones</p></b></div></div></div>';
            }else{
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col-12 contenedor"><div class="contenido"><b><p>' + data[2][i].texto + '</p></b></div></div>';
                div3 = div3 + '</div>';
            }
          break;
          case 8:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col-7 contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
                div3 = div3 + '<div class="col-5 contenedor"><div class="contenido"><textarea rows="4" cols="50" name="' + data[2][i].idconsigna + '" ></textarea></div></div>';
                div3 = div3 + '</div>';
          break;
          case 9:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
                div3 = div3 + '<div class="col contenedor"><div class="contenido"><div id="inspectores"></div></div></div>';
                div3 = div3 + '</div>';                
          break;
          case 10:
                div3 = div3 + '<div class="row">';
                div3 = div3 + '<div class="col contenedor"><div class="contenido"><p>' + data[2][i].texto + '</p></div></div>';
                div3 = div3 + '<div class="col contenedor"><div class="contenido"><div id="responsables"></div></div></div>';
                div3 = div5 + '</div>';                
          break;
          case 11:
              div3 = div3 + '<div class="row"><div class="col-5 contenedor"><div class="contenido"> <b><p>' + data[2][i].texto + '</p></b></div></div><div class="col-2 contenedor"><div class="contenido"> <b><p>STATUS</p></b></div></div><div class="col-5 contenedor"><div class="contenido"><b><p>DESCRIPCIÓN DEL PROBLEMA /COMENTARIOS</p></b></div></div></div>';               
          break;
          }

      }
      if(idtipo==1){ 
            div4 = div4 + '<div class="row"><div class="col-12" style="border: 1px solid #000000;"><div class="form-group">NOTAS:<br>1- Las inspecciones se realizan según la ley 19.587 – Decreto 351/79 y Decreto 911/96; Normas IRAM: 3924-5221-5242-5267-5358-5362-5368-5391. ASME B30.9-B30.26<br>2- El usuario será responsable por el correcto uso, almacenamiento y mantenimiento de los equipos, de acuerdo a la legislación vigente y las buenas prácticas; debiendo realizar las inspecciones diarias y periódicas correspondientes.</div></div></div>' 
      }

      for (var i=0; i<data[3].length; i++) { //PIE
        switch(data[3][i].idtipoconsigna) {
          case 1:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><p>' + data[3][i].texto + '</p></div></div>';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><input type="text" class="form-control" name="' + data[3][i].idconsigna + '"></div></div>';
            div6 = div6 + '</div>';
          break;
          case 2:
              // code block
          break;
          case 3:
            // code block
          break;
          case 4:
            // code block
          break;
          case 5:
            // code block
          break;
          case 6:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><p>' + data[3][i].texto + '</p></div></div>';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><input type="date" class="form-control" name="fecha' + data[3][i].idconsigna + '" id="fecha' + data[3][i].idconsigna + '" required="required"></div></div>';
            div6 = div6 + '</div>';
          break;
          case 7:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col-12 contenedor"><div class="contenido"><b><p>' + data[3][i].texto + '</p></b></div></div>';
            div6 = div6 + '</div>';
          break;
          case 8:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col-7 contenedor"><div class="contenido"><p>' + data[3][i].texto + '</p></div></div>';
            div6 = div6 + '<div class="col-5 contenedor"><div class="contenido"><textarea rows="4" cols="50" name="' + data[1][i].idconsigna + '" ></textarea></div></div>';
            div6 = div6 + '</div>';
          break;
          case 9:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><p>' + data[3][i].texto + '</p></div></div>';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><div id="inspectores"></div></div></div>';
            div6 = div6 + '</div>';                
          break;
          case 10:
            div6 = div6 + '<div class="row">';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><p>' + data[3][i].texto + '</p></div></div>';
            div6 = div6 + '<div class="col contenedor"><div class="contenido"><div id="responsables"></div></div></div>';
            div6 = div6 + '</div>';    
          break;
        }


      }   
      if(idtipo==1){ 

      }
      if(idtipo==2){ 
      }
      if(idtipo==3){ 
            div7 = div7 + '<div class="row">';
            div7 = div7 + '<div class="col-12 contenedor"><div class="contenido">La inspección competente puede solo realizarse por AVANTI o por unap ersona competente certificado por AVANTI .A cada12meses debe hacerse una inspección competente y será necesario rellenar este formulario para futuras referencias.</div></div>';
            div7 = div7 + '</div>';                

      }   
    
          var ruta='{{asset('buscarinspectores')}}';
          $.ajax({
            url: ruta,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data) {
              bloque = document.getElementById('inspectores');
              elemento = document.createElement('select');
              elemento.setAttribute("class", "custom-select custom-select-sm-1 mb-3");
              elemento.setAttribute("name","inspector");
              elemento.setAttribute("id","inspector");
              bloque.appendChild(elemento);
              for (var i=0; i<data.length; i++) {
                 var option = document.createElement("option");
                 option.value = data[i].idinspector;
                 option.text = data[i].nombres+' '+data[i].apellidos;
                 elemento.appendChild(option);
              }
            }
          });

          var ruta='{{asset('buscarresponsables')}}';
          $.ajax({
            url: ruta,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data) {
              bloque = document.getElementById('responsables');
              elemento = document.createElement('select');
              elemento.setAttribute("class", "custom-select custom-select-sm-1 mb-3");
              elemento.setAttribute("name","responsable");
              elemento.setAttribute("id","responsable");

              bloque.appendChild(elemento);
              for (var i=0; i<data.length; i++) {
                 var option = document.createElement("option");
                 option.value = data[i].idresponsable;
                 option.text = data[i].nombres+' '+data[i].apellidos;
                 elemento.appendChild(option);
              }
            }
          });
          document.getElementById("divform").innerHTML = div1+div2+div3+div4+div5+div6+div7; 

    }



   });

  
}); 


});
</script>
 
@endsection
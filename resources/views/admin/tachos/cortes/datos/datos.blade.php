@extends('admin.layout')
@section('titulo', 'Evaluación de laboratorio')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Datos de la evaluación N°: <b>{{$datosasociados[0]->idevaluacion}}</b></h3>
	</div>
</div>

<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
        <form >
        <input id="idevaluacion" name="idevaluacion" type="hidden" value="{{$datosasociados[0]->idevaluacion}}"/>
<!--         <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th width="5%">T.</th>
                                <th width="5%">Tabla</th>
                                <th width="5%">Tablita</th>
                                <th width="5%">Surco</th>  
                                <th width="5%">Parcela</th>
                                <th width="10%">Variedad</th>
                                <th width="10%">Peso muestra</th>
                                <th width="10%">Peso jugo</th>
                                <th width="10%">Brix</th>
                                <th width="10%">Polarización</th>
                                <th width="10%">Temperatura</th>
                                <th width="5%">Brix corregido</th>
                                <th width="5%">Pol en jugo</th>
                                <th width="5%">Pureza</th>
                                <th width="5%">Rendimiento probable</th>
                                <th width="5%">Pol en caña</th>

                            </thead>
                </table>
            </div>
        </div> -->
            <div class="container">
            <div class="wrapper">
              <div class="col-md-12" id="results"></div>
            <div class="ajax-loading"><img src="{{ asset('img/loading.gif') }}" /></div>
            </div>
            </div>
        </div>

    </form>
@endsection
@section('script')

<script type="text/javascript">
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
  function guardavariedad(id) {
    var ev = (id.substr(1));
    var pesomuestra = document.getElementById("pm"+ev).value;
    var pesojugo = document.getElementById("pj"+ev).value;
    var brix = document.getElementById("b"+ev).value;
    var polarizacion = document.getElementById("p"+ev).value;
    var temperatura = document.getElementById("t"+ev).value;
    var conductividad = document.getElementById("c"+ev).value;
    $.ajax({
      type: 'POST',
      url:"{{ route('laboratorios.post') }}",
      data:{id:ev,pesomuestra:pesomuestra,pesojugo:pesojugo,brix:brix,polarizacion:polarizacion,temperatura:temperatura,conductividad:conductividad},
      success: function(data){
        //alert(data.success);
      }
    });

  } 


    var SITEURL = "{{ url('/') }}";
    var page = 1; //track user scroll as page number, right now page number is 1
    var idevaluacion = $("#idevaluacion").val();
    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
      if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
      page++; //page number increment
      load_more(page); //load content   
      }
    });     
    function load_more(page){
        $.ajax({
           url: SITEURL + "/admin/bancos/laboratorios/"+idevaluacion+"?page=" + page,
           type: "get",
           datatype: "html",
           beforeSend: function()
           {
              $('.ajax-loading').show();
            }
        })
        .done(function(data)
        {
//            alert(data.length);
            if(data.length == 607){
            //notify user if nothing to load
            $('.ajax-loading').html("No hay más registros");
            return;
          }
          $('.ajax-loading').hide(); //hide loading animation once data is received
          $("#results").append(data); //append data into #results element          
       })
       .fail(function(jqXHR, ajaxOptions, thrownError)
       {
          alert('No response from server');
       });
    }

</script>
@endsection 
@extends('admin.layout')
@section('titulo', 'Datos sanitarios')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Datos de la evaluación N°: <b>{{$sanitariap->id}}</b> - Nombre: <b>{{$datosasociados[0]->nombre_tipo}}</b> - Campaña: <b>{{$sanitariap->campania->nombre}}</b></h3>
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
        <div class="container">
            <div class="wrapper">
              <div class="col-md-12" id="results"></div>
              <div class="ajax-loading"><img src="{{ asset('img/loading.gif') }}" /></div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script type="text/javascript">
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
  function guardaevaluacion(id) {
    var ev = (id.substr(1));
    var carbon = document.getElementById("c"+ev).value;
    var escaladura = document.getElementById("e"+ev).value;
    var estriaroja = document.getElementById("er"+ev).value;
    var mosaico = document.getElementById("m"+ev).value;
    var royamarron = document.getElementById("rm"+ev).value;
    var royaanaranjada = document.getElementById("ra"+ev).value;
    var pokkaboeng = document.getElementById("pb"+ev).value;
    var amarillamiento = document.getElementById("a"+ev).value;
    var manchaparda = document.getElementById("mp"+ev).value;
    var otra = document.getElementById("o"+ev).value;

    $.ajax({
      type: 'POST',
      url:"{{ route('sanitariasp.post') }}",
      data:{id:ev,carbon:carbon,escaladura:escaladura,estriaroja:estriaroja,mosaico:mosaico,royamarron:royamarron,royaanaranjada:royaanaranjada,pokkaboeng:pokkaboeng,amarillamiento:amarillamiento,manchaparda:manchaparda,otra:otra},
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
           url: SITEURL + "/admin/progenitores/sanitarias/"+idevaluacion+"?page=" + page,

           type: "get",
           datatype: "html",
           beforeSend: function()
           {
              $('.ajax-loading').show();

            }
        })
        .done(function(data)
        {
          if(data.length == 675){
            console.log(data.length);
            //notify user if nothing to load
            $('.ajax-loading').html("No hay más registros");
            return;
          }
          $('.ajax-loading').hide(); //hide loading animation once data is received
          $("#results").append(data); //append data into #results element 

           console.log('data.length');
       })
       .fail(function(jqXHR, ajaxOptions, thrownError)
       {
          alert('No response from server');
       });
    }

</script>
@endsection 
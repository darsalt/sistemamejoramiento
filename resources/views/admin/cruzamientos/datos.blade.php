@extends('admin.layout')
@section('titulo', 'Poder Germinativo')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Poder Germinativo de los cruzamientos de la campaña <b>{{$podergerminativo[0]->fechacruzamiento}}</b></h3>
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
<!--         <input id="idevaluacion" name="idevaluacion" type="hidden" value="{{$datosasociados[0]->idevaluacion}}"/>
 --><!--         <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th width="5%">T.</th>
                                <th width="5%">Tabla</th>
                                <th width="5%">Tablita</th>
                                <th width="5%">Surco</th>  
                                <th width="5%">Parcela</th>
                                <th width="10%">Variedad</th>
                                <th width="10%">Tallos</th>
                                <th width="10%">Altura</th>
                                <th width="10%">Grosor</th>
                                <th width="10%">Vuelco</th>  
                                <th width="10%">Floración</th>
                                <th width="15%">Otra</th>
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
    var tallos = document.getElementById("t"+ev).value;
    var altura = document.getElementById("a"+ev).value;
    var grosor = document.getElementById("g"+ev).value;
    var vuelco = document.getElementById("v"+ev).value;
    var floracion = document.getElementById("f"+ev).value;
    var otras = document.getElementById("o"+ev).value;

    $.ajax({
      type: 'POST',
      url:"{{ route('agronomicas.post') }}",
      data:{id:ev,tallos:tallos,altura:altura,grosor:grosor,vuelco:vuelco,floracion:floracion,otras:otras},
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
           url: SITEURL + "/admin/bancos/agronomicas/"+idevaluacion+"?page=" + page,

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
            if(data.length == 456){
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
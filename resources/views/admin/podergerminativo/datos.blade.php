@extends('admin.layout')
@section('titulo', 'Poder Germinativo')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Poder Germinativo de los cruzamientos de la campaña <b>{{$podergerminativo[0]->idcampania}}</b></h3>
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
   
  function guardapoder(id) {
    var cr = (id.substr(1));
    var gramos = document.getElementById("g"+cr).value;
    var conteo = document.getElementById("c"+cr).value;
    var podergerminativo = document.getElementById("c"+cr).value*2;
    var plantinespotenciales = document.getElementById("g"+cr).value * document.getElementById("c"+cr).value;

    $.ajax({
      type: 'POST',
      url:"{{ route('podergerminativo.post') }}",
      data:{id:cr,gramos:gramos,conteo:conteo,podergerminativo:podergerminativo,plantinespotenciales:plantinespotenciales},
      success: function(data){
      //alert(data.success);
      }
    });

  } 


    var SITEURL = "{{ url('/') }}";
    var page = 1; //track user scroll as page number, right now page number is 1
//    var idevaluacion = $("#idevaluacion").val();
    var campania = 5;//$("#idevaluacion").val();

    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
      if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
      page++; //page number increment
      load_more(page); //load content   
      }
    });     
    function load_more(page){

        $.ajax({
           url: SITEURL + "/admin/podergerminativo/edit/"+campania+"?page=" + page,
           //url: SITEURL + "/admin/bancos/agronomicas/"+idevaluacion+"?page=" + page,

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
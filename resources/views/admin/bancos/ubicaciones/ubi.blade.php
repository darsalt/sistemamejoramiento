@extends('admin.layout')
@section('titulo', 'Ubicaciones')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	</div>
</div>
<h3>Ubicaciones en el banco: <b>{{$banco->nombre}}</b></h3>
<div class="container">
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

        {{ csrf_field() }}
      <input id="idbanco" name="idbanco" type="hidden" value="{{$banco->idbanco}}"/>
      <div class="container">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th width="15%">Testigo</th>
              <th width="15%">Tabla</th>
              <th width="15%">Tablita</th>
              <th width="15%">Surco</th>  
              <th width="15%">Parcela</th>
              <th width="25%">Variedad</th>
            </thead>
         </table>
        </div>
      </div>
      <div class="container">
       <div class="wrapper">

          <div class="col-md-12" id="results"></div>



         <div class="ajax-loading"><img src="{{ asset('img/loading.gif') }}" /></div>
       </div>
      </div>
        <!--  -->
</div>
@endsection
@section('script')
<script type="text/javascript">

  function guardavariedad(id,variedad) {
//    alert("id "+id);
//    alert("variedad "+variedad);
    var SITEURL = "{{ url('/') }}";


     $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      url: SITEURL + "/ubicaciones/datos",

      type: 'POST',
      data: { _token:'{{ csrf_token() }}', ubicacion: id,variedad: variedad},
      success: function(response){
        alert(response);
      }
    });

  } 

  function guardatestigo(id) {
    alert("testigo"+id);
  }

    var SITEURL = "{{ url('/') }}";
    var page = 1; //track user scroll as page number, right now page number is 1
    var idbanco = $("#idbanco").val();
    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
      if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
      page++; //page number increment
      load_more(page); //load content   
      }
    });     
    function load_more(page){
        var ruta='{{asset('admin/bancos/ubicaciones')}}/'+idbanco;
        $.ajax({
           url: SITEURL + "/admin/bancos/ubicaciones/"+idbanco+"?page=" + page,
           type: "get",
           datatype: "html",
           beforeSend: function()
           {
              $('.ajax-loading').show();
            }
        })
        .done(function(data)
        {
            if(data.length == 0){
            //notify user if nothing to load
            $('.ajax-loading').html("No more records!");
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

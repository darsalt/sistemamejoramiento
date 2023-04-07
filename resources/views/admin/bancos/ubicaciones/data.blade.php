@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h3>Ubicaciones en el banco: <b>{{$banco->nombre}}</b></h3>
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
        	<input id="idbanco" name="idbanco" type="hidden" value="{{$banco->idbanco}}"/>
 		      

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

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
               @foreach ($ubicaciones as $u)
				<tr>
          <?php
          if ($u->testigo==1) 
            $t='value = 1 checked';
          else
            $t='value = 0';
          ?>
          <td width=15%><input type="checkbox" name="t{{$u->id}}" id="t{{$u->id}}" onchange="guardatestigo(this.name,this.value)" {{$t}}> </td>
          <td width=15%><label for="tabla">{{$u->tabla}}</label></td>
					<td width=15%><label for="tabla">{{$u->tablita}}</label></td>
          <td width=15%><label for="tabla">{{$u->surco}}</label></td>
					<td width=15%><label for="tabla">{{$u->parcela}}</label></td>
          <td width=25%>
          <select style="width: 100%;" name={{$u->id}} id={{$u->id}} class="select2" class="form-control" required onchange="guardavariedad(this.name,this.value)">
            <option value="0">Ninguno</option>
              @foreach ($variedades as $variedad)
                 <?php if ($variedad->idvariedad==$u->idvariedad) 
                        $s='selected="selected"';
                    else
                        $s='';
                ?>
                <option value="{{$variedad->idvariedad}}" {{$s}}>
                  {{$variedad->nombre }}
                </option>
              @endforeach
            </select>
          </td>
          <tr>		
          @endforeach
			</table>
      {{ $ubicaciones->links() }}

		</div>
	</div>
</div>

            
        </form>
    </div>
  
</body>
@endsection
@section('script')

<script type="text/javascript">
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
  function guardavariedad(id,variedad) {
      //  var name = $("input[name=name]").val();
      //  var password = $("input[name=password]").val();
      //  var email = $("input[name=email]").val();
      $.ajax({
      type: 'POST',
      url:"{{ route('ubicaciones.post') }}",
      data:{id:id, variedad:variedad},
      success: function(data){
        //alert(data.success);
        console.log(variedad);

      }
    });

  } 

    function guardatestigo(id,testigo) {
      var key = (id.substr(1));
      //alert(key);
      //alert(testigo);
      $.ajax({
      type: 'POST',
      url:"{{ route('testigo.post') }}",
      data:{id:key, testigo:testigo},
      success: function(data){
    //    alert(data.success);
      }
    });

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
            //alert(data.length);
            if(data.length == 325){
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
  
@extends('admin.layout')
@section('titulo', 'Ubicaciones')
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Ubicaciones en el banco: <b>{{$banco->nombre}}</b></h3>
	</div>
</div>

<div class="container">
  <h2 class="text-center">Laravel infinite scroll pagination</h2>
  <br/>
  <div class="col-md-12" id="post-data">
    @include('admin.bancos.ubicaciones.data')


  </div>
</div>


<div class="ajax-load text-center" style="display:none">
  <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>

<script type="text/javascript">
  var page = 1;
  $(window).scroll(function() {
      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
          page++;
          loadMoreData(page);
      }
  });


  function loadMoreData(page){
    $.ajax(
          {
              url: '?page=' + page,
              type: "get",
              beforeSend: function()
              {
                  $('.ajax-load').show();
              }
          })
          .done(function(data)
          {
              if(data.html == " "){
                  $('.ajax-load').html("No more records found");
                  return;
              }
              $('.ajax-load').hide();
              $("#post-data").append(data.html);
          })
          .fail(function(jqXHR, ajaxOptions, thrownError)
          {
                alert('server not responding...');
          });
  }
</script>


@endsection

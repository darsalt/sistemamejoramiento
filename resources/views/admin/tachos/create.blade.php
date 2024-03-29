@extends('admin.layout')
@section('titulo', 'Registrar Tacho')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo Tacho</h3>
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

	{!!Form::open(array('url'=>'admin/tachos','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tacho</label>
               	<input type="number" name="codigo" id="codigo" class="form-control" placeholder="Tacho...">
            </div>
        </div>
    </div>
    <div class="row" id="subtachosYaCargados" style="display: none;">
        <div class="col-12">
            <label for="">Subtachos ya cargados</label>
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
           	    <label for="nombre">Subtacho</label>
           	    <!-- <input type="text" name="subcodigo" class="form-control" placeholder="Subtacho..."> -->
                <select name="subcodigo[]" id="subcodigo" class="select2" multiple="multiple" data-placeholder="Seleccione Tachos" style="width: 100%;" required="required" class="form-control" >
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                    <option value="H">H</option>
                    <option value="I">I</option>
                    <option value="J">J</option>
                    <option value="K">K</option>
                    <option value="L">L</option>
                    <option value="M">M</option>
                    <option value="N">N</option>
                    <option value="O">O</option>
                    <option value="P">P</option>
                    <option value="Q">Q</option>
                    <option value="R">R</option>
                    <option value="S">S</option>
                    <option value="T">T</option>
                    <option value="U">U</option>
                    <option value="V">V</option>
                    <option value="W">W</option>
                    <option value="X">X</option>
                    <option value="Y">Y</option>
                    <option value="Z">Z</option>
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="variedad">Clones</label>
                    <select name="idvariedad" id="idvariedad" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguno</option>
                        @foreach ($variedades as $variedad)
                            <option value="{{$variedad->idvariedad}}">
                                {{$variedad->nombre }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="destino">Destino</label>
                <select name="destino" id="destino" class="select2" style="width: 100%;" required="required" class="form-control" >
                    <option value="1" selected="selected">Tachos de progenitores</option>
                    <option value="2">Cuarentena</option>
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Alta </label><br>
                <input class="form-control" name="fechaalta" id="fechaalta" type="date" required="required">
            </div>
        </div>
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

@endsection

@section('script')
    <script>
        $('#codigo').focusout(function(){
            if($('#codigo').val() > 0){
                $.ajax({
                    url: "{{route('ajax.tachos.getSubtachosDeTacho')}}",
                    method: "GET",
                    dataType: "json",
                    data: {
                        'codigo': $('#codigo').val()
                    },
                    success: function(response){
                        var parrafo = $('#subtachosYaCargados p');

                        parrafo.empty();
                        $("#subcodigo option").removeAttr("disabled");
                        $.each(response.subtachos, function(i, item){
                            parrafo.text(parrafo.text() + item + ' ');
                            $("#subcodigo option[value='" + item + "']").attr("disabled", "disabled");
                        });

                        if(response.subtachos.length > 0){
                            $('#idvariedad').val(response.variedad);
                            $('#idvariedad').attr("readonly", "readonly");
                        }
                        else{
                            parrafo.text('Ninguno');
                            $('#idvariedad').val(0);
                            $('#idvariedad').removeAttr("readonly");
                        }
                        $('#idvariedad').select2();

                        $('#subtachosYaCargados').show();
                    }
                });
            }
        });
    </script>
@endsection
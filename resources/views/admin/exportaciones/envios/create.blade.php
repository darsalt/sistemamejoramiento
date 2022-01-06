@extends('admin.layout')
@section('titulo', 'Registrar envío')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nuevo envío</h3>
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

<section class="content">
    <form action="{{route('exportaciones.envios.store')}}" id="formEnvios" method='POST'>
        @csrf
        <div class="row">
            <input type="text" name="envios" id="envios" hidden>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="fechaenvio">Fecha envío</label>
                    <input type="date" class="form-control" name="fechaenvio" id="fechaenvio" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="programa">Programa mejoramiento</label>
                    <input type="text" name="programa" id="programa" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="destino">Destino</label>
                    <input type="text" name="destino" id="destino" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="box">Box</label>
                    <select name="box" id="box" class="form-control">
                        <option value="" disabled selected>(Ninguno)</option>
                        @foreach ($boxes as $box)
                            <option value="{{$box->id}}">{{$box->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="tacho">Tacho</label>
                    <select name="tacho" id="tacho" class="form-control">
                        <option value="" disabled selected>(Ninguno)</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="yemas">Cant. Yemas</label>
                    <input type="number" name="yemas" id="yemas" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <button class="btn btn-primary" id="agregarEnvio" type="button">Agregar</button>
            </div>
            <div class="col-12">
                <table class="table table-sm" id="tablaEnvios">
                    <thead>
                        <th></th>
                        <th style="display: none;">Id Box</th>
                        <th style="display: none;">Id Tacho</th>
                        <th>Box</th>
                        <th>Tacho</th>
                        <th>Cant. yemas</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="submit">Guardar</button>
                    <button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>
</section>

@endsection
@section('script')
<script>  
    function eliminarIngreso(idBox, idTacho){
        index = envios.findIndex(function(item, i){
            return item.idbox == idBox && item.idtacho == idTacho;
        });

        envios.splice(index, 1);
        
        actualizarTabla();
    }

    function actualizarTabla(){
        tbody = $('#tablaEnvios').find('tbody');

        tbody.empty();
        lineas = "";
        envios.forEach(function(element){
            linea = '<tr>'
            linea += "<td><a href='javascript:eliminarIngreso(" + element.idbox + "," + element.idtacho + ")'><i class='fas fa-times'></i></a></td>";
            linea += "<td style='display: none;'>" + element.idbox + "</td>";
            linea += "<td style='display: none;'>" + element.idtacho + "</td>";
            linea += '<td>' + element.nombrebox + '</td>';
            linea += '<td>' + element.nombretacho + '</td>';
            linea += '<td>' + element.yemas + '</td>';
            linea += '</td>';

            lineas += linea;
        });
        tbody.append(lineas);
    }

    $(document).ready(function() {
        envios = [];

        $('#box').change(function(){
            $.ajax({
                url: "{{route('ajax.tachos.getTachosBoxExportacion')}}",
                method: 'GET',
                data_type: 'json',
                data: {
                    'box': $('#box').val()
                },
                success: function(response){
                    $('#tacho').empty();
                    $('#tacho').append('<option value="" disabled selected>(Ninguno)</option>');
                    $.each(response, function(i, item){
                        $('#tacho').append('<option value="' + item.idtacho + '">' + item.codigo + ' - ' + item.subcodigo + '</option>');
                    });
                }
            });
        });

        $('#agregarEnvio').click(function(){
            box = $('#box').val();
            boxNombre = $("#box option:selected").text();
            tachoId = $('#tacho').val();
            tachoNombre = $("#tacho option:selected").text();
            cantYemas = $('#yemas').val();

            if(tachoId > 0 && box > 0 && cantYemas > 0){
                envio = {'idbox': box, 'nombrebox': boxNombre, 'idtacho': tachoId, 'nombretacho': tachoNombre, 'yemas': cantYemas};
                envios.push(envio);

                // Reiniciar campos
                $('#box').val('');
                $('#tacho').val('');
                $('#yemas').val('');

                actualizarTabla();
            }
            else
                alert('Debe elegir un box y tacho y una cantidad valida de yemas.');
        });

        $('#submit').click(function(e){
            $('#envios').val(JSON.stringify(envios));
        }); 
    });
</script>
@endsection
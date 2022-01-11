@extends('admin.layout')
@section('titulo', 'Registrar importación')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva variedad a cuarentena para importación</h3>
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
        <form action="{{route('importaciones.ingresos.store')}}" id="formIngresos" method='POST'>
            @csrf
            <div class="row">
                <input type="text" name="ingresos" id="ingresos" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fechaingreso">Fecha ingreso</label>
                        <input type="date" class="form-control" name="fechaingreso" id="fechaingreso" required>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="campania">Campaña</label>
                        <select name="campania" id="campania" class="form-control" required>
                            <option value="" disabled selected>(Ninguna)</option>
                            @foreach ($campanias as $campania)
                                <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="boxes">Boxes</label>
                        <select name="boxes" id="boxes" class="form-control" required>
                            <option value="0" disabled selected>(Ninguno)</option>
                            @foreach ($boxes as $box)
                                <option value="{{$box->id}}">{{$box->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tachos">Tachos</label>
                        <select name="tachos" id="tachos" class="form-control" required>
                            <option value="0" disabled selected>(Ninguno)</option>
                            @foreach ($tachos as $tacho)
                                <option value="{{$tacho->idtacho}}">{{$tacho->codigo . ' ' . $tacho->subcodigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="lote">Lote cuarentenario</label>
                        <input type="text" name="lote" id="lote" class="form-control">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="origen">Origen</label>
                        <input type="text" name="origen" id="origen" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <button class="btn btn-primary" id="agregarTacho" type="button">Agregar</button>
                </div>
                <div class="col-12">
                    <table class="table table-sm" id="tablaIngresos">
                        <thead>
                            <th></th>
                            <th style="display: none;">Id Box</th>
                            <th>Box</th>
                            <th>Tacho</th>
                            <th>Lote cuarentenario</th>
                            <th>Origen</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
                        <button class="btn btn-primary" type="submit" id="submit">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
@section('script')
<script>  
    function eliminarIngreso(idBox, idTacho){
        index = ingresos[idBox].findIndex(function(item, i){
            return item.id == idTacho;
        });

        ingresos[idBox].splice(index, 1);

        // Volver a activar tacho
        $('#tachos option[value="' + idTacho + '"]').removeAttr('disabled');
        
        actualizarTabla();
    }

    function actualizarTabla(){
        tbody = $('#tablaIngresos').find('tbody');

        tbody.empty();
        lineas = "";
        $('#boxes option').each(function(i, element){
            if(ingresos.hasOwnProperty(element.value)){
                tachos = ingresos[element.value];
                tachos.forEach(function(element2){
                    linea = '<tr>'
                    linea += "<td><a href='javascript:eliminarIngreso(" + element.value + "," + element2.id + ")'><i class='fas fa-times'></i></a></td>";
                    linea += "<td style='display: none;'>" + element.value + "</td>";
                    linea += '<td>' + element.text + '</td>';
                    linea += '<td>' + element2.nombre + '</td>';
                    linea += '<td>' + element2.lote + '</td>';
                    linea += '<td>' + element2.origen + '</td>';
                    linea += '</td>';

                    lineas += linea;
                });
            }
        });
        tbody.append(lineas);
    }
    
$(document).ready(function() {
    ingresos = {};

    $('#agregarTacho').click(function(){
        box = $('#boxes').val();
        tachoId = $('#tachos').val();
        tachoNombre = $("#tachos option:selected").text();
        lote_cuarentenario = $('#lote').val();
        origen = $('#origen').val();

        if(tachoId > 0 && box > 0){
            if(ingresos.hasOwnProperty(box)){
                ingresos[box].push({'id': tachoId, 'nombre': tachoNombre, 'lote': lote_cuarentenario, 'origen': origen});
            }
            else{
                ingresos[box] = [{'id': tachoId, 'nombre': tachoNombre, 'lote': lote_cuarentenario, 'origen': origen}];
            }

            // Deshabilitar el tacho
            $('#tachos option[value="' + tachoId + '"]').prop('disabled', 'disabled');
            $('#tachos').val(0);
            $('#lote').val('');
            $('#origen').val('');

            actualizarTabla();
        }
        else
            alert('Debe elegir un box y tacho');
    });

    $('#submit').click(function(e){
        $('#ingresos').val(JSON.stringify(ingresos));
    });  
});

</script>
@endsection
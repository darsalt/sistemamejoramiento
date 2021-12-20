@extends('admin.layout')
@section('titulo', 'Registrar Semilla')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Ajustar stock de semilla</h3>
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

    <form action="{{route('inventario.egresos.store')}}" method="POST" autocomplete="off">
        @csrf
        <div class="form-group" style="text-align:center;">
            <label for="campania">Campaña</label>
            <select name="campania" id="campania" class="select2" style="width: 100%; " class="form-control" required>
                <option value="">(Ninguna)</option>
                @foreach ($campanias as $campania)
                    <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label for="cruzamiento">N° Cruzamiento</label>
                <select name="cruzamiento" id="cruzamiento" class="select2" style="width: 100%; " class="form-control" required>
                    <option value="" selected disabled>(Ninguno)</option>
                </select>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="madre">Madre</label>
                    <input type="text" name="madre" id="madre" class="form-control" placeholder="Madre..." readonly>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="padre">Padre</label>
                    <input type="text" name="padre" id="padre" class="form-control" placeholder="Padre..." readonly>
                </div>
            </div>
        </div>

        <div class="form-group" style="text-align:center;">
            <label for="motivo">Motivo</label>
            <select name="motivo" id="motivo" class="select2" style="width: 100%; " class="form-control" required>
                <option value="" selected disabled>(Ninguno)</option>
                @foreach ($motivos as $motivo)
                    <option value="{{$motivo->id}}">{{$motivo->nombre}}</option> 
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="cantidad">Stock a ajustar</label>
                    <input type="number" name="cantidad" step="0.01" class="form-control" placeholder="Cantidad a ajustar..."  required="required">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="date">Fecha Egreso </label><br>
                    <input class="form-control" name="fechaegreso" id="fechaegreso" type="date" required="required">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control" placeholder="Ingrese observaciones"></textarea>
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

    </form>
    
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            // Cuando se selecciona una campaña
            var nombresPadres = {};

            $('#campania').change(function(){
                var campania = $(this).children('option:selected').val();
                nombresPadres = {};
                // Obtener cruzamientos segun la campania
                $.ajax({
                    url: "{{route('ajax.cruzamientos.getCruzamientos')}}",
                    type: 'GET',
                    data: {
                        'campania': campania
                    },
                    success: function(response){
                        $('#cruzamiento').empty();
                        $('#cruzamiento').append("<option value=''>(Ninguno)</option>");
                        $.each(response, function(i, item){
                            $('#cruzamiento').append("<option value='" + item.id + "'>" + item.id + "</option>");
                            padres = {madre: item.madre.nombre, padre: item.padre.nombre};
                            nombresPadres[item.id] = padres;
                        });

                        $('#madre').val('');
                        $('#padre').val('');
                        $('#cruzamiento').select2();
                    }
                });
            });

            // Cuando se elige un cruzamiento
            $('#cruzamiento').change(function(){
                idCruzamiento = $(this).val();

                madre = nombresPadres[idCruzamiento].madre;
                padre = nombresPadres[idCruzamiento].padre;

                $('#madre').val(madre);
                $('#padre').val(padre);
            });
        });
    </script>
@endsection

@extends('admin.layout')
@section('titulo', 'Registrar Clon')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Nuevo Clon</h3>
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

        {!!Form::open(array('url'=>'admin/variedades','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label> AZ-01-0123
                <input type="text" name="nombre" pattern="\w{1,10}-\d{2}-\d{4}" title="Tres campos separados por guiones,donde el segundo debe ser un número de 2 cifras y el último debe ser un número de 4 cifras (complete con ceros adelante si es necesario)" class="form-control" placeholder="Nombre..."required>
            </div>
        </div>
    </div>
<!--         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                  <label for="tacho">Tachos</label>
                    <select name="idtacho" id="idtacho" class="select2" style="width: 100%;"  class="form-control" required>
                        <option value="">Seleccione un Tacho</option>
                        @foreach ($tachoslibres as $tacho)
                            <option value="{{$tacho->idtacho}}">
                                {{$tacho->codigo}} - {{$tacho->subcodigo}}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div> -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="madre">Madre</label>
                <input type="text" name="madre" class="form-control" placeholder="Madre..." required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="padre">Padre</label>
                <input type="text" name="padre" class="form-control" placeholder="Padre...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="tonelaje">Tonelaje</label>
                <input type="text" name="tonelaje" class="form-control" placeholder="Tonelaje...">
            </div>
        </div>
    </div>
    <div class="row">        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="azucar">Azúcar</label>
                <input type="text" name="azucar" class="form-control" placeholder="Azúcar...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="floracion">Floración</label>
                <input type="text" name="floracion" class="form-control" placeholder="Floración...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="suelos">Suelos</label>
                <input type="text" name="suelos" class="form-control" placeholder="Suelos...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="fibra">Fibra</label>
                <input type="text" name="fibra" class="form-control" placeholder="Fibra...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="deshojado">Deshojado</label>
                <input type="text" name="deshojado" class="form-control" placeholder="Deshojado...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="vuelco">Vuelco</label>
                <input type="text" name="vuelco" class="form-control" placeholder="Vuelco...">
            </div>
        </div>
    </div>
        <div id="divsanitaria" style="border: solid 1px #000000;">
            <label for="resistencia">Resistencia a enfermedades</label>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="carbon">Carbón</label>
                        <input type="text" name="carbon" id="carbon" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="escaladura">Escaladura</label>
                        <input type="text" name="escaladura" id="escaladura" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="estriaroja">Estria roja</label>
                        <input type="text" name="estriaroja" id="estriaroja" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="mosaico">Mosaico</label>
                        <input type="text" name="mosaico" id="mosaico" class="form-control">
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="royamarron">Roya Marrón</label>
                        <input type="text" name="royamarron" id="royamarron" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="royanaranja">Roya Naranja</label>
                        <input type="text" name="royanaranja" id="royanaranja" class="form-control">
                    </div>
                </div>
            </div>
                        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="pokkaboeng">Pokka boeng</label>
                        <input type="text" name="pokkaboeng" id="pokkaboeng" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="amarillamiento">amarillamiento</label>
                        <input type="text" name="amarillamiento" id="amarillamiento" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="manchaparda">Mancha parda</label>
                        <input type="text" name="manchaparda" id="manchaparda" class="form-control">
                    </div>
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
    {!!Form::close()!!}
</div>

@endsection
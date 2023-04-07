@extends('admin.layout')
@section('titulo', 'Registrar Evaluación Agronómica')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Nueva Evaluación</h3>
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

    {!!Form::open(array('url'=>'bancos/agronomicas','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre del Banco</label>
                <select name="idbanco" id="idbanco" class="form-control">
                 <option value="{{$bancos->idbanco}}" >{{$bancos->nombre}}</option>
              </select>
         </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre de la evaluación</label>
                    <select name="idnombre" id="idnombre" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguna</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">
                                {{$tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Generación </label><br>
                <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
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
<div id="hot"></div>

</div>

@endsection
@section('script')

<script>

</script>
@endsection

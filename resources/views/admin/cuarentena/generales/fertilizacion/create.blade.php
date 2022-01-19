@extends('admin.layout')
@section('titulo', 'Registrar tarea de fertilización cuarentena')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Nueva Fertilización</h3>
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

    <form action="{{route('cuarentena.generales.fertilizacion.store')}}" method="POST" autocomplete="off">
        @csrf

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="fecha">Fecha Fertilización</label><br>
                    <input class="form-control" name="fecha" id="fecha" type="date" required="required">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="fecha">Campaña</label><br>
                    <select name="campania" id="campania" class="form-control">
                        @foreach ($campanias as $campania)
                            <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="producto">Producto</label>
                    <input type="text" name="producto" class="form-control" placeholder="Producto..." required="required">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="dosis">Dosis</label>
                    <input type="text" name="dosis" class="form-control" placeholder="Dosis..."required="required">
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
<div id="hot"></div>

</div>

@endsection
@section('script')

<script>

</script>
@endsection

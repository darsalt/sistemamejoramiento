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


        {!!Form::open(array('url'=>'admin/variedades','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}

    <div class="form-group" style="text-align:center;">
      <label for="campaña">Campaña</label>
      <form action="{{url('admin/marcotado/campania')}}" method="GET">
        <select name="campanias" id="campanias" class="select2" style="width: 100%; " class="form-control" required onchange="this.form.submit()">
       </select>
       
       </form>
    </div>

   <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <label for="cruzamiento">N° Cruzamiento</label>
      <form action="{{url('admin/marcotado/campania')}}" method="GET">
        <select name="cruzamiento" id="cruzamiento" class="select2" style="width: 100%; " class="form-control" required onchange="this.form.submit()">
       </select>
       
       </form>
    </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="madre">Madre</label>
                <input type="text" name="madre" class="form-control" placeholder="Madre...">
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="padre">Padre</label>
                <input type="text" name="padre" class="form-control" placeholder="Padre...">
            </div>
        </div>
    </div>

    <div class="form-group" style="text-align:center;">
      <label for="motivo">Motivo</label>
      <form action="{{url('admin/marcotado/campania')}}" method="GET">
        <select name="motivo" id="motivo" class="select2" style="width: 100%; " class="form-control" required onchange="this.form.submit()">
       </select>
       
       </form>
    </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="form-group">
                <label for="cantidad">Stock a ajustar</label>
                <input type="number" name="cantidad" step="0.01" class="form-control" placeholder="Cantidad a ajustar..."  required="required">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Egreso </label><br>
                <input class="form-control" name="fechaalta" id="fechaingreso" type="date" required="required">
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
    
</div>
@endsection
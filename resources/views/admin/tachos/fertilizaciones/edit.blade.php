@extends('admin.layout')
@section('titulo', 'Editar fertilización de un tacho')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Fertilización de un Tacho </h3>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    {!!Form::model($Fertilizacion,['method'=>'PATCH','name'=>'ffertilizacion','route'=>['fertilizaciones.update',$Fertilizacion->idfertilizacion]])!!}

    {{Form::token()}}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="producto">Producto</label>
            <input type="text" name="producto" class="form-control" value="{{$Fertilizacion->producto}}" required="required">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" class="form-control" value="{{$Fertilizacion->cantidad}}" required="required">
        </div>
    </div> 
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Fertilización </label><br>
                <input class="form-control" name="fechafertilizacion" id="fechafertilizacion" type="date" value="{{$Fertilizacion->fechafertilizacion}}">


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control">{{$Fertilizacion->observaciones}}</textarea>
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


@endsection
@extends('admin.layout')
@section('titulo', 'Editar Evaluación Sanitaria')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Evaluación Sanitaria </h3>
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

    {!!Form::model($sanitariap,['method'=>'PATCH','name'=>'fsanitariap','route'=>['sanitariasp.update',$sanitariap->idsanitariap]])!!}
    {{Form::token()}}

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre de la evaluación</label>
                    <select name="idnombre" id="idnombre" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguna</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}" {{ $tipo->id == $sanitariap->idnombre ? 'selected="selected"' : '' }}>{{$tipo->nombre}}</option>

                        @endforeach
                    </select>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Generación </label><br>
                <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" value="{{$sanitariap->fechageneracion}}">


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control">{{$sanitariap->observaciones}}</textarea>
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
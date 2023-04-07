@extends('admin.layout')
@section('titulo', 'Editar corte de tachos')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Corte de Tachos </h3>
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

    {!!Form::model($corte,['method'=>'PATCH','name'=>'fcorte','route'=>['cortes.update',$corte->idcorte]])!!}
    {{Form::token()}}

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Corte </label><br>
                <input class="form-control" name="fechacorte" id="fechacorte" type="date" value="{{$corte->fechacorte}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="campania">Campaña</label><br>
                <select name="campania" id="campania" class="form-control" required>
                    @foreach ($campanias as $campania)
                        <option value="{{$campania->id}}" {{$campania->id == $corte->idcampania ? 'selected' : ''}}>{{$campania->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control">{{$corte->observaciones}}</textarea>
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
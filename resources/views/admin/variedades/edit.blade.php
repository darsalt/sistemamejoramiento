@extends('admin.layout')
@section('titulo', 'Editar Variedades')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Variedad: {{ $variedad->idvariedad}}</h3>
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

        {!!Form::model($variedad,['method'=>'PATCH','route'=>['variedades.update',$variedad->idvariedad]])!!}
        {{Form::token()}}


            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control"  value="{{$variedad->nombre}}">
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="madre">Madre</label>
                        <input type="text" name="madre" class="form-control" value="{{$variedad->madre}}">
                    </div>
                </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="padre">Padre</label>
                        <input type="text" name="padre" class="form-control" value="{{$variedad->padre}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tonelaje">Tonelaje</label>
                        <input type="text" name="tonelaje" class="form-control" value="{{$variedad->tonelaje}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="azucar">Azúcar</label>
                        <input type="text" name="azucar" class="form-control" value="{{$variedad->azucar}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="Floracion">Floración</label>
                        <input type="text" name="floracion" class="form-control" value="{{$variedad->floracion}}">
                    </div>
                </div>
            </div>
<!--             <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="resistencia">Resistencia a enfermedades</label>
                        <input type="number" name="resistencia" class="form-control" value="{{$variedad->resistencia}}">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="suelos">Suelos</label>
                        <input type="text" name="suelos" class="form-control" value="{{$variedad->suelos}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fibra">Fibra</label>
                        <input type="text" name="fibra" class="form-control" value="{{$variedad->fibra}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="deshojado">Deshojado</label>
                        <input type="text" name="deshojado" class="form-control" value="{{$variedad->deshojado}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vuelco">Vuelco</label>
                        <input type="text" name="vuelco" class="form-control" value="{{$variedad->vuelco}}">
                    </div>
                </div>
            </div>
            <div id="divsanitaria" style="border: solid 1px #000000;">
            <label for="resistencia">Resistencia a enfermedades</label>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="carbon">Carbón</label>
                        <input type="text" name="carbon" id="carbon" class="form-control" value="{{$variedad->carbon}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="escaladura">Escaladura</label>
                        <input type="text" name="escaladura" id="escaladura" class="form-control" value="{{$variedad->escaladura}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="estriaroja">Estria roja</label>
                        <input type="text" name="estriaroja" id="estriaroja" class="form-control" value="{{$variedad->estriroja}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="mosaico">Mosaico</label>
                        <input type="text" name="mosaico" id="mosaico" class="form-control" value="{{$variedad->mosaico}}">
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="royamarron">Roya Marrón</label>
                        <input type="text" name="royamarron" id="royamarron" class="form-control" value="{{$variedad->royamarron}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="royanaranja">Roya Naranja</label>
                        <input type="text" name="royanaranja" id="royanaranja" class="form-control" value="{{$variedad->royanaranja}}">
                    </div>
                </div>
            </div>
                        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="pokkaboeng">Pokka boeng</label>
                        <input type="text" name="pokkaboeng" id="pokkaboeng" class="form-control" value="{{$variedad->pokkaboeng}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="amarillamiento">amarillamiento</label>
                        <input type="text" name="amarillamiento" id="amarillamiento" class="form-control" value="{{$variedad->amarillamiento}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="manchaparda">Mancha parda</label>
                        <input type="text" name="manchaparda" id="manchaparda" class="form-control" value="{{$variedad->manchaparda}}">
                    </div>
                </div>
            </div>      
        </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="date">Fecha Alta</label><br>
                        <input class="form-control" name="fechaalta" id="fechaalta" type="date" value="{{$variedad->fechaalta}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control" >{{$variedad->observaciones}}</textarea>
                    </div>
                </div>
            </div>
        <!--         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    	<label for="estado">Estado</label>
                    	<input type="text" name="estado" class="form-control" value="{{$variedad->estado}}" >
                    </div>
                </div> -->
            <div class="row">
                <div class="form-group">
                   	<button class="btn btn-primary" type="submit">Guardar</button>
                   	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                </div>
            </div>

			{!!Form::close()!!}		
            
    </div>
@endsection
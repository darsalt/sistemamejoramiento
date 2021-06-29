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

    {!!Form::model($sanitaria,['method'=>'PATCH','name'=>'fsanitaria','route'=>['sanitarias.update',$sanitaria->idsanitaria]])!!}
    {{Form::token()}}

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre del Banco</label>
                <select name="idbanco" id="idbanco" class="form-control">
                 <option value="{{$sanitaria->idbanco}}" >{{$sanitaria->nombrebanco}}</option>
              </select>
         </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre de la evaluación</label>
                    <select name="idnombre" id="idnombre" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguna</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}" {{ $tipo->id == $sanitaria->idnombre ? 'selected="selected"' : '' }}>{{$tipo->nombre}}</option>

                        @endforeach
                    </select>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha Generación </label><br>
                <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" value="{{$sanitaria->fechageneracion}}">


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control">{{$sanitaria->observaciones}}</textarea>
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

<script>
function validarFormulario(){
    var ok = true;
    //valido el nombre
    if (document.fbanco.anio.value.length==0){
            alert("Tiene que escribir el año")
            document.fbanco.anio.focus()
            return 0;
    }

    if (document.fbanco.tablas.value < document.fbanco.tablasant.value){
            alert("No puede ingresar un valor de Tablas menor al anterior")
            document.fbanco.tablas.value = document.fbanco.tablasant.value
            document.fbanco.tablas.focus()
            return 0;
    }

    if (document.fbanco.tablitas.value < document.fbanco.tablitasant.value){
            alert("No puede ingresar un valor de Tablitas menor al anterior")
            document.fbanco.tablitas.value = document.fbanco.tablitasant.value
            document.fbanco.tablitas.focus()
            return 0;
    }
    
    //el formulario se envia
    document.fbanco.submit(); 
}
</script>
@endsection
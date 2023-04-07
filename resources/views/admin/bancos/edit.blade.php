@extends('admin.layout')
@section('titulo', 'Editar Banco')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Banco: {{ $banco->idbanco}}</h3>
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

        {!!Form::model($banco,['method'=>'PATCH','name'=>'fbanco','route'=>['bancos.update',$banco->idbanco]])!!}
        {{Form::token()}}


            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control"  value="{{$banco->nombre}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <input type="text" name="anio" class="form-control"  value="{{$banco->anio}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="date">Fecha Generación</label><br>
                        <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" value="{{$banco->fechageneracion}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tablas">Tablas</label>
                        <input type="number" min="1" name="tablas" class="form-control" value="{{$banco->tablas}}">
                        <input id="tablasant" name="tablasant" type="hidden" value="{{$banco->tablas}}"/>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tablitas">Tablitas</label>
                        <input type="number" min="1" name="tablitas" class="form-control" value="{{$banco->tablitas}}">
                        <input id="tablitasant" name="tablitasant" type="hidden" value="{{$banco->tablitas}}"/>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="surcos">Surcos</label>
                        <input type="number" min="1" name="surcos" class="form-control" value="{{$banco->surcos}}" readonly="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control" >{{$banco->observaciones}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <input class="btn btn-primary" type="button" value="Guardar" onclick="validarFormulario()">

                   	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
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
@extends('admin.layout')
@section('titulo', 'Registrar inspección')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva inspección</h3>
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

    <section class="content">
        <form action="{{route('importaciones.inspecciones.store')}}" id="formInspeccion" method='POST' enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fecha">Fecha inspeccion</label>
                        <input type="date" class="form-control" name="fecha" id="fecha" required>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="campania">Campaña</label>
                        <select name="campania" id="campania" class="form-control" required>
                            <option value="" disabled selected>(Ninguna)</option>
                            @foreach ($campanias as $campania)
                                <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="box">Boxes</label>
                        <select name="box" id="box" class="form-control" required>
                            <option value="0" disabled selected>(Ninguno)</option>
                            @foreach ($boxes as $box)
                                <option value="{{$box->id}}">{{$box->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="certificado">Certificado</label>
                        <input type="file" name="certificado" id="certificado" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea  maxlength="1000" name="observaciones" class="form-control" placeholder="Ingrese observaciones"></textarea>
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" id="submit">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
@section('script')
<script>  

</script>
@endsection
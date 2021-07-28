@extends('admin.layout')
@section('titulo', 'Incluir PG')
@section('content')
<div class="container">
	{!!Form::open(array('url'=>'campaniasemillado/pg','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="campaniasemillado">Campania de Semillado</label>
                    <select name="idcampaniasemillado" id="idcampaniasemillado" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguno</option>
                        @foreach ($campaniasemillado as $campaniasemillado)
                            <option value="{{$campaniasemillado->idcampaniasemillado}}">
                                {{$campaniasemillado->nombrecampaniasemillado }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                  <label for="campaniacruzamiento">Campania de Cruzamiento</label>
                    <select name="idcampaniacruzamiento" id="idcampaniacruzamiento" class="select2" style="width: 100%;" class="form-control" required>
                        <option value="0">Ninguno</option>
                        @foreach ($campaniacruzamiento as $campaniacruzamiento)
                            <option value="{{$campaniacruzamiento->idcampaniacruzamiento}}">
                                {{$campaniacruzamiento->nombrecampaniacruzamiento }}
                            </option>
                        @endforeach
                    </select>
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
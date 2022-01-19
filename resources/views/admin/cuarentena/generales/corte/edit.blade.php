@extends('admin.layout')
@section('titulo', 'Editar corte')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Editar Corte</h3>
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

    <form action="{{route('cuarentena.generales.corte.update', $corte->id)}}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="fecha">Fecha</label><br>
                    <input class="form-control" name="fecha" id="fecha" type="date" required="required" value="{{old('fecha', $corte->fecha)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="fecha">Campaña</label><br>
                    <select name="campania" id="campania" class="form-control">
                        @foreach ($campanias as $campania)
                            @if ($campania->id == $corte->idcampania)
                                <option value="{{$campania->id}}" selected>{{$campania->nombre}}</option>
                            @else
                                <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea  maxlength="1000" name="observaciones" id="observaciones" class="form-control" placeholder="Ingrese observaciones">{{old('observaciones', $corte->observaciones)}}</textarea>
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

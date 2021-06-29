@extends('admin.layout')
@section('titulo', 'Editar Nivel')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{route('niveles.update', [$nivel])}}">
                @method("PUT")
                @csrf
                <div class="form-group">
                    <label class="label">Nombre</label>
                    <input required value="{{$nivel->nombre}}" autocomplete="off" name="nombre" class="form-control"
                           type="text" placeholder="Nombre">
                </div>

                @include("admin/notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route('niveles.index')}}">Volver</a>
            </form>
        </div>
    </div>
@endsection
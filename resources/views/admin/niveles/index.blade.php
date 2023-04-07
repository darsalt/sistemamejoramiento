@extends('admin.layout')
@section('titulo', 'Niveles')
@section('content')
<div class="row">
        <div class="col-12">
            <a href="{{route('niveles.create')}}" class="btn btn-success mb-2">Agregar</a>
            @include("admin/notificacion")
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre</th>

                    <th>Editar</th>
                    <th>Eliminar</th></tr>
                </thead>
                <tbody>
                @foreach($niveles as $nivel)
                    <tr>
                        <td>{{$nivel->nombre}}</td>
                        <td>
                            <a class="btn btn-warning" href="{{route('niveles.edit',[$nivel])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{route('niveles.destroy', [$nivel])}}" method="post">
                                @method("delete")
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @endsection
@extends('admin.layout')
@section('titulo', 'Usuarios')
@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de usuarios <a href="{{ route('admin.users.create') }}">&nbsp;
                    <button class="btn btn-success">Nuevo</button></a></h3>
            @include('admin.users.search')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Nombre</th>
                        <th>E-mail</th>
                        <th>Ambiente</th>
                        <th>Administrador</th>
                        <th>Operaciones</th>
                    </thead>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->ambiente ? $usuario->ambiente->nombre : 'Sin Ambiente' }}</td>
                            <td>{{ $usuario->esAdmin ? 'Si' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $usuario) }}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $usuarios->render() }}
        </div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Operación exitosa',
                    text: "{{ session('success') }}",
                    icon: 'success',
                });
            });
        </script>
    @endif
@endsection

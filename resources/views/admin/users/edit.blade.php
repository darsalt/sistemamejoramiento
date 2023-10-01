@extends('admin.layout')
@section('titulo', 'Editar usuario')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar usuario</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email) }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ambiente" class="col-md-4 col-form-label text-md-right">Ambiente</label>

                                <div class="col-md-6">
                                    <select id="ambiente" class="form-control @error('ambiente') is-invalid @enderror" name="ambiente" required>
                                        <option value="">Seleccione ambiente</option>
                                        @foreach ($ambientes as $ambiente)
                                            <option value="{{ $ambiente->id }}" {{ old('ambiente', $user->idambiente) == $ambiente->id ? 'selected="selected"' : ''}}>{{ $ambiente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="administrador" class="col-md-4 col-form-label text-md-right">Es administrador</label>

                                <div class="col-md-6 d-flex align-items-center">
                                    <input id="administrador" name="administrador" class="" type="checkbox" {{ old('administrador', $user->esAdmin) ? 'checked' : ''}}>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 text-left">
                                    <button type="button" onclick="window.history.back();" class="btn btn-danger">
                                        Volver
                                    </button>
                                </div>

                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Confirmar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

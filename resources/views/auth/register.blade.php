@extends('admin.layout')
@section('titulo', 'Registrar usuario')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar usuario</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.register.register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Repetir
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ambiente" class="col-md-4 col-form-label text-md-right">Ambiente</label>

                                <div class="col-md-6">
                                    <select id="ambiente" class="form-control" name="ambiente" required>
                                        <option value="">Seleccione ambiente</option>
                                        @foreach ($ambientes as $ambiente)
                                            <option value="{{ $ambiente->id }}" {{ old('ambiente') == $ambiente->id ? 'selected="selected"' : ''}}>{{ $ambiente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="administrador" class="col-md-4 col-form-label text-md-right">Es
                                    administrador</label>

                                <div class="col-md-6 d-flex align-items-center">
                                    <input id="administrador" name="administrador" class="" type="checkbox" {{ old('administrador') ? 'checked' : ''}}>
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

@extends('admin.layout')
@section('titulo', 'Cambiar contraseña')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cambiar contraseña</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.password.change.update') }}">
                            @method('PATCH')
                            @csrf

                            <div class="form-group row">
                                <label for="oldpassword" class="col-md-4 col-form-label text-md-right">Contraseña actual</label>

                                <div class="col-md-6">
                                    <input id="oldpassword" type="password"
                                        class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword"
                                        required>

                                    @error('oldpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="newpassword" class="col-md-4 col-form-label text-md-right">Nueva
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="newpassword" type="password"
                                        class="form-control @error('newpassword') is-invalid @enderror" name="newpassword"
                                        required>

                                    @error('newpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="newpassword_confirmation" class="col-md-4 col-form-label text-md-right">Repita nueva
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="newpassword_confirmation" type="password"
                                        class="form-control @error('newpassword_confirmation') is-invalid @enderror"
                                        name="newpassword_confirmation" required>

                                    @error('newpassword_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

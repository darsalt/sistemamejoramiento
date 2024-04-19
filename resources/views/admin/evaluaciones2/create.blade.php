@extends('admin.layout')
@section('titulo')
    @if ($origen == 'pc')
        Primera clonal -
    @else
        @if ($origen == 'sc')
            Segunda clonal -
        @else
            MET -
        @endif
    @endif

    @if ($tipo == 'C')
        Nueva evaluacion campo-sanidad
    @else
        Nueva evaluacion laboratorio
    @endif
@endsection

<!--Array de meses-->
@php
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                    @if ($origen == 'pc')
                        Primera clonal -
                    @else
                        @if ($origen == 'sc')
                            Segunda clonal -
                        @else
                            MET -
                        @endif
                    @endif

                    @if ($tipo == 'C')
                        Nueva evaluacion campo-sanidad
                    @else
                        Nueva evaluacion laboratorio
                    @endif
                </h3>
            </div>
        </div>

        <form action="{{ route('admin.evaluaciones.store', ['tipo' => $tipo, 'origen' => $origen]) }}" class="form" id="form" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select name="anio" id="anio" class="form-control @error('anio') is-invalid @enderror">
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @for ($i = date('Y') - 1; $i >= 2000; $i--)
                                <option value="{{ $i }}" {{ old('anio') == $i ? 'selected="selected"' : ''}}>{{ $i }}</option>
                            @endfor
                        </select>

                        @error('anio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="serie">Serie</label>
                        <select name="serie" id="serie" class="form-control @error('serie') is-invalid @enderror">
                            <option value="0" disabled selected>(Seleccionar)</option>
                            @foreach ($series as $serie)
                                <option value="{{ $serie->id }}" {{ old('serie') == $serie->id ? 'selected="selected"' : ''}}>{{ $serie->nombre }}</option>
                            @endforeach
                        </select>

                        @error('serie')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="ambiente">Ambiente</label>
                        <select name="ambiente" id="ambiente" class="form-control @error('ambiente') is-invalid @enderror">
                            <option value="0" disabled selected>(Seleccionar)</option>
                            @foreach ($ambientes as $ambiente)
                                <option value="{{ $ambiente->id }}" {{ old('ambiente') == $ambiente->id ? 'selected="selected"' : ''}}>{{ $ambiente->nombre }}</option>
                            @endforeach
                        </select>

                        @error('ambiente')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="subambiente">Subambiente</label>
                        <select name="subambiente" id="subambiente" class="form-control @error('subambiente') is-invalid @enderror">
                            <option value="0" disabled selected>(Seleccionar)</option>
                        </select>

                        @error('subambiente')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        <select name="sector" id="sector" class="form-control @error('sector') is-invalid @enderror">
                            <option value="0" disabled selected>(Seleccionar)</option>
                        </select>

                        @error('sector')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}">
                        
                        @error('fecha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <select name="mes" id="mes" class="form-control @error('mes') is-invalid @enderror">
                            <option value="0" selected disabled>(Seleccionar)</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('mes') == $i ? 'selected="selected"' : ''}}>{{ $meses[$i] }}</option>
                            @endfor
                        </select>

                        @error('mes')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="edad">Edad</label>
                        <select name="edad" id="edad" class="form-control @error('edad') is-invalid @enderror">
                            <option value="0" selected disabled>(Seleccionar)</option>
                            @foreach ($edades as $edad)
                                <option value="{{ $edad->id }}" {{ old('edad') == $edad->id ? 'selected="selected"' : ''}}>{{ $edad->nombre }}</option>
                            @endforeach
                        </select>

                        @error('edad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                    </div>
                </div>
            </div>
            <form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var texto_item_vacio = '(Seleccionar)';
        var disabled = 'disabled';
    </script>

    @include('partials.ajax_subambientes_sectores')

    <script type="text/javascript">
        // Si volvi a cargar la pantalla por un error cargo los datos de subambiente y sector que ya se habian seleccionado
        if({{ old('ambiente') > 0 }}){
            $('#ambiente').trigger('change', [{{ old('subambiente') }}, {{ old('sector') }}]);
        }
    </script>
@endsection

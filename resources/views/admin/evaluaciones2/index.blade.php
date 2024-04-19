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
        Evaluaciones campo-sanidad
    @else
        Evaluaciones laboratorio
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3 class="d-inline-block">
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
                    Evaluaciones campo-sanidad
                @else
                    Evaluaciones laboratorio
                @endif
            </h3>

            <a href="{{ route('admin.evaluaciones.create', ['origen' => $origen, 'tipo' => $tipo]) }}" class="btn btn-success ml-3">Nueva</a>
        </div>
    </div>

    <!--Array de meses-->
    @php
        $meses = [
            '',
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];
    @endphp

    <hr>

    <form action="{{ url()->current() }}" method="GET" class="form" id="formSearch">
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    <label for="anio">Año:</label>
                    <select name="anio" id="anio" class="form-control">
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        @for ($i = date('Y') - 1; $i >= 2000; $i--)
                            <option value="{{ $i }}" @if (request()->get('anio') == $i) selected @endif>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="serie">Serie:</label>
                    <select name="serie" id="serie" class="form-control">
                        <option value="0" selected>(Todas)</option>
                        @foreach ($series as $serie)
                            <option value="{{ $serie->id }}" @if (request()->get('serie') == $serie->id) selected @endif>
                                {{ $serie->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="ambiente">Ambiente:</label>
                    <select name="ambiente" id="ambiente" class="form-control">
                        <option value="0" selected>(Todos)</option>
                        @foreach ($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}" @if (request()->get('ambiente') == $ambiente->id) selected @endif>
                                {{ $ambiente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="subambiente">Subambiente:</label>
                    <select name="subambiente" id="subambiente" class="form-control">
                        <option value="0" selected>(Todos)</option>
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="sector">Sector:</label>
                    <select name="sector" id="sector" class="form-control">
                        <option value="0" selected>(Todos)</option>
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control"
                        value={{ request()->get('fecha') }}>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="mes">Mes:</label>
                    <select name="mes" id="mes" class="form-control">
                        <option value="0" selected>(Todos)</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @if (request()->get('mes') == $i) selected @endif>
                                {{ $meses[$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="edad">Edad:</label>
                    <select name="edad" id="edad" class="form-control">
                        <option value="0" selected>(Todos)</option>
                        @foreach ($edades as $edad)
                            <option value="{{ $edad->id }}" @if (request()->get('edad') == $edad->id) selected @endif>
                                {{ $edad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-auto align-self-center">
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Año</th>
                        <th>Serie</th>
                        <th>Ambiente</th>
                        <th>Subambiente</th>
                        <th>Sector</th>
                        <th>Mes</th>
                        <th>Edad</th>
                        <th>Clones evaluados</th>
                        <th></th>
                    </thead>
                    @foreach ($evaluaciones as $evaluacion)
                        <tr>
                            <td>{{ $evaluacion->anio }}</td>
                            <td>{{ $evaluacion->serie->nombre }}</td>
                            <td>{{ $evaluacion->sector->subambiente->ambiente->nombre }}</td>
                            <td>{{ $evaluacion->sector->subambiente->nombre }}</td>
                            <td>{{ $evaluacion->sector->nombre }}</td>
                            <td>{{ $meses[$evaluacion->mes] }}</td>
                            <td>{{ $evaluacion->edad->nombre }}</td>
                            <td>{{ $evaluacion->cant_clones_evaluados }}</td>
                            <td>
                                @if($origen == 'pc')
                                    @if($tipo == 'C')
                                        <a href="{{ route('primeraclonal.evaluaciones.camposanidad.view', $evaluacion) }}">
                                    @else
                                        <a href="{{ route('primeraclonal.evaluaciones.laboratorio.view', $evaluacion) }}">
                                    @endif
                                @endif

                                @if($origen == 'sc')
                                    @if($tipo == 'C')
                                        <a href="{{ route('segundaclonal.evaluaciones.camposanidad.view', $evaluacion) }}">
                                    @else
                                        <a href="{{ route('segundaclonal.evaluaciones.laboratorio.view', $evaluacion) }}">
                                    @endif
                                @endif

                                @if($origen == 'met')
                                    @if($tipo == 'C')
                                        <a href="{{ route('met.evaluaciones.camposanidad.view', $evaluacion) }}">
                                    @else
                                        <a href="{{ route('met.evaluaciones.laboratorio.view', $evaluacion) }}">
                                    @endif
                                @endif
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var texto_item_vacio = '(Todos)';
        var disabled = '';
    </script>

    @include('partials.ajax_subambientes_sectores')

    <script type="text/javascript">
        $('#ambiente').trigger('change', [{{ request()->get('subambiente') }}, {{ request()->get('sector') }}]);
    </script>

    {{-- Sweet alert para cuando vuelvo de crear una evaluación nueva --}}
    @if(session('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                Swal.fire({
                    title: 'Operación exitosa',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection

@extends('admin.layout')
@section('titulo', 'Evaluaciones Laboratorio PC')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    @php
        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    @endphp

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Evaluaciones Laboratorio</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!--Muestra de errrores-->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!--Mensajes que se muestran con jQuery-->
            <div class="text-center" id="messages">
                <p class='text-success' id='msgExito' style='display: none;'>Operación exitosa &nbsp;<i
                        class='fas fa-sm fa-check-circle'></i></p>
                <p class='text-danger' id='msgError' style='display: none;'>Error en la operación &nbsp;<i
                        class='fas fa-sm fa-times-circle'></i></p>
            </div>
        </div>
    </div>

    <form action="" class="form" id="formSeedling" operation="insert">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <!--Tabla con el formulario para el registro de la etapa individual-->
                    <input type="number" hidden value=0 id="idSeedling" name="idSeedling">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">Año</th>
                                <th>Serie</th>
                                <th>Ambiente</th>
                                <th>Subambiente</th>
                                <th>Sector</th>
                                <th>Fecha</th>
                                <th>Mes</th>
                                <th>Edad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="display: none;">
                                    <select name="anio" id="anio" class="form-control">
                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                        @for ($i = date('Y') - 1; $i >= 2000; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select name="serie" id="serie" class="form-control">
                                        <option value="0" disabled selected>(Ninguna)</option>
                                        @foreach ($series as $serie)
                                            <option value="{{ $serie->id }}">{{ $serie->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="ambiente" id="ambiente" class="form-control">
                                        <option value="0" disabled selected>(Ninguno)</option>
                                        @foreach ($ambientes as $ambiente)
                                            <option value="{{ $ambiente->id }}">{{ $ambiente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="subambiente" id="subambiente" class="form-control">
                                        <option value="0" disabled selected>(Ninguno)</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="sector" id="sector" class="form-control">
                                        <option value="0" disabled selected>(Ninguno)</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="date" id="fecha" name="fecha" class="form-control"
                                        value={{ $fecha_calendario }}>
                                </td>
                                <td>
                                    <select name="mes" id="mes" class="form-control">
                                        <option value="0" selected disabled>(Ninguno)</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $meses[$i] }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select name="edad" id="edad" class="form-control">
                                        <option value="0" selected disabled>(Ninguna)</option>
                                        @foreach ($edades as $edad)
                                            <option value="{{ $edad->id }}">{{ $edad->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success" id="buscar"><i
                                            class="fas fa-search"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row justify-content-end py-2">
            <div class="col-auto">
                <label for="cant_registros">Cantidad de registros</label>
            </div>

            <div class="col-auto">
                <select name="cant_registros" id="cant_registros" class="form-control">
                    <option value="10" {{ $cantRegistros == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $cantRegistros == '20' ? 'selected' : '' }}>20</option>
                    <option value="30" {{ $cantRegistros == '30' ? 'selected' : '' }}>30</option>
                    <option value="100" {{ $cantRegistros == '100' ? 'selected' : '' }}>100</option>
                    <option value="200" {{ $cantRegistros == '200' ? 'selected' : '' }}>200</option>
                </select>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-12 table-responsive">
            <!--Tabla con los datos segun la campaña seleccionada-->
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaSeedlings">
                <thead>
                    <tr>
                        <th width="3%">Parcela</th>
                        <th width="8%">Clon</th>
                        <th width="7%">Peso muestra</th>
                        <th width="7%">Peso jugo</th>
                        <th width="7%">Brix</th>
                        <th width="7%">Polarización</th>
                        <th width="7%">Temperatura</th>
                        <th width="7%">Conductvidad</th>
                        <th width="7%">Brix corregido</th>
                        <th width="7%">Pol en jugo</th>
                        <th width="7%">Pureza</th>
                        <th width="7%">Rend. prob.</th>
                        <th width="7%">Pol en caña</th>
                    </tr>
                <tbody>
                    @foreach ($seedlings as $seedling)
                        <tr>
                            <td>
                                <input type="number" disabled hidden value="{{ $seedling->id }}" class="idSeedling">
                                @if ($origen == 'pc')
                                    {{ $seedling->primera->testigo ? $seedling->parcela : (int) $seedling->parcela }}
                                @else
                                    {{ (int) $seedling->parcela }}
                                @endif
                            </td>
                            <td>
                                @if ($origen == 'pc')
                                    {{ $seedling->nombre_clon }}
                                @else
                                    @if ($origen == 'sc')
                                        {{-- @if ($seedling->parcelaPC->primera->idseedling == null)
                                            <span class="text-warning"><i class="fas fa-exclamation-triangle" title="Este clon proviene de una importación"></i></span>
                                        @endif
 --}}
                                        {{ $seedling->testigo ? $seedling->variedad->nombre : $seedling->parcelaPC->nombre_clon }}
                                    @else
                                        {{ $seedling->idsegundaclonal_detalle ? (!$seedling->parcelaSC->testigo ? $seedling->parcelaSC->parcelaPC->nombre_clon : $seedling->parcelaSC->variedad->nombre) : $seedling->variedad->nombre }}
                                    @endif
                                @endif
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado"
                                    id="{{ 'pesomuestra-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->peso_muestra : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado"
                                    id="{{ 'pesojugo-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->peso_jugo : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado"
                                    id="{{ 'brix-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado"
                                    id="{{ 'polarizacion-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->polarizacion : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado"
                                    id="{{ 'temperatura-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->temperatura : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td class="sinPaddingCentrado"><input type="number"
                                    class="form-control sinPaddingCentrado ultimoCampo"
                                    id="{{ 'conductividad-' . $seedling->id }}"
                                    value="{{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->conductividad : '' }}"
                                    {{ auth()->user()->idambiente != $idAmbiente && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                            </td>
                            <td>
                                <p id={{ 'brixcorregido-' . $seedling->id }}>
                                    {{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix_corregido : '' }}
                                </p>
                            </td>
                            <td>
                                <p id={{ 'polenjugo-' . $seedling->id }}>
                                    {{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pol_jugo : '' }}
                                </p>
                            </td>
                            <td>
                                <p id={{ 'pureza-' . $seedling->id }}>
                                    {{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pureza : '' }}
                                </p>
                            </td>
                            <td>
                                <p id={{ 'rendimiento-' . $seedling->id }}>
                                    {{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->rend_prob : '' }}
                                </p>
                            </td>
                            <td>
                                <p id={{ 'polencania-' . $seedling->id }}>
                                    {{ ($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pol_cania : '' }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ $seedlings->appends(request()->query())->links() }}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/validaciones/initValidation.js') }}"></script>
    <script>
        var config = {
            routes: {
                evaluacionesPC: "{{ route('primeraclonal.evaluaciones.laboratorio') }}",
                evaluacionesSC: "{{ route('segundaclonal.evaluaciones.laboratorio') }}",
                evaluacionesMET: "{{ route('met.evaluaciones.laboratorio') }}",
                getSubambientes: "{{ route('ajax.subambientes.getSubambientesDadoAmbiente') }}",
                getSectores: "{{ route('ajax.sectores.getSectoresDadoSubambiente') }}",
                saveEvaluacionPC: "{{ route('ajax.primeraclonal.evaluaciones.saveEvLaboratorio') }}",
                saveEvaluacionSC: "{{ route('ajax.segundaclonal.evaluaciones.saveEvLaboratorio') }}",
                saveEvaluacionMET: "{{ route('ajax.met.evaluaciones.saveEvLaboratorio') }}",
            },
            data: {
                anioActivo: "{{ $anio }}",
                ambienteActivo: "{{ $idAmbiente }}",
                subambienteActivo: "{{ $idSubambiente }}",
                sectorActivo: "{{ $idSector }}",
                serieActiva: "{{ $idSerie }}",
                mesActivo: "{{ $mes }}",
                edadActiva: "{{ $edad2 }}",
                origen: "{{ $origen }}"
            },
            session: {
                exito: "{{ session()->pull('exito') }}",
                error: "{{ session()->pull('error') }}"
            }
        };
        console.log("{{ $idAmbiente }}"),
            console.log("{{ auth()->user()->name }}")
    </script>

    <script src="{{ asset('js/primera/evaluaciones/laboratorio.js') }}"></script>
@endsection

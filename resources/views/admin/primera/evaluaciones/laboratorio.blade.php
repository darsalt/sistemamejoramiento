@extends('admin.layout')
@section('titulo', 'Evaluaciones laboratorio')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    @php
        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    @endphp

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>
                Evaluaciones laboratorio
                @if ($origen == 'pc')
                    - Primera Clonal
                @else
                    @if ($origen == 'sc')
                        - Segunda Clonal
                    @else
                        - MET
                    @endif
                @endif
            </h3>
            <h4>
                <strong>Año:</strong> {{ $evaluacion->anio }}, <strong>Serie:</strong> {{ $evaluacion->serie->nombre }}, <strong>Ambiente:</strong>
                {{ $evaluacion->sector->subambiente->ambiente->nombre }}, <strong>Subambiente:</strong> {{ $evaluacion->sector->subambiente->nombre }}, <strong>Sector:</strong>
                {{ $evaluacion->sector->nombre }},
                <strong>Mes:</strong> {{ $meses[$evaluacion->mes] }}, <strong>Edad:</strong> {{ $evaluacion->edad->nombre }}
            </h4>
        </div>
    </div>

    <form action="{{ url()->current() }}" class="form" id="formSearch" method="GET">
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
                        <th width="7%">Fibra</th>
                        <th width="7%">Brix corregido</th>
                        <th width="7%">Pol en jugo</th>
                        <th width="7%">Pureza</th>
                        <th width="7%">Rend. prob.</th>
                        <th width="7%">Pol en caña</th>
                    </tr>
                <tbody>
                    @if ($seedlings->count() == 0)
                        <tr>
                            <td colspan="15" class="text-center"><i>No hay clones para evaluar</i></td>
                        </tr>
                    @else
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
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'pesomuestra-' . $seedling->id }}"
                                        value="{{ $seedling->peso_muestra }}" {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'pesojugo-' . $seedling->id }}" value="{{ $seedling->peso_jugo }}"
                                        {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'brix-' . $seedling->id }}" value="{{ $seedling->brix }}"
                                        {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'polarizacion-' . $seedling->id }}"
                                        value="{{ $seedling->polarizacion }}" {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'temperatura-' . $seedling->id }}"
                                        value="{{ $seedling->temperatura }}" {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado ultimoCampo" id="{{ 'fibra-' . $seedling->id }}"
                                        value="{{ $seedling->fibra }}" {{ $seedling->readonly ? 'readonly' : '' }}>
                                </td>
                                <td>
                                    <p id={{ 'brixcorregido-' . $seedling->id }}>
                                        {{ $seedling->brix_corregido }}
                                    </p>
                                </td>
                                <td>
                                    <p id={{ 'polenjugo-' . $seedling->id }}>
                                        {{ $seedling->pol_jugo }}
                                    </p>
                                </td>
                                <td>
                                    <p id={{ 'pureza-' . $seedling->id }}>
                                        {{ $seedling->pureza }}
                                    </p>
                                </td>
                                <td>
                                    <p id={{ 'rendimiento-' . $seedling->id }}>
                                        {{ $seedling->rend_prob }}
                                    </p>
                                </td>
                                <td>
                                    <p id={{ 'polencania-' . $seedling->id }}>
                                        {{ $seedling->pol_cania }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
                getSubambientes: "{{ route('ajax.subambientes.getSubambientesDadoAmbiente') }}",
                getSectores: "{{ route('ajax.sectores.getSectoresDadoSubambiente') }}",
                saveEvaluacionPC: "{{ route('ajax.primeraclonal.evaluaciones.saveEvLaboratorio') }}",
                saveEvaluacionSC: "{{ route('ajax.segundaclonal.evaluaciones.saveEvLaboratorio') }}",
                saveEvaluacionMET: "{{ route('ajax.met.evaluaciones.saveEvLaboratorio') }}",
            },
            data: {
                evaluacion: {!! json_encode($evaluacion) !!},
                origen: "{{ $origen }}"
            },
            session: {
                exito: "{{ session()->pull('exito') }}",
                error: "{{ session()->pull('error') }}"
            }
        };
    </script>

    <script src="{{ asset('js/primera/evaluaciones/laboratorio.js') }}"></script>
@endsection

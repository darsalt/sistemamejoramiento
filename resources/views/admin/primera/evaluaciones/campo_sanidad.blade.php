@extends('admin.layout')
@section('titulo', 'Evaluaciones campo-sanidad')

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
                Evaluaciones campo-sanidad
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
                        <th width="3%">Par- cela</th>
                        <th width="6%">Clon</th>
                        <th width="7%">Tipo</th>
                        <th width="7%">Tallos</th>
                        <th width="7%">Altura</th>
                        <th width="7%">Grosor</th>
                        <th width="7%">Vuelco</th>
                        <th width="7%">Flor</th>
                        <th width="7%">Brix en campo</th>
                        <th width="7%">Escaldad</th>
                        <th width="7%">Carbón</th>
                        <th width="7%">Roya</th>
                        <th width="7%">Mosaico</th>
                        <th width="7%">Estaria</th>
                        <th width="7%">Amarilla</th>
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
                                        @endif --}}

                                            {{ $seedling->testigo ? $seedling->variedad->nombre : $seedling->parcelaPC->nombre_clon }}
                                        @else
                                            {{ $seedling->idsegundaclonal_detalle ? (!$seedling->parcelaSC->testigo ? $seedling->parcelaSC->parcelaPC->nombre_clon : $seedling->parcelaSC->variedad->nombre) : $seedling->variedad->nombre }}
                                        @endif
                                    @endif
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'tipo-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->tipo: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'tallos-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->tallos: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'altura-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->altura: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'grosor-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->grosor: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'vuelco-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->vuelco: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'flor-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->flor: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'brix-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->brix: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'escaldad-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->escaldad: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'carbon-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->carbon: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'roya-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->roya: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'mosaico-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->mosaico: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{ 'estaria-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->estaria: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
                                </td>
                                <td class="sinPaddingCentrado"><input type="number" class="form-control ultimoCampo sinPaddingCentrado" id="{{ 'amarilla-' . $seedling->id }}"
                                        value="{{ ($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first())? $ev->amarilla: '' }}"
                                        {{ auth()->user()->idambiente != $evaluacion->sector->subambiente->ambiente->id && auth()->user()->esAdmin != 1 ? 'readonly' : '' }}>
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
                saveEvaluacionPC: "{{ route('ajax.primeraclonal.evaluaciones.saveEvCampoSanidad') }}",
                saveEvaluacionSC: "{{ route('ajax.segundaclonal.evaluaciones.saveEvCampoSanidad') }}",
                saveEvaluacionMET: "{{ route('ajax.met.evaluaciones.saveEvCampoSanidad') }}",
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

    <script src="{{ asset('js/primera/evaluaciones/campo_sanidad.js') }}"></script>
@endsection

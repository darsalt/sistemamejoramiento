@extends('admin.layout')
@section('titulo', 'Evaluaciones Campo-Sanidad PC')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
@php
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Evaluaciones Campo-Sanidad</h3> 
	</div>
</div>

<div class="row">
    <div class="col-12">
        <!--Muestra de errrores-->
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            </ul>
        </div>
        @endif

        <!--Mensajes que se muestran con jQuery-->
        <div class="text-center" id="messages">
            <p class='text-success' id='msgExito' style='display: none;'>Operación exitosa &nbsp;<i class='fas fa-sm fa-check-circle'></i></p>
            <p class='text-danger' id='msgError' style='display: none;'>Error en la operación &nbsp;<i class='fas fa-sm fa-times-circle'></i></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <!--Tabla con el formulario para el registro de la etapa individual-->
            <form action="" class="form" id="formSeedling" operation="insert">
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
                                    <option value="{{date('Y')}}">{{date('Y')}}</option>
                                    @for ($i = date('Y')-1; $i >= 2000; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>
                                <select name="serie" id="serie" class="form-control">
                                    <option value="0" disabled selected>(Ninguna)</option>
                                    @foreach ($series as $serie)
                                        <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="ambiente" id="ambiente" class="form-control">
                                    <option value="0" disabled selected>(Ninguno)</option>
                                    @foreach ($ambientes as $ambiente)
                                        <option value="{{$ambiente->id}}">{{$ambiente->nombre}}</option>
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
                                <input type="date" id="fecha" name="fecha" class="form-control" value={{$fecha_calendario}}>
                            </td>
                            <td>
                                <select name="mes" id="mes" class="form-control">
                                    <option value="0" selected disabled>(Ninguno)</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{$i}}">{{$meses[$i]}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>
                                <select name="edad" id="edad" class="form-control">
                                    <option value="0" selected disabled>(Ninguna)</option>
                                    @foreach ($edades as $edad)
                                        <option value="{{$edad->id}}">{{$edad->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success" id="buscar"><i class="fas fa-search"></i></button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

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
                    @foreach ($seedlings as $seedling)
                        <tr>
                            <td>
                                <input type="number" disabled hidden value="{{$seedling->id}}" class="idSeedling">
                                @if ($origen == 'pc')
                                    {{$seedling->primera->testigo ? $seedling->parcela : (int)$seedling->parcela}}    
                                @else
                                    {{(int)$seedling->parcela}}
                                @endif     
                            </td>
                            <td>
                                @if ($origen == 'pc')
                                    {{$seedling->nombre_clon}}
                                @else
                                    @if ($origen == 'sc')
                                        {{-- @if ($seedling->parcelaPC->primera->idseedling == NULL)
                                            <span class="text-warning"><i class="fas fa-exclamation-triangle" title="Este clon proviene de una importación"></i></span>
                                        @endif --}}
                                        
                                        {{$seedling->testigo ? $seedling->variedad->nombre : $seedling->parcelaPC->nombre_clon}}
                                    @else
                                        {{$seedling->idsegundaclonal_detalle ? (!$seedling->parcelaSC->testigo ? $seedling->parcelaSC->parcelaPC->nombre_clon : $seedling->parcelaSC->variedad->nombre) : $seedling->variedad->nombre}}
                                    @endif
                                @endif  
                            </td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'tipo-' . $seedling->id}}" 
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->tipo : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'tallos-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->tallos : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'altura-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->altura : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'grosor-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->grosor : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'vuelco-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->vuelco : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'flor-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->flor : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'brix-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'escaldad-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->escaldad : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'carbon-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->carbon : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'roya-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->roya : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'mosaico-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->mosaico : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control sinPaddingCentrado" id="{{'estaria-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->estaria : ''}}"></td>
                            <td class="sinPaddingCentrado"><input type="number" class="form-control ultimoCampo sinPaddingCentrado" id="{{'amarilla-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->amarilla : ''}}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script>
        var config = {
            routes: {
                evaluacionesPC: "{{route('primeraclonal.evaluaciones.camposanidad')}}",
                evaluacionesSC: "{{route('segundaclonal.evaluaciones.camposanidad')}}",
                evaluacionesMET: "{{route('met.evaluaciones.camposanidad')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                saveEvaluacionPC: "{{route('ajax.primeraclonal.evaluaciones.saveEvCampoSanidad')}}",
                saveEvaluacionSC: "{{route('ajax.segundaclonal.evaluaciones.saveEvCampoSanidad')}}",
                saveEvaluacionMET: "{{route('ajax.met.evaluaciones.saveEvCampoSanidad')}}",
            },
            data: {
                anioActivo: "{{$anio}}",
                ambienteActivo: "{{$idAmbiente}}",
                subambienteActivo: "{{$idSubambiente}}",
                sectorActivo: "{{$idSector}}",
                serieActiva: "{{$idSerie}}",
                mesActivo: "{{$mes}}",
                edadActiva: "{{$edad2}}",
                origen: "{{$origen}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/primera/evaluaciones/campo_sanidad.js')}}"></script>
@endsection

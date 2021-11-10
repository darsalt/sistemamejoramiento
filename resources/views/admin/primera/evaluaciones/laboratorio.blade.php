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
                            <th>Año</th>
                            <th>Serie</th>
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Sector</th>
                            <th>Fecha</th>
                            <th>Mes</th>
                            <th>Edad</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>
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
                                        {{$seedling->testigo ? $seedling->variedad->nombre : $seedling->parcelaPC->nombre_clon}}
                                    @else
                                        {{$seedling->idsegundaclonal_detalle ? (!$seedling->parcelaSC->testigo ? $seedling->parcelaSC->parcelaPC->nombre_clon : $seedling->parcelaSC->variedad->nombre) : $seedling->variedad->nombre}}
                                    @endif
                                @endif  
                            </td>
                            <td><input type="number" class="form-control" id="{{'pesomuestra-' . $seedling->id}}" 
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->peso_muestra : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'pesojugo-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->peso_jugo : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'brix-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'polarizacion-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->polarizacion : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'temperatura-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->temperatura : ''}}"></td>
                            <td><input type="number" class="form-control ultimoCampo" id="{{'conductividad-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->conductividad : ''}}"></td>
                            <td><p id={{'brixcorregido-' . $seedling->id}}>{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix_corregido : ''}}</p></td>
                            <td><p id={{'polenjugo-' . $seedling->id}}>{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pol_jugo : ''}}</p></td>
                            <td><p id={{'pureza-' . $seedling->id}}>{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pureza : ''}}</p></td>
                            <td><p id={{'rendimiento-' . $seedling->id}}>{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->rend_prob : ''}}</p></td>
                            <td><p id={{'polencania-' . $seedling->id}}>{{($ev = $seedling->evaluacionesLaboratorio()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->pol_cania : ''}}</p></td>
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
                evaluacionesPC: "{{route('primeraclonal.evaluaciones.laboratorio')}}",
                evaluacionesSC: "{{route('segundaclonal.evaluaciones.laboratorio')}}",
                evaluacionesMET: "{{route('met.evaluaciones.laboratorio')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                saveEvaluacionPC: "{{route('ajax.primeraclonal.evaluaciones.saveEvLaboratorio')}}",
                saveEvaluacionSC: "{{route('ajax.segundaclonal.evaluaciones.saveEvLaboratorio')}}",
                saveEvaluacionMET: "{{route('ajax.met.evaluaciones.saveEvLaboratorio')}}",
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

    <script src="{{asset('js/primera/evaluaciones/laboratorio.js')}}"></script>
@endsection

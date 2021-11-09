@extends('admin.layout')
@section('titulo', 'Etapa individual')

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
                    @foreach ($seedlingsPC as $seedling)
                        <tr>
                            <td>
                                <input type="number" disabled hidden value="{{$seedling->id}}" class="idSeedling">
                                {{$seedling->primera->testigo ? $seedling->parcela : (int)$seedling->parcela}}
                            </td>
                            <td>{{$seedling->nombre_clon}}</td>
                            <td><input type="number" class="form-control" id="{{'tipo-' . $seedling->id}}" 
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->tipo : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'tallos-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->tallos : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'altura-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->altura : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'grosor-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->grosor : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'vuelco-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->vuelco : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'flor-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->flor : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'brix-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->brix : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'escaldad-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->escaldad : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'carbon-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->carbon : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'roya-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->roya : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'mosaico-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->mosaico : ''}}"></td>
                            <td><input type="number" class="form-control" id="{{'estaria-' . $seedling->id}}"
                                value="{{($ev = $seedling->evaluacionesCampoSanidad()->where('idevaluacion', $idEvaluacion)->first()) ? $ev->estaria : ''}}"></td>
                            <td><input type="number" class="form-control ultimoCampo" id="{{'amarilla-' . $seedling->id}}"
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
                evaluaciones: "{{route('primeraclonal.evaluaciones.camposanidad')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                saveEvaluacion: "{{route('ajax.primeraclonal.evaluaciones.saveEvCampoSanidad')}}"
            },
            data: {
                anioActivo: "{{$anio}}",
                ambienteActivo: "{{$idAmbiente}}",
                subambienteActivo: "{{$idSubambiente}}",
                sectorActivo: "{{$idSector}}",
                serieActiva: "{{$idSerie}}",
                mesActivo: "{{$mes}}",
                edadActiva: "{{$edad2}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/primera/evaluaciones/campo_sanidad.js')}}"></script>
@endsection

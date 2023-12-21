@extends('admin.layout')
@section('titulo', 'MET')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('otros-estilos')
    <link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.min.css')}}">
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>MET</h3> 
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
            <form action="" class="form" id="formSegundaClonal" operation="insert">
                <input type="number" hidden value=0 id="idSeedling" name="idSeedling">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Serie</th>
                            <th>MET</th>
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Sector</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="serie" id="serie" class="form-control">
                                    <option value="0" disabled selected>(Ninguna)</option>
                                    @foreach ($series as $serie)
                                        <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><p id="anio"></p></td>
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
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Cantidad de variedades</th>
                        <th>Repeticiones</th>
                        <th>Bloques</th>
                        <th class="col-submit"></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" class="form-control" name="cantVariedades" id="cantVariedades"></td>
                            <td><input type="number" class="form-control" name="repeticiones" id="repeticiones" value="3"></td>
                            <td><input type="number" class="form-control" name="cantBloques" id="cantBloques"></td>
                            <td class="text-center col-submit">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </form>
            <div id="divCargaSeedlings" style="display: none;">
                <h4>Cargar seedlings</h4>
                <form action="" class="form" id="formSeedlings">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <th width="10%">Parcela</th>
                            <th width="10%">Bloque</th>
                            <th width="10%">Repetición</th>
                            <th>Origen</th>
                            <th class='col-serieSC'>Serie</th>
                            <th class="col-seedlingsSC">Seedlings Segunda clonal</th>
                            <th class="col-variedades">Variedades</th>
                            <th class="col-observaciones">Observaciones</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="number" id="nroParcela" name="nroParcela" class="form-control" disabled readonly></td>
                                <td><input type="number" id="nroBloque" name="nroBloque" class="form-control" disabled readonly></p></td>
                                <td><input type="number" id="nro_repeticion" name="nro_repeticion" class="form-control" required></td>
                                <td>
                                    <select name="origenSeedling" id="origenSeedling" class="form-control">
                                        <option value="sc" selected>Segunda clonal</option>
                                        <option value="testigo">Testigo</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </td>
                                <td class='col-serieSC'>
                                    <select name="serieSC" id="serieSC" class="form-control">
                                        @foreach ($series as $serie)
                                            <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-seedlingsSC">
                                    <select name="seedlingsSC" id="seedlingsSC" class="form-control">
                                        <option value="0" disabled selected>(Ninguna)</option>
                                    </select>
                                </td>
                                <td class='col-variedades'>
                                    <select name="variedad" id="variedad" class="form-control">
                                        @foreach ($variedades as $variedad)
                                            <option value="{{$variedad->idvariedad}}">{{$variedad->nombre}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-observaciones"><input type="text" class="form-control" name="observaciones" id="observaciones"></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <h3>Parcelas cargadas</h3>
        <table class="table table-striped table-bordered table-condensed table-hover" id="tablaParcelasCargadas">
            <thead>
                <th>Serie</th>
                <th>Parcela</th>
                <th>Bloque</th>
                <th>Repetición</th>
                <th>Parcela PC</th>
                <th>Clon</th>
            </thead>
            <tbody>
                @foreach ($parcelasCargadas as $parcela)
                    <tr>
                        <td>
                            @if ($parcela->parcelaSC)
                                {{$parcela->parcelaSC->segunda->serie->nombre}}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{$parcela->parcela}}</td>
                        <td>{{$parcela->bloque}}</td>
                        <td>{{$parcela->repeticion}}</td>
                        <td>{{$parcela->parcelaSC && $parcela->parcelaSC->parcelaPC ? (int)$parcela->parcelaSC->parcelaPC->parcela : '-'}}</td>
                        <td>
                            @if ($parcela->parcelaSC && $parcela->parcelaSC->parcelaPC)
                                {{$parcela->parcelaSC->parcelaPC->nombre_clon}}
                            @else
                                @if ($parcela->parcelaSC)
                                    {{$parcela->parcelaSC->variedad->nombre}}
                                @else
                                    @if ($parcela->variedad)
                                        {{$parcela->variedad->nombre}}
                                    @else
                                        {{$parcela->observaciones}}
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
    <script>
        var config = {
            routes: {
                met: "{{route('met.index')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                getSegundasClonales: "{{route('ajax.segundaclonal.getSegundaClonales')}}",
                saveMET: "{{route('ajax.met.saveMET')}}",
                METAsociado: "{{route('ajax.met.METAsociado')}}",
                getUltimaParcela: "{{route('ajax.met.getUltimaParcela')}}",
                saveDetalleMET: "{{route('ajax.met.saveDetalleMET')}}",
                getAnioSerie: "{{route('ajax.primera.serie.getAnioSerie')}}"
            },
            data: {
                ambienteActivo: "{{$idAmbiente}}",
                subambienteActivo: "{{$idSubambiente}}",
                sectorActivo: "{{$idSector}}",
                serieActiva: "{{$idSerie}}",
                met: @if (isset($met)) {!! $met !!} @else null @endif,
            },  
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/met/index2.js')}}"></script>
@endsection

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
                            <th>Año</th>
                            <th>Serie</th>
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Sector</th>
                            <th></th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="anio" id="anio" class="form-control">
                                    @for ($i = (int)date('Y'); $i >= 2010; $i--)
                                        <option value="{{$i}}" {{old('anio') == $i ? 'selected' : ''}}>{{$i}}</option>
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
                            <td class="text-center">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
                <h4>Seedlings segunda clonal</h4>
                <table class="table table-striped table-bordered table-condensed table-hover" id="tableSeedlingsPC">
                    <thead>
                        <th>Seleccionado</th>
                        <th>Parcela PC</th>
                        <th>Madre x Padre</th>
                    </thead>
                    <tbody>
                        @foreach ($parcelasSC as $parcela)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input check-laboratorio" value="{{$parcela->id}}" name="seedlingsSC[]"
                                data-mets="{{$parcela->mets()->with('met')->get()}}" style="width: 15px; height: 15px;">
                            </td>
                            <td>{{$parcela->parcelaPC->parcela}}</td>
                            <td>{{$parcela->parcelaPC->primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $parcela->parcelaPC->primera->seedling->semillado->cruzamiento->padre->nombre}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
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
                getSegundaClonal: "{{route('ajax.segundaclonal.getSegundaClonal')}}",
                saveMET: "{{route('ajax.met.saveMET')}}",
            },
            data: {
                serieActiva: "{{$idSerie}}",
                ambienteActivo: "{{$idAmbiente}}",
                subambienteActivo: "{{$idSubambiente}}",
                sectorActivo: "{{$idSector}}",
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/met/index.js')}}"></script>
@endsection

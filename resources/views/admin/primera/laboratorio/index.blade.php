@extends('admin.layout')
@section('titulo', 'Selección para laboratorio')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Selección laboratorio</h3> 
	</div>
</div>

<div class="row">
    <div class="col-12">
        <!--Mensajes que se muestran con jQuery-->
        <div class="text-center" id="messages">
            <p class='text-success' id='msgExito' style='display: none;'>Operación exitosa &nbsp;<i class='fas fa-sm fa-check-circle'></i></p>
            <p class='text-danger' id='msgError' style='display: none;'>Error en la operación &nbsp;<i class='fas fa-sm fa-times-circle'></i></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group row">
            <label for="serie" class="col-2 col-lg-1 col-form-label">Serie: </label>
            <div class="col-4 col-lg-2">
                <select name="serie" id="serie" class="form-control">
                    <option value="0" selected disabled>(Ninguna)</option>
                    @foreach ($series as $serie)
                        <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <label for="ambiente" class="col-2 col-lg-1 col-form-label">Ambiente: </label>
            <div class="col-4 col-lg-2">
                <select name="ambiente" id="ambiente" class="form-control">
                    <option value="0" selected disabled>(Ninguno)</option>
                    @foreach ($ambientes as $ambiente)
                        <option value="{{$ambiente->id}}">{{$ambiente->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <label for="subambiente" class="col-2 col-lg-1 col-form-label">Subambiente: </label>
            <div class="col-4 col-lg-2">
                <select name="subambiente" id="subambiente" class="form-control">
                    <option value="0" selected disabled>(Ninguno)</option>
                </select>
            </div>

            <label for="sector" class="col-2 col-lg-1 col-form-label">Sector: </label>
            <div class="col-4 col-lg-2">
                <select name="sector" id="sector" class="form-control">
                    <option value="0" selected disabled>(Ninguno)</option>
                </select>
            </div>
        </div>   
    </div>
</div>

<!--Tabla para seleccionar-->
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered table-condensed table-hover" id="tablaSeedlings"">
            <thead>
                <tr>
                    <th>Seleccionado</th>
                    <th>Parcela Primera Clonal</th>
                    <th>Campaña Seedling</th>
                    <th>Parcela</th>
                    <th>Madre x Padre</th>   
                    <th>Nombre clon</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($seedlings))
                    @foreach ($seedlings as $primera)
                        @foreach ($primera->parcelas as $parcela)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input check-laboratorio" value="{{$parcela->id}}" {{$parcela->laboratorio ? 'checked' : ''}}
                                    style="width: 15px; height: 15px;">
                                </td>
                                <td>{{$parcela->primera->testigo ? $parcela->parcela : (int)$parcela->parcela}}</td>
                                <td>{{$parcela->primera->testigo ? '-' : $primera->seedling->campania->nombre}}</td>
                                <td>{{$parcela->primera->testigo ? '-' : $primera->seedling->parcela}}</td>
                                <td>
                                    @if ($parcela->primera->testigo)
                                        {{$parcela->primera->variedad->nombre}}
                                    @else
                                        @if ($primera->seedling->origen == 'cruzamiento')
                                            {{$primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $primera->seedling->semillado->cruzamiento->padre->nombre}}   
                                        @else
                                            @if ($primera->seedling->origen == 'testigo')
                                                {{$primera->seedling->variedad->nombre}}
                                            @else
                                                {{$primera->seedling->observaciones}}
                                            @endif
                                        @endif 
                                    @endif
                                </td>
                                <td>{{$parcela->nombre_clon}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
        {{$seedlings->render()}}
    </div>
</div>

<div class="row">
    <div class="col-12 text-right">
        <button class="btn btn-success" id="btnConfirmar">Confirmar selección</button>
    </div>
</div>
@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script>
        var config = {
            routes: {
                laboratorio: "{{route('primeraclonal.laboratorio.index')}}",
                saveLaboratorio: "{{url('admin/primera/laboratorio')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
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

    <script src="{{asset('js/primera/laboratorio.js')}}"></script>
@endsection
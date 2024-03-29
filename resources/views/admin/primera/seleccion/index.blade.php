@extends('admin.layout')
@section('titulo', 'Primera Clonal')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Primera Clonal</h3> 
	</div>
</div>
<div class="row">
	<div class="col-6">
		<button id="btnToggleForm" class="btn btn-primary mb-2">Ocultar formulario</button>
        <button id="btnAddTestigos" class="btn btn-info mb-2" style="display: none;" data-toggle="modal" data-target="#modal-testigos">Incorporar testigos</button>
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
            <form action="" class="form" id="formPrimeraClonal" operation="insert">
                <input type="number" hidden value=0 id="idSeedling" name="idSeedling">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Serie</th>
                            <th>Año</th>
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
                            <td>
                                <p id="anio"></p>
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
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Campaña seedling</th>
                            <th>Parcela</th>
                            <th>Madre x Padre</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Cantidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            <select name="campSeedling" id="campSeedling" class="form-control">
                                <option value="0" disabled selected>(Ninguno)</option>
                                @foreach ($campSeedling as $campania)
                                    <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="parcela" id="parcela" class="form-control">
                                <option value="0" disabled selected>(Ninguno)</option>
                            </select>
                        </td>
                        <td>
                            <p id="progenitores"></p>
                        </td>
                        <td>
                            <input type="number" id="parcelaDesde" name="parcelaDesde" class="form-control">
                        </td>
                        <td>
                            <input type="number" id="parcelaHasta" name="parcelaHasta" class="form-control">
                        </td>
                        <td>
                            <p id="cantidad"></p>
                        </td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                        </td>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if ($idSerie != 0 && $idSector != 0)
            <h4><b>Serie: </b>{{App\Serie::find($idSerie)->nombre}} - <b>Ambiente: </b>{{App\Ambiente::find($idAmbiente)->nombre}} - <b>Subambiente: </b>{{App\Subambiente::find($idSubambiente)->nombre}}
                 - <b>Sector: </b>{{App\Sector::find($idSector)->nombre}}</h4>    
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
            <!--Tabla con los datos segun la campaña seleccionada-->
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaSeedlings">
                <thead>
                    <tr>
                        {{-- <th>Campaña seedling</th> --}}
                        <th>Parcela</th>
                        <th>Nombre clon</th>
                        <th>Parcela seedling</th>
                        <th>Madre x Padre</th>
                        {{-- <th>Desde</th>
                        <th>Hasta</th>
                        <th>Cantidad</th> --}}
                        {{-- <th>Variedad</th> --}}
                        <th width="10%"></th>
                    </tr> 
                <tbody id="bodyTablaSeedlings">
                    @if (isset($parcelas))
                        @foreach ($parcelas as $parcela)
                            <tr>
                                <td>{{!$parcela->primera->testigo ? (int)$parcela->parcela : $parcela->parcela}}</td>
                                <td>
                                    {{-- @if ($parcela->parcela = 9999)
                                        <span class="text-warning"><i class="fas fa-exclamation-triangle" title="Este clon proviene de una importación"></i></span>
                                    @endif --}}
                                    {{!$parcela->primera->testigo ? $parcela->nombre_clon : '-'}}
                                </td>
                                <td>{{!$parcela->primera->testigo && $parcela->primera->seedling ? $parcela->primera->seedling->parcela : '-'}}</td>
                                <td>
                                    @if (!$parcela->primera->testigo)
                                        @if ($parcela->primera->seedling)
                                            @if ($parcela->primera->seedling->origen == 'cruzamiento')
                                                {{$parcela->primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $parcela->primera->seedling->semillado->cruzamiento->padre->nombre}}
                                            @else
                                                @if ($parcela->primera->seedling->origen == 'testigo')
                                                    {{$parcela->primera->seedling->variedad->nombre}}
                                                @else
                                                    {{$parcela->primera->seedling->observaciones}}   
                                                @endif
                                            @endif
                                        @else
                                            {{$parcela->nombre_clon}}
                                        @endif
                                    @else
                                        {{$parcela->primera->variedad->nombre}}
                                    @endif
                                </td>
                                <td>
                                    @if (!$parcela->primera->testigo)
                                        <button class='btn editBtn' onclick='editarSeedling({{$parcela->idprimeraclonal}})'><i class='fa fa-edit fa-lg'></i></button>
                                        <button class='btn deleteBtn' data-id="{{$parcela->idprimeraclonal}}"><i class='fa fa-trash fa-lg'></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
{{--                     @if (isset($seedlings))
                        @foreach ($seedlings as $primera)
                            <tr>
                                <td>{{$primera->testigo ? '-' : $primera->seedling->parcela}}</td>
                                <td>
                                    @if (!$primera->testigo)
                                        @if ($primera->seedling->origen == 'cruzamiento')
                                            {{$primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $primera->seedling->semillado->cruzamiento->padre->nombre}}
                                        @else
                                            @if ($primera->seedling->origen == 'testigo')
                                                {{$primera->seedling->variedad->nombre}}
                                            @else
                                                {{$primera->seedling->observaciones}}
                                            @endif
                                        @endif
                                    @else
                                        Testigo
                                    @endif

                                </td>
                                <td>
                                    @if (!$primera->testigo)
                                        <button class='btn editBtn' onclick='editarSeedling({{$primera->id}})'><i class='fa fa-edit fa-lg'></i></button>
                                        <button class='btn deleteBtn' data-id="{{$primera->id}}"><i class='fa fa-trash fa-lg'></i></button>
                                    @endif
                                </td>
                            </tr>
                            @if (count($primera->parcelas) > 0)
                                <tr>
                                    <td colspan="3">
                                        <table class="table table-sm">
                                            <thead>
                                                <th>Parcela</th>
                                                <th>Nombre clon</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($primera->parcelas as $parcela)
                                                    <tr>
                                                        <td>{{$parcela->primera->testigo ? $parcela->parcela : (int)$parcela->parcela}}</td>
                                                        <td>{{$parcela->primera->testigo ? $parcela->primera->variedad->nombre : $parcela->nombre_clon}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif --}}
                </tbody>
            </table>
            {{$seedlings->render()}}
        </div>
    </div>
</div>

<!--Modal para la eliminacion-->
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete">
	<form action="" method="POST" id="formDelete">
        @csrf
        @method('DELETE')

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Baja de Seedling</h4>
                    <button type="button" class="close" data-dismiss="modal" 
                    aria-label="Close">
                         <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme que desea dar de baja el seedling</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!--Modal para la incorporacion de testigos-->
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-testigos">
	<form action="" method="POST" id="formTestigos">
        @csrf

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Incorporacion de testigos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-sm btn-primary mb-3" id="btnAddRowTestigo"><i class="fas fa-plus"></i> Nueva fila</button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table col-12" id="tablaTestigos">
                            <thead>
                                <th width="50%">Variedad</th>
                                <th>Parcela</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="testigoVariedad[]" class="form-control testigoVariedades">
                                            @foreach ($variedades as $variedad)
                                                <option value="{{$variedad->idvariedad}}">{{$variedad->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="testigoParcela[]" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarTestigos">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script>
        var config = {
            routes: {
                seedlings: "{{route('primeraclonal.index')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                getUltimaParcela: "{{route('ajax.primeraclonal.getUltimaParcela')}}",
                savePrimeraClonal: "{{route('ajax.primeraclonal.savePrimeraClonal')}}",
                getSeedlings: "{{route('ajax.individual.getSeedlings')}}",
                getPrimeraClonal: "{{route('ajax.primeraclonal.getPrimeraClonal')}}",
                editPrimeraClonal: "{{route('ajax.primeraclonal.editPrimeraClonal')}}",
                deletePrimeraClonal: "{{route('primeraclonal.delete')}}",
                getProgenitoresSeedling: "{{route('ajax.individual.getProgenitoresSeedling')}}",
                saveTestigos: "{{route('ajax.primeraclonal.saveTestigos')}}",
                getAnioSerie: "{{route('ajax.primera.serie.getAnioSerie')}}"
            },
            data: {
                serieActiva: "{{$idSerie}}",
                ambienteActivo: "{{$idAmbiente}}",
                subambienteActivo: "{{$idSubambiente}}",
                sectorActivo: "{{$idSector}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/primera/index.js')}}"></script>
@endsection

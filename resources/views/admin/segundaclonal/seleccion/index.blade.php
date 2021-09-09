@extends('admin.layout')
@section('titulo', 'Segunda Clonal')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('otros-estilos')
    <link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.min.css')}}">
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Segunda Clonal</h3> 
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<button id="btnToggleForm" class="btn btn-primary mb-2">Ocultar formulario</button>
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
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Sector</th>
                            <th>Procedencia</th>
                            <th></th>
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
                                <select name="procedencia" id="procedencia" class="form-control">
                                    <option value="T" selected>Todos</option>
                                    <option value="L">Laboratorio</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
                <h4>Seedlings primera clonal</h4>
{{--                 <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Seedlings Primera Clonal</th>
                        <th width='10%'></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="seedlingsPC[]" id="seedlingsPC" multiple>
                                    @if (isset($parcelasPC))
                                        @foreach ($parcelasPC as $parcela)
                                            <option value="{{$parcela->id}}" data-idsc="{{$parcela->segunda ? $parcela->segunda->idsegundaclonal : null}}" data-laboratorio="{{$parcela->laboratorio}}">
                                                {{$parcela->primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $parcela->primera->seedling->semillado->cruzamiento->padre->nombre . ' - Parcela: ' . $parcela->parcela}}                                        
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                                    
                        </tr>
                    </tbody>
                </table> --}}
                <table class="table table-striped table-bordered table-condensed table-hover" id="tableSeedlingsPC">
                    <thead>
                        <th>Seleccionado</th>
                        <th>Parcela PC</th>
                        <th>Madre x Padre</th>
                        <th>Ubicación actual</th>
                    </thead>
                    <tbody>
                        @foreach ($parcelasPC as $parcela)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input check-laboratorio" value="{{$parcela->id}}" name="seedlingsPC[]" data-idsector="{{$parcela->segunda ? $parcela->segunda->idsector : null}}"
                                    data-idsc="{{$parcela->segunda ? $parcela->segunda->idsegundaclonal : null}}" data-laboratorio="{{$parcela->laboratorio}}" style="width: 15px; height: 15px;">
                            </td>
                            <td>{{$parcela->parcela}}</td>
                            <td>{{$parcela->primera->seedling->semillado->cruzamiento->madre->nombre . ' - ' . $parcela->primera->seedling->semillado->cruzamiento->padre->nombre}}</td>
                            @if ($parcela->segunda)
                                <td>{{$parcela->segunda->sector->subambiente->ambiente->nombre . ' - ' . $parcela->segunda->sector->subambiente->nombre . ' - ' . $parcela->segunda->sector->nombre}}</td>    
                            @else
                                <td></td>
                            @endif  
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-12">
        <h4>Seedlings Segunda Clonal:</h4>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
            <!--Tabla con los datos segun la serie seleccionada-->
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaSeedlings">
                <thead>
                    <tr>
                        <th>Serie</th>
                        <th>Ambiente</th>
                        <th>Subambiente</th>
                        <th>Sector</th>
                        <th>Cantidad seedlings</th>
                        <th></th>
                    </tr> 
                <tbody>
                    @if (isset($seedlings))
                        @foreach ($seedlings as $segunda)
                            <tr>
                                <td>{{$segunda->serie->nombre}}</td>
                                <td>{{$segunda->sector->subambiente->ambiente->nombre}}</td>
                                <td>{{$segunda->sector->subambiente->nombre}}</td>
                                <td>{{$segunda->sector->nombre}}</td>
                                <td>{{count($segunda->parcelas)}}</td>
                                <td>
                                    <button class='btn editBtn' onclick='editarSeedling({{$segunda->id}})'><i class='fa fa-edit fa-lg'></i></button>
                                    <button class='btn deleteBtn' data-id="{{$segunda->id}}"><i class='fa fa-trash fa-lg'></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{$seedlings->render()}}
        </div>
    </div>
</div> --}}


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

@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
    <script>
        var config = {
            routes: {
                segundaclonal: "{{route('segundaclonal.index')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                saveSegundaClonal: "{{route('ajax.segundaclonal.saveSegundaClonal')}}",
                getSegundaClonal: "{{route('ajax.segundaclonal.getSegundaClonal')}}",
                editSegundaClonal: "{{route('ajax.segundaclonal.editSegundaClonal')}}",
                deleteSegundaClonal: "{{route('segundaclonal.delete')}}",

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

    <script src="{{asset('js/segundaclonal/index.js')}}"></script>
@endsection

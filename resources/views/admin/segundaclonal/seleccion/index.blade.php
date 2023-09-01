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
                            <th>Año</th>
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
                                <p id='anio'></p>
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
                <table class="table table-striped table-bordered table-condensed table-hover" id="tableSeedlingsPC">
                    <thead>
                        <th>Seleccionado</th>
                        <th width="5%">Parcela</th>
                        <th width="5%">Repetición</th>
                        <th>Parcela PC</th>
                        <th>Nombre clon</th>
                        <th>Madre x Padre</th>
                    </thead>
                    <tbody>
                        @foreach ($parcelasPC as $parcela)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input check-seleccionado" value="{{$parcela->id}}" name="seedlingsPC[]"
                                    data-segundas="{{$parcela->segundas()->with('segunda')->get()}}" data-laboratorio="{{$parcela->laboratorio}}" style="width: 15px; height: 15px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control input-parcela" name="parcelas[]" {{$parcela->segunda ? "value=" . (int)$parcela->segunda->parcela : 'disabled'}}>
                            </td>
                            <td>
                                <input type="number" class="form-control input-repeticion" name="repeticiones[]" {{$parcela->segunda ? "value=" . (int)$parcela->segunda->repeticion : 'disabled'}}>
                            </td>
                            <td>{{$parcela->primera->testigo ? $parcela->parcela : (int)$parcela->parcela}}</td>
                            <td>
                               {{--  @if ($parcela->parcela = 9999)
                                    <span class="text-warning"><i class="fas fa-exclamation-triangle" title="Este clon proviene de una importación"></i></span>
                                @endif --}}
                                {{$parcela->primera->testigo ? '-' : $parcela->nombre_clon}}
                            </td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!--Formulario para cargar testigos-->
<div class="row" id="div-testigos" style="display: none;">
    <div class="col-12">
        <h4>Testigos</h4>
        <div class="table-responsive">
            <form action="" class="form" id="formTestigos" operation="insert">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Variedad</th>
                        <th width="10%">Parcela</th>
                        <th width="10%"></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="variedad" id="variedad" class="form-control">
                                    @foreach ($variedades as $variedad)
                                        <option value="{{$variedad->idvariedad}}">{{$variedad->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="parcelaTestigo" id="parcelaTestigo">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!--Tabla para visualizar los testigos cargados-->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaTestigos">
                <thead>
                    <th>Variedad</th>
                    <th width="10%">Parcela</th>
                    <th width="10%"></th>
                </thead>
                <tbody>
                    @foreach ($testigos as $testigo)
                        <tr>
                            <td>{{$testigo->variedad->nombre}}</td>
                            <td>{{(int)$testigo->parcela}}</td>
                            <td><button class='btn deleteBtn' data-id="{{$testigo->id}}"><i class='fa fa-trash fa-lg'></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Modal para la eliminacion de testigo-->
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete">
	<form action="" method="POST" id="formDelete">
        @csrf
        @method('DELETE')

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminacion de testigo</h4>
                    <button type="button" class="close" data-dismiss="modal" 
                    aria-label="Close">
                         <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme que desea eliminar el testigo</p>
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
                saveTestigo: "{{route('ajax.segundaclonal.saveTestigo')}}",
                deleteTestigo: "{{route('segundaclonal.deleteTestigo')}}",
                getUltimaParcela: "{{route('ajax.segundaclonal.getUltimaParcela')}}",
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

    <script src="{{asset('js/segundaclonal/index.js')}}"></script>
@endsection

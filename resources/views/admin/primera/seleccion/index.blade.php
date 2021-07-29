@extends('admin.layout')
@section('titulo', 'Etapa individual')

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
            <!--Tabla con el formulario para el registro de la etapa individual-->
            <form action="" class="form" id="formPrimeraClonal" operation="insert">
                <input type="number" hidden value=0 id="idSeedling" name="idSeedling">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Serie</th>
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Lote</th>
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
                                <select name="lote" id="lote" class="form-control">
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
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
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
                            <input type="date" id="fecha" name="fecha" class="form-control">
                        </td>
                        <td>
                            <input type="number" id="cantidad" name="cantidad" class="form-control">
                        </td>
                        <td>
                            <p id="parcelaDesde"></p>
                        </td>
                        <td>
                            <p id="parcelaHasta"></p>
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
    <div class="col-12 table-responsive">
            <!--Tabla con los datos segun la campaña seleccionada-->
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaSeedlings">
                <thead>
                    <tr>
                        <th>Serie</th>
                        <th>Ambiente</th>
                        <th>Subambiente</th>
                        <th>Lote</th>
                        <th>Campaña seedling</th>
                        <th>Parcela</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th></th>
                    </tr> 
                <tbody>
                    @if (isset($seedlings))
                        @foreach ($seedlings as $primera)
                            <tr>
                                <td>{{$primera->serie->nombre}}</td>
                                <td>{{$primera->lote->subambiente->ambiente->nombre}}</td>
                                <td>{{$primera->lote->subambiente->nombre}}</td>
                                <td>{{$primera->lote->nombrelote}}</td>
                                <td>{{$primera->seedling->campania->nombre}}</td>
                                <td>{{$primera->seedling->parcela}}</td>
                                <td>{{$primera->fecha}}</td>
                                <td>{{$primera->cantidad}}</td>
                                <td>{{$primera->parceladesde}}</td>
                                <td>{{$primera->parceladesde + $primera->cantidad - 1}}</td>
                                <td>
                                    <button class='btn editBtn' onclick='editarSeedling({{$primera->id}})'><i class='fa fa-edit fa-lg'></i></button>
                                    <button class='btn deleteBtn' data-id="{{$primera->id}}"><i class='fa fa-trash fa-lg'></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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

@endsection 

@section('script')
    <script src="{{asset('js/validaciones/initValidation.js')}}"></script>
    <script>
        var config = {
            routes: {
                seedlings: "{{route('primeraclonal.index')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getLotes: "{{route('ajax.lotes.getLotesDadoSubambiente')}}",
                getUltimaParcela: "{{route('ajax.primeraclonal.getUltimaParcela')}}",
                savePrimeraClonal: "{{route('ajax.primeraclonal.savePrimeraClonal')}}",
                getSeedlings: "{{route('ajax.individual.getSeedlings')}}",
                getPrimeraClonal: "{{route('ajax.primeraclonal.getPrimeraClonal')}}",
                editPrimeraClonal: "{{route('ajax.primeraclonal.editPrimeraClonal')}}",
                deletePrimeraClonal: "{{route('primeraclonal.delete')}}"
            },
            data: {
                serieActiva: "{{$idSerie}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/primera/index.js')}}"></script>
@endsection

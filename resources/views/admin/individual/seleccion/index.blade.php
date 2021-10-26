@extends('admin.layout')
@section('titulo', 'Etapa individual')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Etapa individual</h3> 
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
            <form action="" class="form" id="formSeedling" operation="insert">
                <input type="number" hidden value=0 id="idSeedling" name="idSeedling">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Campaña seedling</th>
                            <th>Ambiente</th>
                            <th>Subambiente</th>
                            <th>Sector</th>
                            <th>Fecha</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="campSeedling" id="campSeedling" class="form-control">
                                    <option value="0" disabled selected>(Ninguna)</option>
                                    @foreach ($campaniasSeedling as $campania)
                                        <option value="{{$campania->id}}">{{$campania->nombre}}</option>
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
                                <input type="date" id="fecha" name="fecha" class="form-control">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th width="10%" class="col-parcela">Parcela</th>
                        <th >Origen</th>
                        <th class="col-campania">Campaña semillado</th>
                        <th class="col-orden">Orden</th>
                        <th class="col-progenitores">Madre x Padre</th>
                        <th class="col-variedad" style="display: none;">Variedad</th>
                        <th class="col-observacion" style="display: none;">Observación</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-parcela">
                                <p id="parcela"></p>
                            </td>
                            <td>
                                <select name="origen" id="origen" class="form-control">
                                    <option value="cruzamiento">Cruzamiento</option>
                                    <option value="testigo">Testigo</option>
                                    <option value="n/i">N/I</option>
                                </select>
                            </td>
                            <td class="col-campania">
                                <select name="campSemillado" id="campSemillado" class="form-control">
                                    <option value="0" disabled selected>(Ninguna)</option>
                                    <@foreach ($campaniasSemillado as $campania)
                                        <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="col-orden">
                                <select name="ordenSemillado" id="ordenSemillado" class="form-control">
                                    <option value="0" disabled selected>(Ninguno)</option>
                                </select>
                            </td>
                            <td class="col-progenitores">
                                <p id="progenitores"></p>
                            </td>
                            <td class="col-variedad" style="display: none;">
                                <select name="variedad" id="variedad" class="form-control">
                                    @foreach ($variedades as $variedad)
                                        <option value="{{$variedad->idvariedad}}">{{$variedad->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="col-observacion" style="display: none;">
                                <input type="text" name="observacion" id="observacion" class="form-control">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Tabla</th>
                        <th>Tablita</th>
                        <th>Surcos</th>
                        <th>Plantas / Surco</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <td>
                            <input type="text" id="tabla" name="tabla" class="form-control">
                        </td>
                        <td>
                            <input type="text" id="tablita" name="tablita" class="form-control">
                        </td>
                        <td>
                            <input type="number" id="surcos" name="surcos" class="form-control">
                        </td>
                        <td>
                            <input type="number" id="plantasxsurco" name="plantasxsurco" class="form-control">
                        </td>
                        <td>
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
                        <th>Parcela</th>
                        <th>Campaña semillado</th>
                        <th>Orden</th>
                        <th>Madre x Padre</th>
                        <th>Tabla</th>
                        <th>Tablita</th>
                        <th>Surcos</th>
                        <th>Plantas / Surco</th>
                        <th></th>
                    </tr> 
                <tbody>
                    @if (isset($seedlings))
                        @foreach ($seedlings as $seedling)
                            <tr>
                                <td>{{$seedling->parcela}}</td>
                                <td>{{$seedling->semillado ? $seedling->semillado->campania->nombre : '-'}}</td>
                                <td>{{$seedling->semillado ? $seedling->semillado->numero : '-'}}</td>
                                <td>
                                    @if ($seedling->origen == 'testigo')
                                        {{$seedling->variedad->nombre}}
                                    @else
                                        @if ($seedling->origen == 'n/i')
                                            {{$seedling->observaciones}}
                                        @else
                                            {{$seedling->semillado->cruzamiento->madre->nombre . ' - ' . $seedling->semillado->cruzamiento->padre->nombre}}
                                        @endif
                                    @endif
                                </td>
                                <td>{{$seedling->tabla}}</td>
                                <td>{{$seedling->tablita}}</td>
                                <td>{{$seedling->surcos}}</td>
                                <td>{{$seedling->plantasxsurco}}</td>
                                <td>
                                    <button class='btn editBtn' onclick='editarSeedling({{$seedling->id}})'><i class='fa fa-edit fa-lg'></i></button>
                                    <button class='btn deleteBtn' data-id="{{$seedling->id}}"><i class='fa fa-trash fa-lg'></i></button>
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
                seedlings: "{{route('individual.index')}}",
                getSubambientes: "{{route('ajax.subambientes.getSubambientesDadoAmbiente')}}",
                getSectores: "{{route('ajax.sectores.getSectoresDadoSubambiente')}}",
                getUltimaParcela: "{{route('ajax.individual.getUltimaParcela')}}",
                saveSeedling: "{{route('ajax.individual.saveSeedling')}}",
                getSemillados: "{{route('ajax.semillados.getSemillados')}}",
                getSeedling: "{{route('ajax.individual.getSeedling')}}",
                editSeedling: "{{route('ajax.individual.editSeedling')}}",
                deleteSeedling: "{{route('individual.delete')}}",
                getProgenitoresSemillado: "{{route('ajax.semillados.getProgenitores')}}"
            },
            data: {
                campActiva: "{{$idCampania}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/seedling/index.js')}}"></script>
@endsection

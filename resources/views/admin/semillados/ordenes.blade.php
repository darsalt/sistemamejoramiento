@extends('admin.layout')
@section('titulo', 'Semillados')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Semillados</b></h3>
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
        <!--Tabla con el formulario para el registro del semillado-->
        <form action="" class="form" id="formSemillado" operation="insert">
            <input type="number" hidden value=0 id="idSemillado" name="idSemillado">
            <table class="table table-striped table-bordered table-condensed table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Campaña semillado</th>
                        <th>Orden</th>
                        <th>Campaña cruzamiento</th>
                        <th>Cruza</th>
                        <th>Fecha de semillado</th>
                        <th>Stock actual</th>
                        <th>Gramos</th>
                        <th>PG</th>
                        <th>Plantas</th>
                        <th>Cajones</th>
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                    <tr>
                        <td width="15%">
                            <select name="campSemillado" id="campSemillado" class="form-control">
                                <option value="0" selected>(Ninguna)</option>
                                @foreach ($campaniasSemillado as $campania)
                                    <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <p id="nroOrden"></p>
                        </td>
                        <td width="15%">
                            <select name="campCruzamiento" id="campCruzamiento" class="form-control">
                                <option value="0" selected>(Ninguna)</option>
                                @foreach ($campaniasCruzamiento as $campania)
                                    <option value="{{$campania->id}}">{{$campania->nombre}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td width="20%">
                            <select name="nroCruza" id="nroCruza" class="form-control"></select>
                        </td>
                        <td>
                            <input type="date" class="form-control" name="fechaSemillado" id="fechaSemillado">
                        </td>    
                        <td>
                            <p id="stockActual"></p>
                        </td>
                        <td>
                            <input type="number" id="cantGramos" name="cantGramos" class="form-control">
                        </td>
                        <td>
                            <p id="poderGerminativo"></p>
                        </td>
                        <td>
                            <p id="cantPlantas"></p>
                        </td>
                        <td>
                            <input type="number" id="cantCajones" name="cantCajones" class="form-control">
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

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <!--Tabla con los datos segun la campaña seleccionada-->
            <table class="table table-striped table-bordered table-condensed table-hover" id="tablaOrdenes">
                <thead>
                    <th>Campaña semillado</th>
                    <th>Orden</th>
                    <th>Campaña cruzamiento</th>
                    <th>Cruza</th>
                    <th>Fecha de semillado</th>
                    <th>Gramos</th>
                    <th>PG</th>
                    <th>Plantas</th>
                    <th>Cajones</th>
                    <th></th>
                </thead>
                <tbody>
                    @if (isset($semillados))
                        @foreach ($semillados as $semillado)
                            <tr>
                                <td>{{$semillado->campania->nombre}}</td>
                                <td>{{$semillado->numero}}</td>
                                <td>{{$semillado->cruzamiento->campaniaCruzamiento->nombre}}</td>
                                <td>{{$semillado->idcruzamiento . " - " . $semillado->cruzamiento->madre->nombre . " - " . $semillado->cruzamiento->padre->nombre}}</td>
                                <td>{{$semillado->fechasemillado}}</td>
                                <td>{{$semillado->gramos}}</td>
                                <td>{{$semillado->cruzamiento->semilla->podergerminativo}}</td>
                                <td>{{$semillado->gramos * $semillado->cruzamiento->semilla->podergerminativo}}</td>
                                <td>{{$semillado->cajones}}</td>
                                <td>
                                    <button class='btn editBtn' onclick='editarSemillado({{$semillado->idsemillado}})'><i class='fa fa-edit fa-lg'></i></button>
                                    <button class='btn deleteBtn' data-id="{{$semillado->idsemillado}}"><i class='fa fa-trash fa-lg'></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{$semillados->render()}}
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
                    <h4 class="modal-title">Baja de Semillado</h4>
                    <button type="button" class="close" data-dismiss="modal" 
                    aria-label="Close">
                         <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme que desea dar de baja el semillado</p>
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
                ordenes: "{{route('semillados.ordenes')}}",
                getCruzamientos: "{{route('ajax.cruzamientos.getCruzamientos')}}",
                getUltimaOrden: "{{route('ajax.semillados.getUltimaOrden')}}",
                getSemilla : "{{route('ajax.semillas.getSemilla')}}",
                saveSemillado: "{{route('ajax.semillados.saveSemillado')}}",
                getSemillados: "{{route('ajax.semillados.getSemillados')}}",
                getSemillado: "{{route('ajax.semillados.getSemillado')}}",
                editSemillado: "{{route('ajax.semillados.editSemillado')}}",
                deleteSemillado: "{{route('semillados.delete')}}"
            },
            data: {
                campActiva: "{{$campActiva}}"
            },
            session: {
                exito: "{{session()->pull('exito')}}",
                error: "{{session()->pull('error')}}"
            }
        };
    </script>

    <script src="{{asset('js/semillado/ordenes.js')}}"></script>
@endsection

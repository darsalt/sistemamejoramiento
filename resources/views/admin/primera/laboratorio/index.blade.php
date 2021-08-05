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
            <label for="serie" class="col-1 col-form-label">Serie: </label>
            <div class="col-2">
                <select name="serie" id="serie" class="form-control">
                    <option value="0" selected disabled>(Ninguna)</option>
                    @foreach ($series as $serie)
                        <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                    @endforeach
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
                    <th>Serie</th>
                    <th>Ambiente</th>
                    <th>Subambiente</th>
                    <th>Sector</th>
                    <th>Campaña Seedling</th>
                    <th>Parcela</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Seleccionado</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($seedlings))
                    @foreach ($seedlings as $primera)
                        <tr>
                            <td>{{$primera->serie->nombre}}</td>
                            <td>{{$primera->sector->subambiente->ambiente->nombre}}</td>
                            <td>{{$primera->sector->subambiente->nombre}}</td>
                            <td>{{$primera->sector->nombre}}</td>
                            <td>{{$primera->seedling->campania->nombre}}</td>
                            <td>{{$primera->seedling->parcela}}</td>
                            <td>{{$primera->fecha}}</td>
                            <td>{{$primera->cantidad}}</td>
                            <td>{{$primera->parceladesde}}</td>
                            <td>{{$primera->parceladesde + $primera->cantidad - 1}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input check-laboratorio" value="{{$primera->id}}" {{$primera->laboratorio ? 'checked' : ''}}
                                style="width: 15px; height: 15px;">
                            </td>
                        </tr>
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
                saveLaboratorio: "{{url('admin/primera/laboratorio')}}"
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

    <script src="{{asset('js/primera/laboratorio.js')}}"></script>
@endsection
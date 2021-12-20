@extends('admin.layout')
@section('titulo', 'Egresos de semillas')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Egresos &nbsp; <a href="{{route('inventario.egresos.create')}}" class="btn btn-success">Nuevo egreso</a></h3> 
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
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Campaña</th>
					<th>Madre x Padre</th>
					<th>Motivo</th>
					<th>Cantidad</th>
					<th>Fecha egreso</th>
					<th>Observaciones</th>
					<th></th>				
				</thead>
                <tbody>
                    @foreach ($egresos as $e)
                        <tr>
                            <td>{{$e->nombre_campania}}</td>
                            <td>{{$e->madre}} - {{$e->padre}}</td>
                            <td>{{$e->nombre_motivo}}</td>
                            <td>{{$e->cantidad}}</td>
                            <td>{{$e->fecha_egreso}}</td>
                            <td>{{$e->observaciones}}</td>
                            <td>
                                <a href="{{route('inventario.egresos.edit', $e->id)}}"><i class="fa fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                <a href="" data-target="#modal-delete" data-toggle="modal" data-id="{{$e->id}}" class="btnDelete"> <i class="fa fa-trash fa-lg"></i></a>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete">
    <form action="{{route('inventario.egresos.delete')}}" method="POST">
        @csrf
        @method('delete')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Baja de Egreso</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="number" name="id_egreso" id="idEgreso" hidden>
                    <p>Confirme que desea dar de baja el egreso</p>
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
    <script>
        if("{{session()->pull('exito')}}")
            mostrarMensajeExito();

        if("{{session()->pull('error')}}")
            mostrarMensajeError();

        $('.btnDelete').click(function(){
            var boton = $(this);

            $('#modal-delete').ready(function(){
                idEgreso = boton.data('id');
                $(this).find('#idEgreso').val(idEgreso);
            });
        });
    </script>
@endsection
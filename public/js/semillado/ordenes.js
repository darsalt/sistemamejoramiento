$(document).ready(function(){
    $('#campSemillado').val(config.data.campActiva);
    
    console.log(config.session.exito);
    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    $.ajax({
        url: config.routes.getUltimaOrden,
        type: 'GET',
        data: {
            'campania':  $('#campSemillado').val()
        },
        success: function(response){
            $('#nroOrden').text(response + 1);
        }
    });

    // Validacion de los campos
    $('#formSemillado').validate({
        rules: {
            campSemillado:{
                min: 1
            },
            campCruzamiento:{
                min: 1
            },
            fechaSemillado: {
                required: true
            },
            nroCruza: {
                required: true,
                min: 1
            },
            cantGramos: {
                required: true,
                min: 1,
                max: function(element){
                    return parseInt($('#stockActual').text());
                }
            },
            cantCajones: {
                required: true,
                min: 1
            }
        },
        messages:{
            campSemillado:{
                min: 'Seleccione una campaña'
            }, 
            campCruzamiento:{
                min: 'Seleccione una campaña'
            }, 
            nroCruza:{
                min: 'Seleccione una cruza'
            }, 
            cantGramos:{
                max: 'Debe ser menor o igual al stock'
            }
        },
        submitHandler: function(form){
            var operation = $(form).attr('operation');
            
            if(operation == 'insert'){
                $.ajax({
                    url: config.routes.saveSemillado,
                    method: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        // Resetear algunos campos
                        $('#nroOrden').text('');
                        $('#cantCajones').val('');
                        $('#cantPlantas').text('');
                        $('#stockActual').text('');

                        $('#nroOrden').text(response.numero + 1); // Nro. de orden es el siguiente al que se guardó
                        $('#stockActual').text(response.cruzamiento.semilla.stockactual);
                        $('#cantGramos').focus();

                        $('#tablaOrdenes tbody').append(agregarFila(response)); // Agrego fila a la tabla

                        mostrarMensajeExito();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
            else{
                $.ajax({
                    url: config.routes.editSemillado,
                    method: 'PUT',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        $('#campCruzamiento').val('0');
                        $('#fechaSemillado').val('');
                        $('#nroCruza').empty();
                        $('#nroOrden').empty();
                        $('#stockActual').empty();
                        $('#cantGramos').val('');
                        $('#poderGerminativo').empty();
                        $('#cantCajones').val('');
                        $('#campSemillado').focus();

                        location.reload();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
        }
    });

    // Recargar pagina al seleccionar una campania de semillado
    $('#campSemillado').on('change', function(){
        window.location.href = config.routes.ordenes + "/" + $('#campSemillado').val();
    });

    // Click sobre el combo de campania de cruzamiento
    $('#campCruzamiento').on('change', function(){
        var campaniaCruzamiento = $(this).children('option:selected').val();

        // Obtener cruzamientos segun la campania
        $.ajax({
            url: config.routes.getCruzamientos,
            type: 'GET',
            data: {
                'campania': campaniaCruzamiento
            },
            success: function(response){
                $('#nroCruza').empty();
                
                $.each(response, function(i, item){
                    $('#nroCruza').append("<option value='" + item.id + "'>" + item.id + " - Madre: " + item.madre.nombre + ", Padre: " + item.padre.nombre + "</option>");
                });
                rellenarCamposSemilla();
            }
        });
    });

    // Al seleccionar el cruzamiento obtener los datos de la semilla
    $('#nroCruza').on('change', function(){
        rellenarCamposSemilla();
    });

    // Calcular poder germinativo al ingresar cantidad de gramos
    $('#cantGramos').on('change', function(){
        $('#cantPlantas').text($(this).val() * parseInt($('#poderGerminativo').text()));
    });

    // Mostrar modal al hacer click en eliminar
    $('.deleteBtn').on('click', function(){
        var id = $(this).data('id');

        $('#formDelete').attr('action', config.routes.deleteSemillado + "/" + id);
        $('#modal-delete').modal('show');
    });
});

// Rellenar los campos de la semilla segun el cruzamiento
function rellenarCamposSemilla(){
    var cruzamiento = $('#nroCruza').children('option:selected').val();

    $.ajax({
        url: config.routes.getSemilla,
        type: 'GET',
        data: {
            'cruzamiento': cruzamiento
        },
        success: function(response){
            $('#stockActual').empty();
            $('#poderGerminativo').empty();
            $('#stockActual').text(response.stockactual);
            $('#poderGerminativo').text(response.podergerminativo);
        }
    });
}

// Agregar una fila a la tabla de ordenes de semillado
function agregarFila(element){
    let fila = '';

    fila += "<tr>";
    fila += "<td>" + element.numero + "</td>";
    fila += "<td>" + element.campania.nombre + "</td>";
    fila += "<td>" + element.cruzamiento.campania_cruzamiento.nombre + "</td>";
    fila += "<td>" + element.fechasemillado + "</td>";
    fila += "<td>" + element.idcruzamiento + "</td>";
    fila += "<td>" + element.gramos + "</td>"
    fila += "<td>" + element.cruzamiento.semilla.podergerminativo + "</td>";
    fila += "<td>" + element.gramos * element.cruzamiento.semilla.podergerminativo + "</td>";
    fila += "<td>" + element.cajones + "</td>";
    fila += "<td><button class='btn editBtn' onclick='editarSemillado(" + element.idsemillado + ")'><i class='fa fa-edit fa-lg'></i></button>"
    fila += "<button class='btn deleteBtn' data-id='" + element.idsemillado + "'><i class='fa fa-trash fa-lg'></i></button></td>"
    fila += '</tr>'

    return fila;
}

// Colocar el semillado a editar en el form 
function editarSemillado(id){
    $.ajax({
        url: config.routes.getSemillado,
        method: 'GET',
        data: {
            id: id
        },
        success: function(response){
            $('#idSemillado').val(response.idsemillado);
            $('#campCruzamiento').val(response.cruzamiento.campania_cruzamiento.id);
            $('#campCruzamiento').trigger('change');
            $('#fechaSemillado').val(response.fechasemillado);
            $('#nroCruza').val(response.cruzamiento.id);
            $('#nroOrden').text(response.numero);
            $('#cantGramos').val(response.gramos);
            $('#cantCajones').val(response.cajones);
            $('#nroCruza').trigger('change');
            $('#cantPlantas').text(response.gramos * response.cruzamiento.semilla.podergerminativo);
            $('#formSemillado').attr('operation', 'edit'); // Cambiar el tipo de operacion del form, por defecto es insert
            $('#formSemillado button[type="submit"] i').removeClass(['fa-check', 'fa-edit']);
            $('#formSemillado button[type="submit"] i').addClass('fa-edit');
            $('#campSemillado').focus();
        }
    });
}

function mostrarMensajeExito(){
    $('#msgExito').fadeIn();
    $('#msgExito').delay(2000).fadeOut();
}

function mostrarMensajeError(){
    $('#msgError').fadeIn();
    $('#msgError').delay(2000).fadeOut();
}
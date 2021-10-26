$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#campSeedling').val(config.data.campActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector').select2();
    $('#ordenSemillado').select2();
    $('#variedad').select2();

    $('#campSeedling').focus();

    // Validacion de los campos
    $('#formSeedling').validate({
        rules: {
            campSeedling:{
                required: true,
                min: 1
            },
            ambiente:{
                required: true,
                min: 1
            },
            subambiente: {
                required: true,
                min: 1
            },
            sector: {
                required: true,
                min: 1
            },
            fecha: {
                required: true
            },
            origen: {
                required: true,
            },
            campSemillado: {
                required: function(){
                    if($('#origen').val() == 'cruzamiento')
                        return true;
                    else
                        return false;
                },
                min: function(){
                    if($('#origen').val() == 'cruzamiento')
                        return 1;
                    else
                        return 0;
                }
            },
            ordenSemillado: {
                required: function(){
                    if($('#origen').val() == 'cruzamiento')
                        return true;
                    else
                        return false;
                },
                min: function(){
                    if($('#origen').val() == 'cruzamiento')
                        return 1;
                    else
                        return 0;
                }
            },
            variedad: {
                required: function(){
                    if($('#origen').val() == 'testigo')
                        return true;
                    else
                        return false;
                }
            },
            observacion: {
                required: function(){
                    if($('#origen').val() == 'n/i')
                        return true;
                    else
                        return false;
                }
            },
            surcos: {
                required: true,
                min: 1
            },
            plantasxsurco: {
                required: true,
                min: 1
            }
        },
        messages:{
            campSeedling:{
                min: 'Seleccione una campaña'
            }, 
            ambiente:{
                min: 'Seleccione un ambiente'
            },
            subambiente:{
                min: 'Seleccione un subambiente'
            }, 
            sector:{
                min: 'Seleccione un sector'
            },  
            origen:{
                max: 'Seleccione un origen'
            },
            campSemillado:{
                min: 'Seleccione una campaña'
            }, 
            campSemillado:{
                min: 'Seleccione un origen'
            }, 
        },
        submitHandler: function(form){
            var operation = $(form).attr('operation');
            
            if(operation == 'insert'){
                $.ajax({
                    url: config.routes.saveSeedling,
                    method: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        // Resetear algunos campos
                        $('#orden').val(0);
                        /* $('#tabla').val('');
                        $('#tablita').val('');
                        $('#plantasxsurco').val(''); */
                        $('#surcos').val('');
                        $('#origen').val('cruzamiento');
                        $('#origen').trigger('change');

                        $('#parcela').text(response.parcela + 1); // Nro. de parcela es el siguiente al que se guardó
                        $('#campSeedling').focus();

                        $('#tablaSeedlings tbody').append(agregarFila(response)); // Agrego fila a la tabla

                        mostrarMensajeExito();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
            else{
                $.ajax({
                    url: config.routes.editSeedling,
                    method: 'PUT',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        location.reload();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
        }
    });

    // Obtener la ultima parcela cargada
    $.ajax({
        url: config.routes.getUltimaParcela,
        type: 'GET',
        data: {
            'campania':  $('#campSeedling').val()
        },
        success: function(response){
            $('#parcela').text(response + 1);
        }
    });

    // Evento del boton para mostrar u ocultar formulario
    $('#btnToggleForm').click(function(){
        var form = $('#formSeedling');
        form.fadeToggle();
    
        $(this).text() == 'Mostrar formulario' ? $(this).text('Ocultar formulario') : $(this).text('Mostrar formulario');
    });

    // Evento cuando se selecciona una campaña de seedling
    $('#campSeedling').change(function(){
        window.location.href = config.routes.seedlings + "/" + $('#campSeedling').val();
    });

    // Evento para cuando se selecciona un ambiente
    $('#ambiente').change(function(event, idsubambiente = 0, idsector = 0){
        var ambiente = $(this).children('option:selected').val();

        // Obtener subambientes pertenecientes al ambiente
        $.ajax({
            url: config.routes.getSubambientes,
            type: 'GET',
            data: {
                'ambiente': ambiente
            },
            success: function(response){
                $('#subambiente').empty();
                
                $.each(response, function(i, item){
                    $('#subambiente').append("<option value='" + item.id + "'>" + item.nombre + "</option>");
                });

                if(idsubambiente > 0)
                    $('#subambiente').val(idsubambiente);

                $('#subambiente').trigger('change', [idsector]);
            }
        });
        $(this).trigger('blur');
    });

    // Evento para cuando se selecciona un subambiente
    $('#subambiente').change(function(event, idsector = 0){
        var subambiente = $(this).children('option:selected').val();

        // Obtener sectores pertenecientes al subambiente
        $.ajax({
            url: config.routes.getSectores,
            type: 'GET',
            data: {
                'subambiente': subambiente
            },
            success: function(response){
                $('#sector').empty();
                
                $.each(response, function(i, item){
                    $('#sector').append("<option value='" + item.id + "'>" + item.nombre + "</option>");
                });

                if(idsector > 0)
                    $('#sector').val(idsector);

                $('#sector').trigger('change');
            }
        });
        $(this).trigger('blur');
    });

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        $(this).trigger('blur');
    });

    // Evento para cuando se selecciona el origen
    $('#origen').change(function(){
        switch($(this).val()){
            case 'cruzamiento':
                $('.col-campania').show();
                $('.col-orden').show();
                $('.col-progenitores').show();
                $('.col-variedad').hide();
                $('.col-observacion').hide();
                break;
            case 'testigo':
                $('.col-campania').hide();
                $('.col-orden').hide();
                $('.col-progenitores').hide();
                $('.col-observacion').hide();
                $('.col-variedad').show();
                break;
            case 'n/i':
                $('.col-campania').hide();
                $('.col-orden').hide();
                $('.col-progenitores').hide();
                $('.col-variedad').hide();
                $('.col-observacion').show();
                break;
        }
    });

    // Evento para cuando se selecciona la campaña de semillado
    $('#campSemillado').change(function(event, idsemillado = 0){
        $.ajax({
            url: config.routes.getSemillados,
            type: 'GET',
            data: {
                'campania': $(this).val()
            },
            success: function(response){
                $('#ordenSemillado').empty();
                
                $.each(response, function(i, item){
                    $('#ordenSemillado').append("<option value='" + item.idsemillado + "'>" + item.numero + "</option>");
                });
                
                if(idsemillado > 0)
                    $('#ordenSemillado').val(idsemillado);

                $('#ordenSemillado').trigger('change');
            }
        });
    });

    // Evento al elegir orden
    $('#ordenSemillado').change(function(){
        $.ajax({
            url: config.routes.getProgenitoresSemillado,
            type: 'GET',
            data: {
                'id': $(this).val()
            },
            success: function(response){
                $('#progenitores').text(response.madre.nombre + ' - ' + response.padre.nombre);
            }
        });
    });

    // Mostrar modal al hacer click en eliminar
    $('.deleteBtn').on('click', function(){
        var id = $(this).data('id');

        $('#formDelete').attr('action', config.routes.deleteSeedling + "/" + id);
        $('#modal-delete').modal('show');
    });
});

function mostrarMensajeExito(){
    $('#msgExito').fadeIn();
    $('#msgExito').delay(2000).fadeOut();
}

function mostrarMensajeError(){
    $('#msgError').fadeIn();
    $('#msgError').delay(2000).fadeOut();
}

// Agregar una fila a la tabla de seedlings
function agregarFila(element){
    let fila = '';

    fila += "<tr>";
    fila += "<td>" + element.parcela + "</td>";
    if(element.semillado){
        fila += "<td>" + element.semillado.campania.nombre + "</td>"
        fila += "<td>" + element.semillado.numero + "</td>";
    }
    else{
        fila += "<td>-</td>"
        fila += "<td>-</td>";
    }
    if(element.origen == 'testigo')
        fila += "<td>" + element.variedad.nombre + "</td>";
    else{
        if(element.origen == 'n/i')
            fila += "<td>" + element.observaciones + "</td>";
        else
            fila += "<td>" + element.semillado.cruzamiento.madre.nombre + " - " + element.semillado.cruzamiento.padre.nombre +"</td>";
    }
    fila += "<td>" + element.tabla + "</td>";
    fila += "<td>" + element.tablita + "</td>";
    fila += "<td>" + element.surcos + "</td>";
    fila += "<td>" + element.plantasxsurco + "</td>";
    fila += "<td><button class='btn editBtn' onclick='editarSeedling(" + element.id + ")'><i class='fa fa-edit fa-lg'></i></button>"
    fila += "<button class='btn deleteBtn' data-id='" + element.id + "'><i class='fa fa-trash fa-lg'></i></button></td>"
    fila += '</tr>'

    return fila;
}

// Colocar el seedling a editar en el form 
function editarSeedling(id){
    $.ajax({
        url: config.routes.getSeedling,
        method: 'GET',
        data: {
            id: id
        },
        success: function(response){
            $('#idSeedling').val(response.id);
            $('#campSeedling').val(response.idcampania);
            $('#ambiente').val(response.sector.subambiente.ambiente.id);
            $('#ambiente').trigger('change', [response.sector.subambiente.id, response.idsector]);
            $('#fecha').val(response.fecha_plantacion);
            $('#parcela').text(response.parcela);
            $('#origen').val(response.origen);
            $('#variedad').val(response.idvariedad);
            $('#variedad').select2();
            $('#origen').trigger('change');
            if(response.semillado){
                $('#campSemillado').val(response.semillado.idcampania);
                $('#campSemillado').trigger('change', [response.idsemillado]);
            }
            $('#tabla').val(response.tabla);
            $('#tablita').val(response.tablita);
            $('#surcos').val(response.surcos);
            $('#plantasxsurco').val(response.plantasxsurco);

            $('#formSeedling').attr('operation', 'edit'); // Cambiar el tipo de operacion del form, por defecto es insert
            $('#formSeedling button[type="submit"] i').removeClass(['fa-check', 'fa-edit']);
            $('#formSeedling button[type="submit"] i').addClass('fa-edit');
            $('#campSeedling').focus();
        }
    });
}

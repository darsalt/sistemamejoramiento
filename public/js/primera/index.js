$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#serie').val(config.data.serieActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela').select2();

    $('#serie').focus();

    if(sessionStorage.getItem('anio'))
        $('#anio').val(sessionStorage.getItem('anio'));

    // Validacion de los campos
    $('#formPrimeraClonal').validate({
        rules: {
            serie: {
                required: true,
                min: 1
            },
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
            parcela: {
                required: true,
            },
            parcelaDesde: {
                number: true,
            },
            parcelaHasta: {
                number: true,
                min: function(){
                    return $('#parcelaDesde').val();
                }
            },
        },
        messages:{
            serie:{
                min: 'Seleccione una serie'
            }, 
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
            parcelaHasta: {
                min: "No puede ser menor que Desde"
            },
        },
        submitHandler: function(form){
            var operation = $(form).attr('operation');
            
            if(operation == 'insert'){
                $.ajax({
                    url: config.routes.savePrimeraClonal,
                    method: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        // Resetear algunos campos
                        $('#cantidad').val('');

                        $('#parcelaDesde').val(response.parceladesde + response.cantidad); // Nro. de parcela es el siguiente al que se guardó
                        $('#parcelaHasta').val('');
                        $('#cantidad').text('');
                        $('#serie').focus();

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
                    url: config.routes.editPrimeraClonal,
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
            'serie':  $('#serie').val()
        },
        success: function(response){
            $('#parcelaDesde').val(response + 1);
        }
    });

    // Evento del boton para mostrar u ocultar formulario
    $('#btnToggleForm').click(function(){
        var form = $('#formPrimeraClonal');
        form.fadeToggle();
    
        $(this).text() == 'Mostrar formulario' ? $(this).text('Ocultar formulario') : $(this).text('Mostrar formulario');
    });

    $('#anio').change(function(){
        sessionStorage.setItem('anio', $('#anio').val())
    });

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.seedlings + "/" + $('#serie').val()  + "/" + $('#sector').val();
    });

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        if($('#serie').val() > 0)
            window.location.href = config.routes.seedlings + "/" + $('#serie').val() + "/" + $('#sector').val();
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
                
                $('#subambiente').append("<option value='0' selected disabled>(Ninguno)</option>");
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

    $('#ambiente').val(config.data.ambienteActivo);
    $('#ambiente').trigger('change', [config.data.subambienteActivo, config.data.sectorActivo]);

    // Evento para cuando se selecciona un subambiente
    $('#subambiente').change(function(event, idsector = 0){
        var subambiente = $(this).children('option:selected').val();

        // Obtener lotes pertenecientes al subambiente
        $.ajax({
            url: config.routes.getSectores,
            type: 'GET',
            data: {
                'subambiente': subambiente
            },
            success: function(response){
                $('#sector').empty();
                
                $('#sector').append("<option value='0' selected disabled>(Ninguno)</option>");
                $.each(response, function(i, item){
                    $('#sector').append("<option value='" + item.id + "'>" + item.nombre + "</option>");
                });

                if(idsector > 0)
                    $('#sector').val(idsector);
            }
        });
        $(this).trigger('blur');
    });

    // Evento para cuando se selecciona la campaña de seedling
    $('#campSeedling').change(function(parcela = 0){
        $.ajax({
            url: config.routes.getSeedlings,
            type: 'GET',
            data: {
                'campania': $(this).val()
            },
            success: function(response){
                $('#parcela').empty();
                
                $.each(response, function(i, item){
                    $('#parcela').append("<option value='" + item.id + "'>" + item.parcela + "</option>");
                });

                $('#parcela').trigger('change');
            }
        });
    });

    // Evento al ingresar la cantidad
    $('#parcelaHasta').keyup(function(){
        $('#cantidad').text(parseInt($(this).val()) - parseInt($('#parcelaDesde').val()) + 1);
    });

    // Evento al elegir parcela
    $('#parcela').change(function(){
        $.ajax({
            url: config.routes.getProgenitoresSeedling,
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

        $('#formDelete').attr('action', config.routes.deletePrimeraClonal + "/" + id);
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
    fila += "<td>" + element.seedling.campania.nombre + "</td>";
    fila += "<td>" + element.seedling.parcela + "</td>";
    fila += "<td>" + element.seedling.semillado.cruzamiento.madre.nombre + " - " + element.seedling.semillado.cruzamiento.padre.nombre + "</td>";
    fila += "<td>" + element.parceladesde + "</td>";
    fila += "<td>" + (element.parceladesde + element.cantidad - 1) + "</td>";
    fila += "<td>" + element.cantidad + "</td>";
    fila += "<td><button class='btn editBtn' onclick='editarSeedling(" + element.id + ")'><i class='fa fa-edit fa-lg'></i></button>"
    fila += "<button class='btn deleteBtn' data-id='" + element.id + "'><i class='fa fa-trash fa-lg'></i></button></td>"
    fila += '</tr>'

    return fila;
}

// Colocar el seedling a editar en el form 
function editarSeedling(id){
    $.ajax({
        url: config.routes.getPrimeraClonal,
        method: 'GET',
        data: {
            id: id
        },
        success: function(response){
            $('#idSeedling').val(response.id);
            $('#anio').val(response.anio);
            $('#serie').val(response.idserie);
            $('#ambiente').val(response.sector.subambiente.ambiente.id);
            $('#ambiente').trigger('change', [response.sector.subambiente.id, response.idsector]);
            $('#campSeedling').val(response.seedling.idcampania);
            $('#campSeedling').trigger('change', [response.seedling.parcela]);
            $('#parcelaDesde').val(response.parceladesde);
            $('#parcelaHasta').val(response.parceladesde + response.cantidad - 1);
            $('#cantidad').text(response.cantidad);

            $('#formPrimeraClonal').attr('operation', 'edit'); // Cambiar el tipo de operacion del form, por defecto es insert
            $('#formPrimeraClonal button[type="submit"] i').removeClass(['fa-check', 'fa-edit']);
            $('#formPrimeraClonal button[type="submit"] i').addClass('fa-edit');
            $('#serie').focus();
        }
    });
}

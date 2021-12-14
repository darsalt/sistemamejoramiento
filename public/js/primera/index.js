$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#serie').val(config.data.serieActiva);

    if($('#serie').val() > 0)
        loadAnioSerie($('#serie').val());

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela, .testigoVariedades').select2();

    $('#serie').focus();

    if(config.data.serieActiva > 0 && config.data.sectorActivo > 0)
        $('#btnAddTestigos').show();

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
            /*parcelaHasta: {
                number: true,
                min: function(){
                    return $('#parcelaDesde').val();
                }
            },*/
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

                        //$('#parcelaDesde').val(parseInt(response.parceladesde) + response.cantidad); // Nro. de parcela es el siguiente al que se guardó
                        obtenerUltimaParcelaCargada();
                        $('#parcelaHasta').val('');
                        $('#cantidad').text('');
                        $('#serie').focus();

                        $('#bodyTablaSeedlings').append(agregarFila(response)); // Agrego fila a la tabla

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

    obtenerUltimaParcelaCargada();

    // Evento del boton para mostrar u ocultar formulario
    $('#btnToggleForm').click(function(){
        var form = $('#formPrimeraClonal');
        form.fadeToggle();
    
        $(this).text() == 'Mostrar formulario' ? $(this).text('Ocultar formulario') : $(this).text('Mostrar formulario');
    });

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.seedlings + "/" + $('#serie').val()  + "/" + $('#sector').val();
        else
            loadAnioSerie($('#serie').val());
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
    $('#campSeedling').change(function(event, parcela = 0){
        $.ajax({
            url: config.routes.getSeedlings,
            type: 'GET',
            data: {
                'campania': $(this).val(),
                'sector': $('#sector').val()
            },
            success: function(response){
                $('#parcela').empty();
                
                $.each(response, function(i, item){  
                    $('#parcela').append("<option value='" + item.id + "'>" + item.parcela + "</option>");
                });

                if(parcela > 0)
                    $('#parcela').val(parcela);

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
                if(response.origen == 'cruzamiento')
                    $('#progenitores').text(response.madre.nombre + ' - ' + response.padre.nombre);
                else{
                    if(response.origen == 'testigo')
                        $('#progenitores').text(response.variedad);
                    else
                        $('#progenitores').text(response.observaciones);
                }
            }
        });
    });

    // Mostrar modal al hacer click en eliminar
    $('.deleteBtn').on('click', function(){
        var id = $(this).data('id');

        $('#formDelete').attr('action', config.routes.deletePrimeraClonal + "/" + id);
        $('#modal-delete').modal('show');
    });

    // Evento cuando se agrega una nueva fila para los testigos
    $('#btnAddRowTestigo').click(function(){
        let tableBody =  $('#tablaTestigos').find('tbody');
        let trLast = tableBody.find("tr:last");

        $('.testigoVariedades').select2('destroy'); // Eliminar el select2 para no tener conflictos en el clone
        trLast.after(trLast.clone())
        $('.testigoVariedades').select2(); // Volver a aplicar select2 a todos
    });

    // Evento cuando se apreta en el boton de guardar testigos
    $('#btnGuardarTestigos').click(function(e){
        e.preventDefault();

        $.ajax({
            url: config.routes.saveTestigos,
            method: 'POST',
            dataType: 'json',
            data: $('#formTestigos').serialize() + "&serie=" + config.data.serieActiva  + "&sector=" + config.data.sectorActivo,
            success: function(response){
                window.location.href = config.routes.seedlings + "/" + config.data.serieActiva  + "/" + config.data.sectorActivo;
            },
            error: function( jqXHR, textStatus, errorThrown ){
                window.location.href = config.routes.seedlings + "/" + config.data.serieActiva  + "/" + config.data.sectorActivo;
            }
        });
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

// Obtener la ultima parcela cargada
function obtenerUltimaParcelaCargada(){
    $.ajax({
        url: config.routes.getUltimaParcela,
        type: 'GET',
        data: {
            'serie': config.data.serieActiva,
            'sector': config.data.sectorActivo,
        },
        success: function(response){
            $('#parcelaDesde').val(response + 1);
        }
    });
}

// Agregar una fila a la tabla de seedlings
function agregarFila(element){
    let fila = '';

    $.each(element.parcelas, function(i, item){
        fila += "<tr>";
        fila += "<td>" + parseInt(item.parcela) + "</td>";
        fila += "<td>" + item.nombre_clon + "</td>";
        fila += "<td>" + element.seedling.parcela + "</td>";
        if(element.seedling.origen == 'cruzamiento')
            fila += "<td>" + element.seedling.semillado.cruzamiento.madre.nombre + " - " + element.seedling.semillado.cruzamiento.padre.nombre + "</td>";
        else{
            if(element.seedling.origen == 'testigo')
                fila += "<td>" + element.seedling.variedad.nombre + "</td>";
            else
                fila += "<td>" + element.seedling.observaciones + "</td>";
        }
        fila += "<td><button class='btn editBtn' onclick='editarSeedling(" + element.id + ")'><i class='fa fa-edit fa-lg'></i></button>"
        fila += "<button class='btn deleteBtn' data-id='" + element.id + "'><i class='fa fa-trash fa-lg'></i></button></td>"
        fila += "</tr>";
    });
    fila += "</tbody></table></td>";
    fila += "</tr>";

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
            $('#serie').val(response.idserie);
            $('#ambiente').val(response.sector.subambiente.ambiente.id);
            $('#ambiente').trigger('change', [response.sector.subambiente.id, response.idsector]);
            $('#campSeedling').val(response.seedling.idcampania);
            $('#campSeedling').trigger('change', [response.seedling.id]);
            $('#parcelaDesde').val(parseInt(response.parceladesde));
            $('#parcelaHasta').val(parseInt(response.parceladesde) + response.cantidad - 1);
            $('#cantidad').text(response.cantidad);

            $('#formPrimeraClonal').attr('operation', 'edit'); // Cambiar el tipo de operacion del form, por defecto es insert
            $('#formPrimeraClonal button[type="submit"] i').removeClass(['fa-check', 'fa-edit']);
            $('#formPrimeraClonal button[type="submit"] i').addClass('fa-edit');
            $('#serie').focus();
        }
    });
}

function loadAnioSerie(idSerie){
    $.ajax({
        url: config.routes.getAnioSerie,
        method: 'GET',
        dataType: 'json',
        data: {
            'serie': idSerie
        },
        success: function(response){
            $('#anio').text(response);
        }
    });
}
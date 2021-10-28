$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#anio').val(config.data.anioActivo);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela, #seedlingsSC, #variedad').select2();

    $('#tableSeedlingsSC').paging({
        limit: 10,
    });

    if(sessionStorage.getItem('serie')){
        $('#serie').val(sessionStorage.getItem('serie'));
    }

    // Verificar si ya hay cargado un MET para el mismo anio y ubicacion
    chequearMETCargado();

    ocultarInputsCarga();
    //habilitarDeshabilitarSeedlings($('#anio').val(), config.data.sectorActivo);

    $('#anio').focus();

    // Validacion de los campos
    $('#formSegundaClonal').validate({
        rules: {
            serie: {
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
            cantVariedades: {
                required: true,
                number: true,
            },
            repeticiones: {
                required: true,
                number: true,
            },
            cantBloques: {
                required: true,
            }
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
            }
        },
        submitHandler: function(form){
            var operation = $(form).attr('operation');
            
            if(operation == 'insert'){
               $.ajax({
                    url: config.routes.saveMET,
                    method: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        window.location.href = config.routes.met + "/" + $('#anio').val()  + "/" + $('#sector').val();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                }); 
            }
        }
    });

    $('#formSeedlings').validate({
        submitHandler: function(form){
            $.ajax({
                url: config.routes.saveDetalleMET,
                method: 'POST',
                dataType: 'json',
                data: $(form).serialize() + '&anio=' + $('#anio').val() + '&sector=' + config.data.sectorActivo + '&nroParcela=' + $('#nroParcela').val() + '&nroBloque=' + $('#nroBloque').val(),
                success: function(response){
                    $('#tablaParcelasCargadas tbody').append(agregarFila(response)); // Agrego fila a la tabla
                    $('#nroParcela').val(parseInt($('#nroParcela').val()) + 1);
                    calcularNroBloque();
                    mostrarMensajeExito();
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    mostrarMensajeError();
                }
            });
        }
    });

    // Evento cuando se selecciona una serie
    $('#anio').change(function(){
        window.location.href = config.routes.met + "/" + $('#anio').val();
    });

    $('#serie').change(function(){
        sessionStorage.setItem('serie', $('#serie').val())
        $.ajax({
            url: config.routes.getSegundasClonales,
            method: 'GET',
            dataType: 'json',
            data: {
                'serie': $(this).val()
            },
            success: function(response){
                $('#seedlingsSC').empty();
                $('#seedlingsSC').append("<option value='0' selected disabled>(Ninguna)</option>");
                $.each(response, function(i, item){
                    if(item.parcela_p_c != null){
                        $('#seedlingsSC').append("<option value='" + item.id + "'>" + parseInt(item.parcela_p_c.parcela) + ' - Clon: ' + item.parcela_p_c.nombre_clon + "</option>");
                    }
                    else{
                        $('#seedlingsSC').append("<option value='" + item.id + "'>" + item.parcela + "</option>");
                    }
                });
            }
        });
    });

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        if($('#anio').val() > 0)
            window.location.href = config.routes.met + "/" + $('#anio').val() + "/" + $('#sector').val();
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

        // Obtener sectores pertenecientes al subambiente
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

    // Evento cuando se selecciona el origen
    $('#origenSeedling').change(function(){
        if($(this).val() == 'sc'){
            $('.col-seedlingsSC').show();
            $('.col-variedades').hide();
            $('.col-observaciones').hide();
        }
        else if($(this).val() == 'testigo'){
            $('.col-seedlingsSC').hide();
            $('.col-variedades').show();
            $('.col-observaciones').hide();
        }
        else if($(this).val() == 'otro'){
            $('.col-seedlingsSC').hide();
            $('.col-variedades').hide();
            $('.col-observaciones').show();
        }
    });

    $('#serie').trigger('change');
});

function habilitarDeshabilitarSeedlings(anio, idSector){
    $("input[name='seedlingsSC[]']:checked").removeAttr("checked");

    $("input[name='seedlingsSC[]'").each(function(){
        var mets = $(this).data('mets');
        var option = $(this);
        if(mets){
            mets.forEach(function(valor, i){
                if(valor.met.anio == anio && valor.idsector == idSector)
                    option.attr("checked", "checked");
            });
        }
    });
}

function chequearMETCargado(){
    if(config.data.sectorActivo > 0){
        $.ajax({
            url: config.routes.METAsociado,
            method: 'GET',
            dataType: 'json',
            data: {
                'anio': $('#anio').val(),
                'sector': config.data.sectorActivo
            },
            success: function(response){
                if(!jQuery.isEmptyObject(response)){
                    $('#cantVariedades').val(response.cant_variedades);
                    $('#cantVariedades').attr('disabled', 'disabled');
                    $('#repeticiones').val(response.repeticiones);
                    $('#repeticiones').attr('disabled', 'disabled');
                    $('#cantBloques').val(response.bloques);
                    $('#cantBloques').attr('disabled', 'disabled');
                    $('.col-submit').hide();
                    $('#formSegundaClonal').attr('operation', 'ninguna');
                    $('#divCargaSeedlings').show();

                    cargarProximaParcela();
                }
                else{
                    $('#cantVariedades').val('');
                    $('#cantVariedades').removeAttr('disabled');
                    $('#repeticiones').removeAttr('disabled');
                    $('#repeticiones').val('3');
                    $('#cantBloques').val('');
                    $('#cantBloques').removeAttr('disabled');
                    $('.col-submit').show();
                    $('#formSegundaClonal').attr('operation', 'insert');
                    $('#divCargaSeedlings').hide();
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){

            }
        });
    }
}

function ocultarInputsCarga(){
    $('.col-variedades').hide();
    $('.col-observaciones').hide();
}

function cargarProximaParcela(){
    $.ajax({
        url: config.routes.getUltimaParcela,
        method: 'GET',
        dataType: 'json',
        data: {
            'anio': $('#anio').val(),
            'sector': config.data.sectorActivo
        },
        success: function(response){
            $('#nroParcela').val(response + 1);
            calcularNroBloque();
        }
    });
}

function calcularNroBloque(){
    var seedlingsxBloque = ($('#cantVariedades').val() * $('#repeticiones').val()) / $('#cantBloques').val();

    $('#nroBloque').val(parseInt($('#nroParcela').val() / (seedlingsxBloque + 1)) + 1);
}

// Agregar una fila a la tabla de parcelas cargadas
function agregarFila(element){
    let fila = '';

    fila += "<tr>";
    fila += "<td>" + element.parcela + "</td>";
    fila += "<td>" + element.bloque + "</td>";
    if(element.parcela_s_c && element.parcela_s_c.parcela_p_c){
        fila += "<td>" + element.parcela_s_c.parcela_p_c.parcela + "</td>";
    }
    else
        fila += "<td>-</td>";
    
    if(element.parcela_s_c && element.parcela_s_c.parcela_p_c)
        fila += "<td>" + element.parcela_s_c.parcela_p_c.nombre_clon + "</td>";
    else{
        if(element.parcela_s_c)
            fila += "<td>" + element.parcela_s_c.variedad.nombre +"</td>";
        else{
            if(element.idvariedad)
                fila += "<td>" + element.variedad.nombre +"</td>";
            else
                fila += "<td>" + element.observaciones +"</td>";
        }
    }

    fila += '</tr>';

    return fila;
}
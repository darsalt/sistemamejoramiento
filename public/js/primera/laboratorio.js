$(document).ready(function(){
    // Seleccionar en el combo box la serie activa
    $('#serie').val(config.data.serieActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.laboratorio + "/" + $('#serie').val() + "/" + $('#sector').val();
    });

    // Evento cuando se selecciona un ambiente
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

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        if($('#serie').val() > 0)
            window.location.href = config.routes.laboratorio + "/" + $('#serie').val() + "/" + $('#sector').val();
    });

    // Evento al confirmar
    $('#btnConfirmar').click(function(){
        var selected = $('.check-laboratorio:checked');

        // Obtener los id de los seleccionados
        var selectedIds = $.map(selected, function(item, i){
            return item.getAttribute('value');
        });

        $.ajax({
            url: config.routes.saveLaboratorio + '/' + $('#serie').val() + '/' + $('#sector').val(),
            type: 'PATCH',
            data: {
                ids: selectedIds
            },
            success: function(response){
                if(response == true)
                    mostrarMensajeExito();
                else
                    mostrarMensajeError();
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
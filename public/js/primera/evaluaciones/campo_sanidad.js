$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#anio').val(config.data.anioActivo);
    $('#serie').val(config.data.serieActiva);
    $('#mes').val(config.data.mesActivo);
    $('#edad').val(config.data.edadActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

        
    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector').select2();

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

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        /*if($('#anio').val() > 0)
            window.location.href = config.routes.met + "/" + $('#anio').val() + "/" + $('#sector').val();*/
    });

    $('#buscar').on('click', function(){
        var ruta = '';
        if($('#anio').val() > 0 && $('#serie').val() > 0 && $('#sector').val() > 0 && $('#mes').val() > 0 && $('#edad').val() > 0){
            if(config.data.origen == 'pc')
                ruta = config.routes.evaluacionesPC;
            else{
                if(config.data.origen == 'sc')
                    ruta = config.routes.evaluacionesSC;
                else
                    ruta = config.routes.evaluacionesMET;
            }

            window.location.href = ruta + "/" + $('#anio').val() + "/" + $('#serie').val() + "/" + $('#sector').val() + "/" + $('#mes').val() + "/" + $('#edad').val();
        }
    });

    $('.ultimoCampo').focusout(function(){
        var fila = $(this).closest('tr');
        var idSeedling = fila.find('.idSeedling').val();
        var ruta = '';

        if(config.data.origen == 'pc')
            ruta = config.routes.saveEvaluacionPC;
        else{
            if(config.data.origen == 'sc')
                ruta = config.routes.saveEvaluacionSC;
            else
                ruta = config.routes.saveEvaluacionMET;
        }

        $.ajax({
            url: ruta,
            method: 'POST',
            data: {
                anio: config.data.anioActivo,
                serie: config.data.serieActiva,
                sector: config.data.sectorActivo,
                mes: config.data.mesActivo,
                edad: config.data.edadActiva,
                fecha: $('#fecha').val(),
                idSeedling: idSeedling,
                tipo: $('#tipo-'+idSeedling).val(),
                tallos: $('#tallos-'+idSeedling).val(),
                altura: $('#altura-'+idSeedling).val(),
                grosor: $('#grosor-'+idSeedling).val(),
                vuelco: $('#vuelco-'+idSeedling).val(),
                flor: $('#flor-'+idSeedling).val(),
                brix: $('#brix-'+idSeedling).val(),
                escaldad: $('#escaldad-'+idSeedling).val(),
                carbon: $('#carbon-'+idSeedling).val(),
                roya: $('#roya-'+idSeedling).val(),
                mosaico: $('#mosaico-'+idSeedling).val(),
                estaria: $('#estaria-'+idSeedling).val(),
                amarilla: $('#amarilla-'+idSeedling).val(),
            },
            success: function(response){
                //
            }
        });
    });
});
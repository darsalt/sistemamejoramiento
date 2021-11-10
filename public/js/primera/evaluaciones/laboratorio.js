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

    $('#anio, #serie, #sector, #mes, #edad').change(function(){
        if($('#anio').val() > 0 && $('#serie').val() > 0 && $('#sector').val() > 0 && $('#mes').val() > 0 && $('#edad').val() > 0)
            window.location.href = config.routes.evaluaciones + "/" + $('#anio').val() + "/" + $('#serie').val() + "/" + $('#sector').val() + "/" + $('#mes').val() + "/" + $('#edad').val();
    });

    $('.ultimoCampo').focusout(function(){
        var fila = $(this).closest('tr');
        var idSeedling = fila.find('.idSeedling').val();

        $.ajax({
            url: config.routes.saveEvaluacion,
            method: 'POST',
            data: {
                anio: config.data.anioActivo,
                serie: config.data.serieActiva,
                sector: config.data.sectorActivo,
                mes: config.data.mesActivo,
                edad: config.data.edadActiva,
                fecha: $('#fecha').val(),
                idSeedling: idSeedling,
                pesomuestra: $('#pesomuestra-'+idSeedling).val(),
                pesojugo: $('#pesojugo-'+idSeedling).val(),
                brix: $('#brix-'+idSeedling).val(),
                polarizacion: $('#polarizacion-'+idSeedling).val(),
                temperatura: $('#temperatura-'+idSeedling).val(),
                conductividad: $('#conductividad-'+idSeedling).val(),
            },
            success: function(response){
                $('#brixcorregido-'+idSeedling).text(response.brix_corregido.toFixed(2));
                $('#polenjugo-'+idSeedling).text(response.pol_jugo.toFixed(2));
                $('#pureza-'+idSeedling).text(response.pureza.toFixed(2));
                $('#rendimiento-'+idSeedling).text(response.rend_prob.toFixed(2));
                $('#polencania-'+idSeedling).text(response.pol_cania.toFixed(2));
            }
        });
    });
});
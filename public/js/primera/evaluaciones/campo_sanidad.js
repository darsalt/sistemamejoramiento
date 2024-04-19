$(document).ready(function(){
    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    $('#cant_registros').on('change', function(){
        $('#formSearch').trigger('submit');
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
                anio: config.data.evaluacion.anio,
                serie: config.data.evaluacion.idserie,
                sector: config.data.evaluacion.idsector,
                mes: config.data.evaluacion.mes,
                edad: config.data.evaluacion.idedad,
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
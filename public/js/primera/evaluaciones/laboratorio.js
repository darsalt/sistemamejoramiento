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
                pesomuestra: $('#pesomuestra-'+idSeedling).val(),
                pesojugo: $('#pesojugo-'+idSeedling).val(),
                brix: $('#brix-'+idSeedling).val(),
                polarizacion: $('#polarizacion-'+idSeedling).val(),
                temperatura: $('#temperatura-'+idSeedling).val(),
                fibra: $('#fibra-'+idSeedling).val(),
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
$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#serie').val(config.data.serieActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela').select2();

    $('#tableSeedlingsSC').paging({
        limit: 10,
    });

    if(sessionStorage.getItem('anio'))
        $('#anio').val(sessionStorage.getItem('anio'));

    habilitarDeshabilitarSeedlings($('#anio').val(), config.data.sectorActivo);

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
                        window.location.href = config.routes.met + "/" + $('#serie').val()  + "/" + $('#sector').val();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                }); 
            }
        }
    });

    $('#anio').change(function(){
        sessionStorage.setItem('anio', $('#anio').val())
        habilitarDeshabilitarSeedlings($('#anio').val(), config.data.sectorActivo);
    });

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        window.location.href = config.routes.met + "/" + $('#serie').val();
    });

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        if($('#serie').val() > 0)
            window.location.href = config.routes.met + "/" + $('#serie').val() + "/" + $('#sector').val();
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
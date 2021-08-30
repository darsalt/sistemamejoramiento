$(document).ready(function(){
    // Seleccionar en el combo box la campaña activa
    $('#serie').val(config.data.serieActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela').select2();

    // Multiselect para elegir los seedlings de primera clonal
    $('#seedlingsPC').multiselect({
        buttonWidth: '100%',
        nonSelectedText: 'Ninguno seleccionado',
        allSelectedText: 'Todos seleccionados',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Buscar',
        nSelectedText: 'seleccionados',
    });

    habilitarDeshabilitarSeedlings();

    $('#serie').focus();

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
            seedlings: {
                required: true
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
                    url: config.routes.saveSegundaClonal,
                    method: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        window.location.href = config.routes.segundaclonal + "/" + $('#serie').val()  + "/" + $('#sector').val();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
            else{
                $.ajax({
                    url: config.routes.editSegundaClonal,
                    method: 'PUT',
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function(response){
                        $('#seedlingsPC option').each(function(){
                            $(this).removeAttr("selected");
                        });

                        location.reload();
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        mostrarMensajeError();
                    }
                });
            }
        }
    });

    // Evento del boton para mostrar u ocultar formulario
    $('#btnToggleForm').click(function(){
       var form = $('#formPrimeraClonal');
       form.fadeToggle();

       $(this).text() == 'Mostrar formulario' ? $(this).text('Ocultar formulario') : $(this).text('Mostrar formulario');
    });

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.segundaclonal + "/" + $('#serie').val()  + "/" + $('#sector').val();
    });

    // Evento cuando se selecciona un sector
    $('#sector').change(function(){
        if($('#serie').val() > 0)
            window.location.href = config.routes.segundaclonal + "/" + $('#serie').val() + "/" + $('#sector').val();
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

    // Evento cuando se carga o elige una procedencia
    $('#procedencia').on('change', function(){
        var procedencia = $(this).val();

        $('#seedlingsPC').multiselect('deselectAll', true);
        $('#seedlingsPC option').each(function(){
            if(procedencia == 'L'){
                if($(this).data('laboratorio')){
                    $(this).addClass('d-none');
                }
            }
            else{
                $(this).removeClass('d-none');
            }
        });
        $('#seedlingsPC').multiselect('rebuild');
    });

    // Mostrar modal al hacer click en eliminar
    $('.deleteBtn').on('click', function(){
        var id = $(this).data('id');

        $('#formDelete').attr('action', config.routes.deleteSegundaClonal + "/" + id);
        $('#modal-delete').modal('show');
    });
});

// Colocar el seedling a editar en el form 
function editarSeedling(id){
    $.ajax({
        url: config.routes.getSegundaClonal,
        method: 'GET',
        data: {
            id: id
        },
        success: function(response){
            $('#idSeedling').val(response.id);
            $('#serie').val(response.idserie);
            $('#ambiente').val(response.sector.subambiente.ambiente.id);
            $('#ambiente').trigger('change', [response.sector.subambiente.id, response.idsector]);

            $('#formSegundaClonal').attr('operation', 'edit'); // Cambiar el tipo de operacion del form, por defecto es insert
            $('#formSegundaClonal button[type="submit"] i').removeClass(['fa-check', 'fa-edit']);
            $('#formSegundaClonal button[type="submit"] i').addClass('fa-edit');
            $('#serie').focus();

            habilitarDeshabilitarSeedlings(id);
        }
    });
}

// Funcion para habilitar/deshabilitar y seleccionar/deseleccionar los seedlings de PC que ya estan asociados a una SC
// Depende de la operación si es Insert o Edit
function habilitarDeshabilitarSeedlings(id){
    let operation = $('#formSegundaClonal').attr('operation');

    $('#seedlingsPC').find('option:selected').removeAttr("selected");
    if(operation == 'insert'){
        $('#seedlingsPC option').each(function(){
            if($(this).data('idsc')){
                $(this).attr("disabled", "disabled");
            }
        });
    }
    else{
        $('#seedlingsPC option').each(function(){
            $(this).removeAttr("disabled");
            if($(this).data('idsc') == id){
                $(this).attr("selected", "selected");
            }
        });
    }
    $('#seedlingsPC').multiselect('rebuild');
}
var ultimaParcela = 0;
var yaSeleccionados = 0;

$(document).ready(function(){    
    // Seleccionar en el combo box la serie activa
    $('#serie').val(config.data.serieActiva);

    if($('#serie').val() > 0)
        loadAnioSerie($('#serie').val());

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Aplicar select2 a combos box
    $('#ambiente, #subambiente, #sector, #parcela, #variedad').select2();

    /*$('#tableSeedlingsPC').paging({
        limit: 10,
    });*/
        
    //$('#anio').val(config.data.anioActivo);

    $.ajax({
        url: config.routes.getUltimaParcela,
        method: 'GET',
        ajaxType: 'json',
        data: {
            'serie': $('#serie').val(),
            'sector': config.data.sectorActivo
        },
        success: function(response){
            ultimaParcela = response;
        }
    });

    habilitarDeshabilitarSeedlings($('#serie').val(), config.data.sectorActivo);

    // De los campos parcela habilitados (es decir que son del sector activo) obtener el maximo
    /*if(config.data.anioActivo && config.data.sectorActivo){
        var contParcelas;

        maximaParcela = Math.max(...$("input[name='parcelas[]']:enabled").map(function(){return parseInt($(this).val());}).get());
        if(maximaParcela > 0)
            contParcelas = maximaParcela;
        else
            contParcelas = 0;
    }*/

    $('#serie').focus();

    // Habilitar el bloque para ingresar testigos cuando ya se eligio una serie
    if(config.data.serieActiva > 0 && config.data.sectorActivo > 0)
        $('#div-testigos').show();
    
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
        }
    });

    // Validacion de los campos para cargar testigos
    $('#formTestigos').validate({
        rules: {
            parcelaTestigo: {
                required: true,
                number: true
            }
        },
        submitHandler: function(form){
            $.ajax({
                url: config.routes.saveTestigo,
                method: 'POST',
                dataType: 'json',
                data: $(form).serialize() + "&serie=" + config.data.serieActiva + "&sector=" + config.data.sectorActivo,
                success: function(response){
                    mostrarMensajeExito();
                    $('#tablaTestigos tbody').append(agregarFilaTestigo(response)); // Agrego fila a la tabla
                    $('#parcelaTestigo').val('');
                }
            });
        }
    });

    // Evento del boton para mostrar u ocultar formulario
    $('#btnToggleForm').click(function(){
       var form = $('#formPrimeraClonal');
       form.fadeToggle();

       $(this).text() == 'Mostrar formulario' ? $(this).text('Ocultar formulario') : $(this).text('Mostrar formulario');
    });

    /*$('#anio').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.segundaclonal +  "/" + $('#anio').val() + "/" + $('#serie').val() + "/" + $('#sector').val();
    });*/

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        if($('#sector').val() > 0)
            window.location.href = config.routes.segundaclonal + "/" + $('#serie').val() + "/" + $('#sector').val();
        else
            loadAnioSerie($('#serie').val());
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

        //$('#seedlingsPC').multiselect('deselectAll', true);
        /* $('#seedlingsPC option').each(function(){
            if(procedencia == 'L'){
                if($(this).data('laboratorio')){
                    $(this).addClass('d-none');
                }
            }
            else{
                $(this).removeClass('d-none');
            }
        }); */
        $("input[name='seedlingsPC[]']").each(function(){
            if(procedencia == 'L'){
                if(!$(this).data('laboratorio')){
                    $(this).closest('tr').addClass('d-none');
                }
            }
            else{
                $(this).closest('tr').removeClass('d-none');
            }
        });
        //$('#seedlingsPC').multiselect('rebuild');
    });

    // Mostrar modal al hacer click en eliminar
    $('.deleteBtn').on('click', function(){
        var id = $(this).data('id');

        $('#formDelete').attr('action', config.routes.deleteTestigo + "/" + id);
        $('#modal-delete').modal('show');
    });

    $('.check-seleccionado').click(function(){
        let row = $(this).closest("tr");
        let inputParcela = row.find("input[name='parcelas[]']")
        let inputRepeticion = row.find("input[name='repeticiones[]']")
        let cont = $('.check-seleccionado:checked').length;

        if($(this).prop('checked')){

            inputParcela.val(parseInt(ultimaParcela) + cont - yaSeleccionados);
            inputParcela.removeAttr('disabled');
            inputRepeticion.removeAttr('disabled');
        }
        else{
            inputParcela.attr('disabled', 'disabled');
            inputParcela.val('');
            inputRepeticion.attr('disabled', 'disabled');
            inputRepeticion.val('');
        }
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
/* function habilitarDeshabilitarSeedlings(id){
    let operation = $('#formSegundaClonal').attr('operation');

    //$('#seedlingsPC').find('option:selected').removeAttr("selected");
    $("input[name='seedlingsPC[]']:checked").removeAttr("checked");
    if(operation == 'insert'){
        $("input[name='seedlingsPC[]'").each(function(){
            if($(this).data('idsc')){
                $(this).attr("disabled", "disabled");
            }
        });
    }
    else{
        $("input[name='seedlingsPC[]']").each(function(){
            $(this).removeAttr("disabled");
            if($(this).data('idsc') == id){
                $(this).attr("checked", "checked");
            }
        });
    }
    //$('#seedlingsPC').multiselect('rebuild');
} */

function habilitarDeshabilitarSeedlings(idSerie, idSector){
    $("input[name='seedlingsPC[]']:checked").removeAttr("checked");

    $("input[name='seedlingsPC[]'").each(function(){
        var segundas = $(this).data('segundas');
        var option = $(this);
        var row = $(this).closest("tr");
        var inputParcela = row.find("input[name='parcelas[]']")
        let inputRepeticion = row.find("input[name='repeticiones[]']")
        
        if(segundas){
            console.log(segundas);
            segundas.forEach(function(valor, i){
                if(valor.segunda.idserie == idSerie && valor.segunda.idsector == idSector){
                    option.attr("checked", "checked");
                    inputParcela.removeAttr('disabled');
                    inputParcela.val(parseInt(valor.parcela));
                    inputRepeticion.removeAttr('disabled');
                    inputRepeticion.val(parseInt(valor.repeticion));
                    yaSeleccionados++;
                }
            });
        }
    });
}

function agregarFilaTestigo(element){
    let fila = '';

    fila += "<tr>";
    fila += "<td>" + element.variedad.nombre + "</td>";
    fila += "<td>" + parseInt(element.parcela) + "</td>";
    fila += "<td><button class='btn deleteBtn' data-id='" + element.id + "'><i class='fa fa-trash fa-lg'></i></button></td>";
    fila += '</tr>'

    return fila;
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
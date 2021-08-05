$(document).ready(function(){
    // Seleccionar en el combo box la serie activa
    $('#serie').val(config.data.serieActiva);

    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    // Evento cuando se selecciona una serie
    $('#serie').change(function(){
        window.location.href = config.routes.laboratorio + "/" + $('#serie').val();
    });

    // Evento al confirmar
    $('#btnConfirmar').click(function(){
        var selected = $('.check-laboratorio:checked');

        // Obtener los id de los seleccionados
        var selectedIds = $.map(selected, function(item, i){
            return item.getAttribute('value');
        });

        $.ajax({
            url: config.routes.saveLaboratorio + '/' + $('#serie').val(),
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
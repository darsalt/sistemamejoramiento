$(document).ready(function(){
    if(config.session.exito)
        mostrarMensajeExito();

    if(config.session.error)
        mostrarMensajeError();

    $('#cant_registros').on('change', function(){
        $('#formSearch').trigger('submit');
    });

    // En el caso que se ingresen decimales con coma que se reemplacen con punto
    // Funciona igual si es con coma pero ellos lo quieren asi
    const inputs = document.querySelectorAll('.sinPaddingCentrado');
    inputs.forEach(input => {
        input.addEventListener('focusout', function(event) {
            let valor = event.target.value;

            valor = valor.replace(',', '.');
            event.target.value = valor;
        })
    });

    $('input.sinPaddingCentrado').on('keydown', function(event){
        if(event.key == 'Tab'){
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

            let mensajeError = validarDatosFila(idSeedling);

            if(mensajeError == '')
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
                        //tipo: $('#tipo-'+idSeedling).val(),
                        tallos: parseInt($('#tallos-'+idSeedling).val()),
                        altura: parseInt($('#altura-'+idSeedling).val()),
                        grosor: parseInt($('#grosor-'+idSeedling).val()),
                        vuelco: parseInt($('#vuelco-'+idSeedling).val()),
                        flor: parseInt($('#flor-'+idSeedling).val()),
                        brix: parseFloat($('#brix-'+idSeedling).val()),
                        escaldad: parseInt($('#escaldad-'+idSeedling).val()),
                        carbon: parseInt($('#carbon-'+idSeedling).val()),
                        roya: parseInt($('#roya-'+idSeedling).val()),
                        mosaico: parseInt($('#mosaico-'+idSeedling).val()),
                        estaria: parseInt($('#estaria-'+idSeedling).val()),
                        amarilla: parseInt($('#amarilla-'+idSeedling).val()),
                    },
                    success: function(response){
                        //
                    }
                });
            else{
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    html: mensajeError,
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    });

    function validarDatosFila(idSeedling){
        let tallos = parseInt($('#tallos-'+idSeedling).val());
        let altura = parseInt($('#altura-'+idSeedling).val());
        let grosor = parseInt($('#grosor-'+idSeedling).val());
        let vuelco = parseInt($('#vuelco-'+idSeedling).val());
        let flor = parseInt($('#flor-'+idSeedling).val());
        let brix = parseFloat($('#brix-'+idSeedling).val());
        let escaldad = parseInt($('#escaldad-'+idSeedling).val());
        let carbon = parseInt($('#carbon-'+idSeedling).val());
        let roya = parseInt($('#roya-'+idSeedling).val());
        let mosaico = parseInt($('#mosaico-'+idSeedling).val());
        let estaria = parseInt($('#estaria-'+idSeedling).val());
        let amarilla = parseInt($('#amarilla-'+idSeedling).val());
        let mensajeError = '';

        if(tallos < 0 || tallos > 999)
            mensajeError += 'El tallo debe estar entre 0 y 999<br>';

        if(altura < 1 || altura > 4)
            mensajeError += 'La altura debe estar entre 1 y 4<br>';

        if(grosor < 1 || grosor > 4)
            mensajeError += 'El grosor debe estar entre 1 y 4<br>';

        if(vuelco < 0 || vuelco > 4)
            mensajeError += 'El vuelco debe estar entre 0 y 4<br>';

        if(flor < 0 || flor > 4)
            mensajeError += 'La flor debe estar entre 0 y 4<br>';

        if(brix < 10 || brix > 30)
            mensajeError += 'El brix debe estar entre 10.0 y 30.0<br>';

        if(escaldad < 0 || escaldad > 4)
            mensajeError += 'La escaldad debe estar entre 0 y 4<br>';

        if(carbon < 0 || carbon > 4)
            mensajeError += 'El carbon debe estar entre 0 y 4<br>';

        if(roya < 0 || roya > 4)
            mensajeError += 'La roya debe estar entre 0 y 4<br>';

        if(mosaico < 0 || mosaico > 4)
            mensajeError += 'El mosaico debe estar entre 0 y 4<br>';

        if(estaria < 0 || estaria > 4)
            mensajeError += 'La estría debe estar entre 0 y 4<br>';

        if(amarilla < 0 || amarilla > 4)
            mensajeError += 'La amarilla debe estar entre 0 y 4';

        return mensajeError;
    }
});
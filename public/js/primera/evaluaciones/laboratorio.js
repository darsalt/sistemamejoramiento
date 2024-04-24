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
        });
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
        else{
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                html: mensajeError,
                confirmButtonText: 'Aceptar'
              });
        }
    });

    function validarDatosFila(idSeedling){
        let pesomuestra = $('#pesomuestra-'+idSeedling).val();
        let pesojugo = $('#pesojugo-'+idSeedling).val();
        let brix = $('#brix-'+idSeedling).val();
        let polarizacion = $('#polarizacion-'+idSeedling).val();
        let temperatura = $('#temperatura-'+idSeedling).val();
        let fibra = $('#fibra-'+idSeedling).val();
        let mensajeError = '';

        if(pesomuestra < 3 || pesomuestra > 20)
            mensajeError += 'El peso muestra debe estar entre 3.00 y 20.00<br>';

        if(pesojugo < 1 || pesojugo > 10)
            mensajeError += 'El peso jugo debe estar entre 1.00 y 10.00<br>';

        if(brix < 5 || brix > 25)
            mensajeError += 'El brix debe estar entre 5.0 y 25.0<br>';

        if(polarizacion < 0 || polarizacion > 100)
            mensajeError += 'La polarización debe estar entre 0.00 y 100.00<br>';

        if(temperatura < 0 || temperatura > 40)
            mensajeError += 'La temperatura debe estar entre 0.0° y 40.0°<br>';

        if(fibra < 10 || fibra > 20)
            mensajeError += 'La fibra debe estar entre 10.0 y 20.0';

        return mensajeError;
    }
});
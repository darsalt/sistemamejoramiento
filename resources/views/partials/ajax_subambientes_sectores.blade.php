<script type="text/javascript">
    // Evento para cuando se selecciona un ambiente
    $('#ambiente').change(function(event, idsubambiente = 0, idsector = 0) {
        var ambiente = $(this).children('option:selected').val();

        // Obtener subambientes pertenecientes al ambiente
        $.ajax({
            url: "{{ route('ajax.subambientes.getSubambientesDadoAmbiente') }}",
            type: 'GET',
            data: {
                'ambiente': ambiente
            },
            success: function(response) {
                $('#subambiente').empty();

                $('#subambiente').append(`<option value='0' selected ${disabled}>${texto_item_vacio}</option>`);
                $.each(response, function(i, item) {
                    $('#subambiente').append("<option value='" + item.id + "'>" + item
                        .nombre + "</option>");
                });

                if (idsubambiente > 0)
                    $('#subambiente').val(idsubambiente);

                $('#subambiente').trigger('change', [idsector]);
            }
        });
        $(this).trigger('blur');
    });

    // Evento para cuando se selecciona un subambiente
    $('#subambiente').change(function(event, idsector = 0) {
        var subambiente = $(this).children('option:selected').val();

        // Obtener sectores pertenecientes al subambiente
        $.ajax({
            url: "{{ route('ajax.sectores.getSectoresDadoSubambiente') }}",
            type: 'GET',
            data: {
                'subambiente': subambiente
            },
            success: function(response) {
                $('#sector').empty();

                $('#sector').append(`<option value='0' selected ${disabled}>${texto_item_vacio}</option>`);
                $.each(response, function(i, item) {
                    $('#sector').append("<option value='" + item.id + "'>" + item.nombre +
                        "</option>");
                });

                if (idsector > 0)
                    $('#sector').val(idsector);
            }
        });
        $(this).trigger('blur');
    });
</script>

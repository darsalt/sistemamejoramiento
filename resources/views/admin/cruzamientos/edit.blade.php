@extends('admin.layout')
@section('titulo', 'Editar cruzamiento')
@section('content')

<style>
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
        font-weight : bold ;
        vertical-align: super;
}
</style>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"> </script>

<script>
    tachospadre = new Array();
    tallospadre = new Array();
    tallosPadreDatos = new Array();

    tachosmadre = new Array();
    tallosmadre = new Array();
    tallosMadreDatos = new Array();

    var SITEURL = "{{ url('/') }}";
    var idTallo, nroPadre, nroMadre, inicioNroMadre;
    var termineDeCargarLosCampos = false; // Flag que se utiliza para ejecutar cierto codigo unicamente cuando se entra a la pantalla por primera vez y se carga la informacion
    var cruzamientosString = "{{$cruzamientosRelacionados}}".replace(/&quot;/ig,'"'); // Cambiar los &quot que vienen desde PHP por comillas
    var cruzamientosRelacionados = JSON.parse(cruzamientosString); // Transformar el array de PHP en un JSON
    var idCruzaPadre = cruzamientosRelacionados[0].id;

    buscarIndexInicioMadre();   // De cruzamientosRelacionados se busca en que posicion inician los registros de la madre

    $(document).ready(function() {
        // Mostrar modal de carga
        Swal.fire({
            title: 'Cargando datos. Espere...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        ////////////////////////////////////////////// CODIGO SOBRE LOS CAMPOS DEL PADRE //////////////////////////////////////////////
        if("{{$cruzamiento->tipocruzamiento}}" == 'Biparental')
            document.getElementById("agregarCruzaPadre").style.display = "none";    // Al ser biparental solo admite un padre por lo tanto no se oculta el boton para agregar mas

        $("#tachoPadre").ready(function(){
            nroPadre = 0;
            cargarDatosPadre();
        });

        $("#tachoPadre").change(function(){
            let id = $(this).val();
            
            $.get(SITEURL + '/tallosTacho/'+id, function(data){

                var tallos_select = '<option value="0" disabled selected>(Ninguno)</option>';
                for (let i=0; i<data.length;i++)
                    tallos_select+='<option value="'+data[i].id+'">'+'Nº '+data[i].numero+'</option>';
                
                // Buscar si el tacho seleccionado ya venia originalmente cargado. En ese caso hay que agregar el tallo correspondiente al select
                // ya que en el for anterior se cargan unicamente aquellos que no estan en tallosCruzamiento. Al ser una edicion ya existe en tallosCruzamiento
                // por esa razon se debe cargar el tallo si es que el tacho seleccionado es el cargado originalmente
                existeElTacho = false
                if(cruzamientosRelacionados[0].tipocruzamiento == "Biparental"){
                    if(cruzamientosRelacionados[0].idpadre == id)
                        existeElTacho = true
                }
                else{
                    i = 0;
                    auxIdCruzamiento = cruzamientosRelacionados[0].id;
                    while(cruzamientosRelacionados[i].id == auxIdCruzamiento && !existeElTacho){
                        if(cruzamientosRelacionados[i].idtacho_poli == id)
                            existeElTacho = true;
                        else
                            i++;
                    }
                }

                if(existeElTacho){
                    // Se obtiene el tallo correspondiente al tacho que no se cargo antes
                    $.get(SITEURL + '/getTalloById/'+idTallo, function(data){
                        tallos_select+='<option value="'+data[0].id+'">'+'Nº '+data[0].numero+'</option>';
                        $("#talloPadre").html(tallos_select);

                        if(!termineDeCargarLosCampos){      // Solamente se le setea el valor y se dispara el change del talloPadre cuando estoy cargando los datos para editarlos
                            $("#talloPadre").val(idTallo);
                            $("#talloPadre").trigger('change');
                        }
                    });
                }
                else
                    $("#talloPadre").html(tallos_select);
            });       
        });

        $('#talloPadre').change(function(){ 
            if($('#talloPadre').val()){     // Por mas que el (Ninguno) no se pueda seleccionar en algunos casos cuando se selecciona un valor valido se pone en nulo por alguna razon
                agregatallopadre();

                if(!termineDeCargarLosCampos){
                    if("{{$cruzamiento->tipocruzamiento}}" == 'Policruzamiento' && cruzamientosRelacionados[nroPadre].id == idCruzaPadre){
                        agregarCruzamientoPadre();
                        if(cruzamientosRelacionados[nroPadre+1].id == idCruzaPadre){
                            nroPadre++;
                            cargarDatosPadre();
                        }
                        else{
                            // Ahora toca cargar los datos de la madre
                            nroMadre = nroPadre + 1;
                            cargarDatosMadre();
                        }
                    }
                    else{
                        // Ahora toca cargar los datos de la madre
                        nroMadre = nroPadre + 1;
                        cargarDatosMadre();
                    }
                }
            }
        });
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        ////////////////////////////////////////////// CODIGO SOBRE LOS CAMPOS DE LA MADRE //////////////////////////////////////////////
        $("#tachoMadre").change(function(){
            var id = $(this).val();

            $.get(SITEURL + '/tallosTacho/'+id, function(data){

                var tallos_select = '<option value="0" disabled selected>(Ninguno)</option>';
                for (var i=0; i<data.length;i++)
                    tallos_select+='<option value="'+data[i].id+'">'+'Nº '+data[i].numero+'</option>';

                // Buscar si el tacho seleccionado ya venia originalmente cargado. En ese caso hay que agregar el tallo correspondiente al select
                // ya que en el for anterior se cargan unicamente aquellos que no estan en tallosCruzamiento. Al ser una edicion ya existe en tallosCruzamiento
                // por esa razon se debe cargar el tallo si es que el tacho seleccionado es el cargado originalmente
                existeElTacho = false
                i = inicioNroMadre;
                while(i < cruzamientosRelacionados.length && !existeElTacho){
                    if(cruzamientosRelacionados[i].idmadre == id)
                        existeElTacho = true;
                    else
                        i++;
                }

                if(existeElTacho){
                    // Se obtiene el tallo correspondiente al tacho que no se cargo antes
                    $.get(SITEURL + '/getTalloById/'+idTallo, function(data){
                        tallos_select+='<option value="'+data[0].id+'">'+'Nº '+data[0].numero+'</option>';
                        $("#talloMadre").html(tallos_select);

                        if(!termineDeCargarLosCampos){      // Solamente se le setea el valor y se dispara el change del talloPadre cuando estoy cargando los datos para editarlos
                            $("#talloMadre").val(idTallo);
                            $("#talloMadre").trigger('change');
                        }
                    });
                }
                else
                    $("#talloMadre").html(tallos_select);
            });       
        });

        $('#talloMadre').change(function(){
            if($('#talloMadre').val()){
                agregatallomadre();

                if(!termineDeCargarLosCampos){
                    if(nroMadre < cruzamientosRelacionados.length){
                        agregarCruzamiento();
                        if(nroMadre < cruzamientosRelacionados.length-1){
                            nroMadre++;
                            cargarDatosMadre();
                        }
                        else{
                            termineDeCargarLosCampos = true;
                            Swal.close();
                        }    
                    }   
                }
            }
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $("#tipocruzamiento").change(function(){
            let tipo = $(this).val();

            if (tipo == "Policruzamiento") {
                document.getElementById("agregarCruzaPadre").style.display = "";
            } else {
                document.getElementById("agregarCruzaPadre").style.display = "none";

                // Si se cambio de policruzamiento a biparental entonces borrar lo que estaba cargado
                while(tallospadre.length > 0)
                    eliminartallopadre(0);

                tachospadre = [];
                tallosPadreDatos = [];
                arrayPadre = [];
                $('#arrayPadre').val('');
                $('#arrayPadreDatos').val('');

                $('#cruzamientosPadre').empty();
                agregarInfoPadres();
            }      
        });

        $('#formcruza').submit(function() {
            var arrayPadre = document.getElementById("arrayPadre").value;
            if (arrayPadre == '') {
                alert("Debe seleccionar un padre");
                return false;
            } else {
                var arrayMadre = document.getElementById("arrayMadre").value;
                if (arrayMadre == '') {
                    alert("Debe seleccionar una madre");
                    return false;
                } else {
                    padres = JSON.parse(arrayPadre);
                    if($("#tipocruzamiento").val() == 'Policruzamiento' && padres.length == 1){
                        alert('Esta seleccionando un Policruzamiento con un solo padre')
                        return false;
                    }
                    else
                        return true;
                }
            }
        });

    });

    ////////////////////////////////////////////// FUNCIONES //////////////////////////////////////////////
    function buscarIndexInicioMadre(){
        let auxIdCruza = cruzamientosRelacionados[0].id;
        let i = 1;

        while(cruzamientosRelacionados[i].id == auxIdCruza)
            i++;

        inicioNroMadre = i;
    }

    // *** PADRE ***
    function cargarDatosPadre(){
        idTallo = cruzamientosRelacionados[nroPadre].idtallopadre;

        if("{{$cruzamiento->tipocruzamiento}}" == 'Biparental')
            $("#tachoPadre").val(cruzamientosRelacionados[nroPadre].idpadre);       // En biparental el tacho se guarda en idpadre
        else
            $("#tachoPadre").val(cruzamientosRelacionados[nroPadre].idtacho_poli);  // En policruzamiento el idpadre es nulo por lo tanto se recupera de otra tabla en idtacho_poli

        $("#tachoPadre").trigger('change');
    }

    function eliminarTachoPadre(objeto){
        let idTacho = $(objeto).parent().data('id');
        let textTacho = $(objeto).parent().data('text');
        let divCercano = $(objeto).closest('div');
        let confirmacion = confirm('¿Estás seguro de que deseas eliminar este tacho?');
        let idTallo;

        if (confirmacion) {
            // Eliminar de tachospadre
            let indexAEliminar = tachospadre.findIndex(function(item) {
                return item.tacho == textTacho;
            });

            if (indexAEliminar !== -1) {
                tachospadre.splice(indexAEliminar, 1);

                // Eliminar de tallosPadre
                indexAEliminar = tallospadre.findIndex(function(item) {
                    return item.idTacho == idTacho;
                });

                if (indexAEliminar !== -1) {
                    idTallo = tallospadre[indexAEliminar].id;
                    tallospadre.splice(indexAEliminar, 1);

                    // Eliminar de tallosPadreDatos
                    indexAEliminar = tallosPadreDatos.findIndex(function(item) {
                        return item.talloId == idTallo;
                    });

                    if (indexAEliminar !== -1) {
                        tallosPadreDatos.splice(indexAEliminar, 1);
                    }
                }
            }

            divCercano.remove(); // Borrar el div que muestra la info
            myTable = renderizarTablaTallosPadre(nroPadre, true);
            document.getElementById('tablePadre').innerHTML = myTable; 
            document.getElementById("arrayPadre").value = JSON.stringify(tallospadre);
            document.getElementById("arrayPadreDatos").value = JSON.stringify(tallosPadreDatos);
            agregarInfoPadres();
        }
    }

    function agregatallopadre(){
        var tallo = document.getElementById("talloPadre");
        var tacho = document.getElementById("tachoPadre");

        talloValue = tallo.options[tallo.selectedIndex].value;
        talloText = tallo.options[tallo.selectedIndex].text;
        tachoValue = tacho.options[tacho.selectedIndex].value;
        tachoText = tacho.options[tacho.selectedIndex].text;

        if (talloValue != '') {
           
            existeTacho = controlTachos("padre", tachoText);
            existeTallo = controlTallos("padre", talloValue);

            if (!existeTacho) {
                if (!existeTallo) {
                    tallospadre.push({id: talloValue, valor: talloText, tacho: tachoText, idTacho: tachoValue});
                    
                    myTable = renderizarTablaTallosPadre(nroPadre);
                    document.getElementById('tablePadre').innerHTML = myTable; 
                    document.getElementById("arrayPadre").value = JSON.stringify(tallospadre);   
                    $('#tachoPadre').prop('disabled', true);  

                    agregarInfoPadres();
                } else {
                    alert('Ya seleccionó el tallo');
                }    
            } else {
                alert("El tacho ya fue seleccionado");
            }    
            
        } else {
            alert('Seleccione un Tacho para el Padre');
        }
 
    }

    function renderizarTablaTallosPadre(indexPadre = 0, cargarValue = false){
        let myTable= "<table><tr><td style='width: 100px;'>Tallos Padre</td></tr>";

        for (let i = 0; i < tallospadre.length; i++) {
            if (tallospadre[i].tacho == tachoText) {
                myTable += "<tr><td style='width: 100px;text-align: right;'>" + tallospadre[i].valor + " &nbsp; </td>";

                if(!termineDeCargarLosCampos || cargarValue){ // Se debe cargar el valor del polen que tiene el tallo
                    polen = cruzamientosRelacionados[indexPadre].polen;
                    myTable += "<td> <input type='number' id='polenpadre" + i + "' name='polenpadre" + i + "' value='" + polen + "'" + "' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> &nbsp; </td>"
                }
                else
                    myTable += "<td> <input type='number' id='polenpadre" + i + "' name='polenpadre" + i + "' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> &nbsp; </td>"

                myTable += "<td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallopadre(" + i + ")'/> </td></tr>"; 
            }    
        }
        myTable+="</table>";

        return myTable;
    }

    function eliminartallopadre(index) {

        var tacho = tallospadre[index].tacho;

        tallospadre.splice( index, 1 );
        myTable = renderizarTablaTallosPadre();
        document.getElementById('tablePadre').innerHTML = myTable; 
        document.getElementById("arrayPadre").value = JSON.stringify(tallospadre);

        var habilitaTacho = true;
        for (let i = 0; i < tallospadre.length; i++) {
            if (tallospadre[i].tacho == tacho) {
                habilitaTacho = false;
            }
        }
        if (habilitaTacho) {
            $('#tachoPadre').prop('disabled', false); 
            $('#talloPadre').prop('disabled', false);
            $('#talloPadre').val('0'); 
            $('#talloPadre').select2();
            agregarInfoPadres();
        }
    }

    j=0;
    function agregarCruzamientoPadre(){
        var tacho = document.getElementById("tachoPadre");
        var tallo = document.getElementById("talloPadre");      
        talloValue = tallo.options[tallo.selectedIndex].value;
        tachoText = tacho.options[tacho.selectedIndex].text;
        tachoValue = tacho.options[tacho.selectedIndex].value;

        if (tachoValue != "") {
            existeTallo = controlTallos("padre", talloValue);
            if (existeTallo) {
                existeTacho = controlTachos("padre", tachoText);
                if (!existeTacho) {
                    j++; 
                    var div = document.createElement('div'); 
                    div.setAttribute('class', 'form-inline'); 
                    
                    let myTable= "<table><tr><td style='font-weight: bold; color:blue;' data-id='"+tachoValue+"' data-text='"+tachoText+"'>Tacho: "+ tachoText 
                    myTable += "&nbsp;&nbsp;&nbsp; <button type='button' class='close' onclick='eliminarTachoPadre(this)' <span>×</span></button>";
                    for (let j = 0; j < tallospadre.length; j++) {
                        if(tallospadre[j].tacho == tachoText) {
                            var polenTallo = document.getElementById("polenpadre"+j).value; 
                            tallosPadreDatos.push({talloId: tallospadre[j].id, polen: polenTallo})
                            myTable+="<tr><td style='text-align: left;'>" + tallospadre[j].valor + " Polen: " + polenTallo + " </td> </tr>"; 
                        }   
                    }
                    myTable+="</table>";
                    div.innerHTML = myTable;
                    document.getElementById('cruzamientosPadre').appendChild(div);
                    document.getElementById('tablePadre').innerHTML = "";
                    document.getElementById("arrayPadreDatos").value = JSON.stringify(tallosPadreDatos);
                    
                    tachospadre.push({tacho: tachoText});
                    $('#tachoPadre').prop('disabled', false);     
                    $('#talloPadre').prop('disabled', false);     
                    $('#talloPadre').val('0');
                    $('#talloPadre').select2();
                } else {
                    alert("Ya se agregó ese tacho");
                }    
            } else {
                alert("Debe agregar los tallos");
            }   
        } else {
            alert("Debe seleccionar un tacho para la Padre")
        }   
    }   
    
    function agregarInfoPadres(){
        $('#info-padres').empty();
        text = '';
        $.each(tallospadre, function(i, item){
            text += "<p class='h3'>" + item.tacho + ". Tallo: " + item.valor + "</p>";
        });
        $('#info-padres').append(text);
    }

    // *** MADRE *** 
    function cargarDatosMadre(){
        idTallo = cruzamientosRelacionados[nroMadre].idtallomadre;

        $("#tachoMadre").val(cruzamientosRelacionados[nroMadre].idmadre);  // En policruzamiento el idpadre es nulo por lo tanto se recupera de otra tabla en idtacho_poli
        $("#tachoMadre").trigger('change');
    }

    function eliminarTachoMadre(objeto){
        let idTacho = $(objeto).parent().data('id');
        let textTacho = $(objeto).parent().data('text');
        let divCercano = $(objeto).closest('div');
        let confirmacion = confirm('¿Estás seguro de que deseas eliminar este tacho?');
        let idTallo;

        if (confirmacion) {
            // Eliminar de tachosmadre
            let indexAEliminar = tachosmadre.findIndex(function(item) {
                return item.tacho == textTacho;
            });

            if (indexAEliminar !== -1) {
                tachosmadre.splice(indexAEliminar, 1);

                // Eliminar de tallosMadre
                indexAEliminar = tallosmadre.findIndex(function(item) {
                    return item.idTacho == idTacho;
                });

                if (indexAEliminar !== -1) {
                    idTallo = tallosmadre[indexAEliminar].id;
                    tallosmadre.splice(indexAEliminar, 1);

                    // Eliminar de tallosPadreDatos
                    indexAEliminar = tallosMadreDatos.findIndex(function(item) {
                        return item.talloId == idTallo;
                    });

                    if (indexAEliminar !== -1) {
                        tallosMadreDatos.splice(indexAEliminar, 1);
                    }
                }
            }

            divCercano.remove(); // Borrar el div que muestra la info
            myTable = renderizarTablaTallosMadre(nroMadre, true);
            document.getElementById('tableMadre').innerHTML = myTable;
            document.getElementById("arrayMadre").value = JSON.stringify(tallosmadre); 
            document.getElementById("arrayMadreDatos").value = JSON.stringify(tallosMadreDatos);
            agregarInfoMadres();
        }
    }

    function renderizarTablaTallosMadre(indexMadre = 0, cargarValue = false){
        let myTable= "<table><tr><td style='width: 100px;'>Tallos Madre</td></tr>";

        for (let i = 0; i < tallosmadre.length; i++) {
            if (tallosmadre[i].tacho == tachoText) {
                myTable += "<tr><td style='width: 100px;text-align: right;'>" + tallosmadre[i].valor + " &nbsp; </td>";

                if(!termineDeCargarLosCampos || cargarValue){ // Se debe cargar el valor del polen y enmasculado que tiene el tallo
                    polen = cruzamientosRelacionados[indexMadre].polen;
                    enmasculado = cruzamientosRelacionados[indexMadre].enmasculado;
                    myTable += "<td> <input type='number' id='polenmadre" + i + "' name='polenmadre" + i + "' value='"+polen+"' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> </td> <td> Enmasculado &nbsp; <input type='checkbox' value='" + enmasculado + "' onclick='checkValue(" + i + ")' id='enmasculado" + i + "' name='enmasculado" + i + "'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallomadre(" + i + ")'/> </td></tr>"; 
                }
                else
                    myTable += "<td> <input type='number' id='polenmadre" + i + "' name='polenmadre" + i + "' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> </td> <td> Enmasculado &nbsp; <input type='checkbox' value='" + 0 + "' onclick='checkValue(" + i + ")' id='enmasculado" + i + "' name='enmasculado" + i + "'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallomadre(" + i + ")'/> </td></tr>"; 
            }   
        }
        myTable+="</table>";

        return myTable;
    }

    function agregatallomadre(){
        var tallo = document.getElementById("talloMadre");
        var tacho = document.getElementById("tachoMadre");
        
        talloValue = tallo.options[tallo.selectedIndex].value;
        talloText = tallo.options[tallo.selectedIndex].text;
        tachoValue = tacho.options[tacho.selectedIndex].value;
        tachoText = tacho.options[tacho.selectedIndex].text;

        if (talloValue != '') {
            
            existeTacho = controlTachos("madre", tachoText);
            existeTallo = controlTallos("madre", talloValue);
            
            if (!existeTacho) {
                if (!existeTallo) {
                    tallosmadre.push({id: talloValue, valor: talloText, tacho: tachoText, idTacho: tachoValue});

                    myTable = renderizarTablaTallosMadre(nroMadre);
                    document.getElementById('tableMadre').innerHTML = myTable; 
                    document.getElementById("arrayMadre").value = JSON.stringify(tallosmadre); 
                    $('#tachoMadre').prop('disabled', true);
                    $('#talloMadre').prop('disabled', true);

                    agregarInfoMadres();
                } else {
                    alert("Ya seleccionó el tallo")
                }
            } else {
                alert("El tacho ya fue seleccionado")
            }
        } else {
            alert('Seleccione un Tacho para la Madre');
        }    
          
    }

    function eliminartallomadre(index) {
        var tacho = tallosmadre[index].tacho;
        
        tallosmadre.splice(index, 1);
        myTable = renderizarTablaTallosMadre();
        document.getElementById('tableMadre').innerHTML = myTable; 
        document.getElementById("arrayMadre").value = JSON.stringify(tallosmadre);

        var habilitaTacho = true;
        for (let i = 0; i < tallosmadre.length; i++) {
            if (tallosmadre[i].tacho == tacho) {
                habilitaTacho = false;
            }
        }
        if (habilitaTacho) {
            $('#tachoMadre').prop('disabled', false); 
            $('#talloMadre').prop('disabled', false);
            $('#talloMadre').val('0');
            $('#talloMadre').select2();
            agregarInfoMadres();
        }
    }

    i=0;
    function agregarCruzamiento(){
       
        var tacho = document.getElementById("tachoMadre");
        var tallo = document.getElementById("talloMadre");      
        talloValue = tallo.options[tallo.selectedIndex].value;
        tachoText = tacho.options[tacho.selectedIndex].text;
        tachoValue = tacho.options[tacho.selectedIndex].value;

        if (tachoValue != "") {
            existeTallo = controlTallos("madre", talloValue);
            if (existeTallo) {
                existeTacho = controlTachos("madre", tachoText);
                if (!existeTacho) {
                    i++; 
                    var div = document.createElement('div'); 
                    div.setAttribute('class', 'form-inline'); 
                    
                    let myTable= "<table><tr><td style='font-weight: bold; color:blue;' data-id='"+tachoValue+"' data-text='"+tachoText+"'>Tacho: "+ tachoText 
                    myTable += "&nbsp;&nbsp;&nbsp; <button type='button' class='close' onclick='eliminarTachoMadre(this)' <span>×</span></button>";
                    for (let i = 0; i < tallosmadre.length; i++) {
                        if(tallosmadre[i].tacho == tachoText) {
                            var polenTallo = document.getElementById("polenmadre"+i).value;
                            var enmasculadoTallo = document.getElementById("enmasculado"+i).value; 
                            tallosMadreDatos.push({talloId: tallosmadre[i].id, polen: polenTallo, enmasculado: enmasculadoTallo})
                            myTable+="<tr><td style='text-align: left;'>" + tallosmadre[i].valor + " Polen: " + polenTallo + " </td> </tr>";         
                        }   
                    }
                    myTable+="</table>";
                    div.innerHTML = myTable;
                    document.getElementById('cruzamientos').appendChild(div);
                    document.getElementById('tableMadre').innerHTML = "";
                    document.getElementById("arrayMadreDatos").value = JSON.stringify(tallosMadreDatos);

                    tachosmadre.push({tacho: tachoText});
                    $('#tachoMadre').prop('disabled', false);     
                    $('#talloMadre').prop('disabled', false);   
                    $('#talloMadre').val('0');
                    $('#talloMadre').select2();
                } else {
                    alert("Ya se agregó ese tacho");
                }    
            } else {
                alert("Debe agregar los tallos");
            }   
        } else {
            alert("Debe seleccionar un tacho para la Madre")
        }   
        
    }     

    function agregarInfoMadres(){
        $('#info-madres').empty();
        text = '';
        $.each(tallosmadre, function(i, item){
            text += "<p class='h4'>" + item.tacho + ". Tallo: " + item.valor + "</p>";
        });
        $('#info-madres').append(text);
    }

    // CONTROLES
    function controlTachos(tipo, tacho) {
        var tipoTallo = "";
        var existe = false;
        if (tipo == "madre") {
            tipoTallo = tachosmadre;
        } else {
            tipoTallo = tachospadre;
        }
        for (let i = 0; i < tipoTallo.length; i++) {
            if (tipoTallo[i].tacho == tacho) {
                existe = true;
            }    
        }
        return existe;
    }

    function controlTallos(tipo, tallo) {
        var tipoTallo = "";
        var existe = false;
        if (tipo == "madre") {
            tipoTallo = tallosmadre;
        } else {
            tipoTallo = tallospadre;
        }
        for (let i = 0; i < tipoTallo.length; i++) {
            if (tipoTallo[i].id == tallo) {
                existe = true;
            }    
        }
        return existe;
    }

    function checkValue(id){
        var enmasculado = 'enmasculado' + id;
        var checkBox = document.getElementById(enmasculado);
 
        if (checkBox.checked == true){
            document.getElementById(enmasculado).value = 1;
        } else {   
            document.getElementById(enmasculado).value = 0;
        }
    }

</script>

<!--Cuerpo pagina-->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Editar Cruzamiento</h3>
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <!--Sector izquierdo con el form-->
        <div class="col-6">
            <form action="{{route('admin.cruzamientos.update', ['cruzamiento' => $cruzamiento])}}" name="formcruza" id="formcruza" autocomplete="off" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="campania">Campaña:</label>
                            <select class="form-control" id="campania" name="campania" disabled>
                                <option value='{{$cruzamiento->campaniaCruzamiento->id}}' selected>{{$cruzamiento->campaniaCruzamiento->nombre}}</option>
                            </select>
                        </div>
                    </div>
                </div>    

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="tipocruzamiento">Tipo Cruzamiento</label>
                            <select class="form-control" id="tipocruzamiento" name="tipocruzamiento" id="tipocruzamiento">
                                @if ($cruzamiento->tipocruzamiento == 'Biparental')
                                    <option value="Biparental" selected>Biparental</option>
                                    <option value="Policruzamiento">Policruzamiento</option>
                                @else
                                <option value="Biparental">Biparental</option>
                                <option value="Policruzamiento" selected>Policruzamiento</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="tipocruzamiento">Padre</label>
                                <select name="tachoPadre" id="tachoPadre" class="select2" style="width: 50%;" class="form-control" required>
                                    <option value="">Seleccione un padre</option>
                                    @foreach ($tachos as $tacho)
                                        @if ($cruzamiento->tipocruzamiento == 'Biparental' && $tacho->idtacho == $cruzamientosRelacionados[0]->idpadre)
                                            <option value="{{$tacho->idtacho}}" selected>
                                        @else
                                            <option value="{{$tacho->idtacho}}">
                                        @endif

                                        {{$tacho->codigo }} - {{$tacho->subcodigo }} - {{$tacho->nombre}}
                                        </option>
                                    @endforeach
                                </select> 
                                <br>
                                <div class="form-inline">
                                    <select id="talloPadre" name="talloPadre" class="select2" style="width: 30%;" class="form-control" required>
                                        <option value=""> Tallo </option>
                                    </select>
                                    &nbsp;
                                    {{-- <input type="button" class="btn btn-info btn-circle" value="+" onclick="agregatallopadre()"/>        --}}
                                </div>
                                <div id="tablePadre"> </div>
                        </div>
                        
                    </div>
                </div>  
            
                <input type="button" name="agregarCruzaPadre" id="agregarCruzaPadre" class="btn btn-info" value="Agregar Padre" onclick="agregarCruzamientoPadre()"/>   
                <br><br>
            
                <div>
                    <div id="cruzamientosPadre" class="col-12"></div>
                </div>
            
                <div id="madres">
                    <table style="width: 100%;">
                        <thead>
                            <th>Madre</th>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td id="cruza">
                                    <select name="tachoMadre" id="tachoMadre" class="select2" style="width: 50%;" class="form-control" required>
                                        <option value="">Seleccione una madre</option>
                                        @foreach ($tachos as $tacho)
                                            <option value="{{$tacho->idtacho}}">
                                                {{$tacho->codigo }} - {{$tacho->subcodigo }} - {{$tacho->nombre}}
                                            </option>
                                        @endforeach
                                    </select>  
                                    <br>
                                    <div class="form-inline">
                                        <select id="talloMadre" name="talloMadre" class="select2" style="width: 30%;" >
                                            <option value=""> Tallo </option>
                                        </select>
                                        &nbsp;
                                        {{-- <input type="button" class="btn btn-info btn-circle" value="+" onclick="agregatallomadre()"/>   --}}     
                                    </div>
                                    <div id="tableMadre"> </div>
                                </td>
                            </tr>
                        </tbody>    
                    </table> 
                        
                </div>    
            
                <br>
                    <input type="button" name="agregarCruza" id="agregarCruza" class="btn btn-info" value="Agregar Madre" onclick="agregarCruzamiento()"/>   
            
                <br><br>
            
                <div>
                    <div id="cruzamientos" class="col-12"></div> 
                </div>    
            
                <input name="arrayPadre" id="arrayPadre" type="text" style="visibility:hidden">
                <input name="arrayPadreDatos" id="arrayPadreDatos" type="text" style="visibility:hidden">
                <input name="arrayMadre" id="arrayMadre" type="text" style="visibility:hidden">
                <input name="arrayMadreDatos" id="arrayMadreDatos" type="text" style="visibility:hidden">
            
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="fecha">Fecha de Cruzamiento</label>
                            <input type="date" name="fechacruzamiento" class="form-control" placeholder="Fecha..." required value="{{$cruzamiento->fechacruzamiento}}">
                        </div>  
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--Sector derecho con la informacion-->
        <div class="col-6 text-right">
            <div class="mt-4">
                <h3 class="font-weight-bold">Padre/s</h3>
                <div id="info-padres">
                </div>
                <h4 class="font-weight-bold">Madre/s</h4>
                <div id="info-madres">

                </div>
            </div>
        </div>
    </div>
</div> 

@endsection

@section('script')
<script>
    $('#campania').change(function(){
        window.location.href = "{{url('/admin/cruzamientos/create')}}" + '/' + $(this).val();
    });
</script>
@endsection
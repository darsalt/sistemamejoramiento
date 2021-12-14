@extends('admin.layout')
@section('titulo', 'Registrar Cruzamientos')
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

    $(document).ready(function() {

        document.getElementById("agregarCruzaPadre").style.display = "none";

        $("#tachoPadre").change(function(){
            var id = $(this).val();
            var SITEURL = "{{ url('/') }}";

            $.get(SITEURL + '/tallosTacho/'+id, function(data){

                var tallos_select = '<option value="0" disabled selected>(Ninguno)</option>';
                for (var i=0; i<data.length;i++)
                    tallos_select+='<option value="'+data[i].id+'">'+'Nº '+data[i].numero+'</option>';
            
                $("#talloPadre").html(tallos_select);
            });       
        });

        $('#talloPadre').change(function(){
            agregatallopadre();
        });

        $("#tachoMadre").change(function(){
            var id = $(this).val();
            var SITEURL = "{{ url('/') }}";

            $.get(SITEURL + '/tallosTacho/'+id, function(data){

                var tallos_select = '<option value="0" disabled selected>(Ninguno)</option>';
                for (var i=0; i<data.length;i++)
                    tallos_select+='<option value="'+data[i].id+'">'+'Nº '+data[i].numero+'</option>';
            
                $("#talloMadre").html(tallos_select);
            });       
        });

        $('#talloMadre').change(function(){
            agregatallomadre();
        });

        $("#tipocruzamiento").change(function(){
            var tipo = $(this).val();
            if (tipo == "Policruzamiento") {
                document.getElementById("agregarCruzaPadre").style.display = "";
            } else {
                document.getElementById("agregarCruzaPadre").style.display = "none";
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
                    return true;
                }
            }
        });

    });

    // *** PADRE ***

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

                    let myTable= "<table><tr><td style='width: 100px;'>Tallos Padre</td></tr>";
                    for (let i = 0; i < tallospadre.length; i++) {
                        if (tallospadre[i].tacho == tachoText) {
                            //myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallospadre[i].valor + " &nbsp; </td> <td> <input type='number' id='polenpadre" + i + "' name='polenpadre" + i + "' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> &nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallopadre(" + i + ")'/> </td></tr>"; 
                            myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallospadre[i].valor + " &nbsp; </td> <td> <input type='number' id='polenpadre" + i + "' name='polenpadre" + i + "' placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> &nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallopadre(" + i + ")'/> </td></tr>"; 
                        }    
                    }
                    myTable+="</table>";
                    document.getElementById('tablePadre').innerHTML = myTable; 
                    document.getElementById("arrayPadre").value = JSON.stringify(tallospadre);   
                    $('#tachoPadre').prop('disabled', true);  
                    $('#talloPadre').prop('disabled', true);

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

    function eliminartallopadre(index) {

        var tacho = tallospadre[index].tacho;

        tallospadre.splice( index, 1 );
        let myTable= "<table><tr><td style='width: 100px;'>Tallos Padre</td></tr>";
        for (let i = 0; i < tallospadre.length; i++) {
            if (tallospadre[i].tacho == tacho) {
                myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallospadre[i].valor + " &nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallopadre(" + i + ")'/> </td></tr>"; 
            }
        }    
        myTable+="</table>";
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
                    
                    let myTable= "<table><tr><td style='font-weight: bold; color:blue;'>Tacho: "+ tachoText + "</td></tr>";
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

                    let myTable= "<table><tr><td style='width: 100px;'>Tallos Madre</td></tr>";
                    for (let i = 0; i < tallosmadre.length; i++) {
                        if (tallosmadre[i].tacho == tachoText) {
                            //myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallosmadre[i].valor + " &nbsp; </td> <td> <input type='number' id='polenmadre" + i + "' name='polenmadre" + i + "'  placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> </td> <td> Enmasculado &nbsp; <input type='checkbox' value='" + 0 + "' onclick='checkValue(" + i + ")' id='enmasculado" + i + "' name='enmasculado" + i + "'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallomadre(" + i + ")'/> </td></tr>"; 
                            myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallosmadre[i].valor + " &nbsp; </td> <td> <input type='number' id='polenmadre" + i + "' name='polenmadre" + i + "'  placeholder='Ingrese Polen' class='col-lg-8 col-md-8 col-sm-8 col-xs-8' /> </td> </td> <td> Enmasculado &nbsp; <input type='checkbox' value='" + 0 + "' onclick='checkValue(" + i + ")' id='enmasculado" + i + "' name='enmasculado" + i + "'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallomadre(" + i + ")'/> </td></tr>"; 
                        }    
                    }
                    myTable+="</table>";
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
        let myTable= "<table><tr><td style='width: 100px;'>Tallos Madre</td></tr>";
        for (let i = 0; i < tallosmadre.length; i++) {
            if (tallosmadre[i].tacho == tacho) {
                myTable+="<tr><td style='width: 100px;text-align: right;'>" + tallosmadre[i].valor + " &nbsp; </td> <td> <input type='button' class='btn btn-danger btn-circle' value='-' onclick='eliminartallomadre(" + i + ")'/> </td></tr>"; 
            }    
        }
        myTable+="</table>";
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
                    
                    let myTable= "<table><tr><td style='font-weight: bold; color:blue;'>Tacho: "+ tachoText + "</td></tr>";
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
            <h3>Nuevo Cruzamiento</h3>
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
        
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <form action="{{url('/admin/cruzamientos/create')}}" method="GET">
                            <label for="campania">Campaña:</label>
                            <select class="form-control" id="campania" name="campania" onchange="this.form.submit()">
                            @foreach ($campanias as $camp)
                                <option value='{{$camp->id}}' {{$camp->id == $idCampania ? 'selected' : ''}}>{{$camp->nombre}}</option>
                            @endforeach	
                            </select>
                        </form>
                    </div>
                </div>
            </div>    

            {!!Form::open(array('url'=>'admin/cruzamientos', 'name'=>'formcruza', 'id'=>'formcruza','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="tipocruzamiento">Tipo Cruzamiento</label>
                        <select class="form-control" id="tipocruzamiento" name="tipocruzamiento" id="tipocruzamiento">
                            <option value="Biparental">Biparental</option>
                            <option value="Policruzamiento">Policruzamiento</option>
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
                                    <option value="{{$tacho->idtacho}}">
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
                        <input type="date" name="fechacruzamiento" class="form-control" placeholder="Fecha..." required>
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
            {!!Form::close()!!}
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
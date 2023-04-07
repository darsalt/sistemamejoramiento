@extends('admin.layout')
@section('titulo', 'Tratamientos')
@section('content')

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Tallos</h3>
        
	</div>

</div>
<div class="content">
      <br>
    <div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4>tacho : {nombre}</h4>
					</div>
    </div>

	<form method="POST" action="http://localhost/admin/tachos" accept-charset="UTF-8" autocomplete="off"><input name="_token" type="hidden" value="Cfm3TNbiLwOnd9Fu1NqSfjCE1i7PrJSR9172Vay6">
    <input name="_token" type="hidden" value="Cfm3TNbiLwOnd9Fu1NqSfjCE1i7PrJSR9172Vay6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallos iniciales</label>
               	<input type="number" name="codigo" class="form-control" placeholder="cantidad de tallos...">
            </div>
        </div>
    

        

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 1</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 2</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 3</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 4</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 5</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 6</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 7</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 8</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 9</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<label for="codigo">Tallo 10</label>
                    <input class="form-control" name="fechageneracion" id="fechageneracion" type="date" required="required">
            </div>
        </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              	<button class="btn btn-primary" type="submit">Guardar</button>
               	<button type="button" class="btn btn-danger" onclick="history.go(-1); return false;">Cancelar</button>
            </div>
        </div>
    </div>
	</form>
</div>

  </div>  
</div>
@include('admin.tratamientos.view')
@endsection
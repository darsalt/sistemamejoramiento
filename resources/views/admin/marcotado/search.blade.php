{!! Form::open(array('url'=>'admin/marcotado','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="form-group">
			<label for="area">Campaña</label>
			<select name="campanias" id="campanias" class="select2" style="width: 100%; " class="form-control" required>
				<option value="{{ $idcampania }}">{{ $nombrecampania }}</option>
				@foreach($campanias as $c)
					@if($c->id != $idcampania)      
						<option value="{{ $c->id }}" >{{ $c->nombre }}</option>
					@endif
				@endforeach
		</select>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="form-group">
		<label for="area">Clon</label>
			<div class="input-group">
				<input type="text" class="form-control" name="searchText" placeholder="Buscar Variedad..." value="{{ $searchText ?? '' }}">&nbsp;
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="form-group">
			<label for="area"></label><br>
			<div class="input-group">
					<button type="submit" class="btn btn-primary" id="btnbuscar">&nbsp;Buscar&nbsp;</button>
				</div>&nbsp;
		</div>
	</div>
</div>
{{Form::close()}}


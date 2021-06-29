<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	{!! Form::open(array('url'=>'admin/bancos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">&nbsp;
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary" id="btnbuscar">&nbsp;Buscar&nbsp;</button>
				</span>&nbsp;

				<span class="input-group-btn">
				<input type ='button' class="btn btn-secondary"  value = 'Exportar' onclick="location.href = '{{action('BancoController@export')}}'"/>
				</span>&nbsp;
			</div>
		</div>
	{{Form::close()}}
	</div>
</div>


<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($moneda, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="form-group">
		{!! Form::label('nombre', 'Nombre de la Moneda:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('nombre', null, array('class' => 'form-control input-xs', 'id' => 'nombre', 'placeholder' => 'Ingrese el nombre')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('codigo', 'Código:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('codigo', null, array('class' => 'form-control input-xs', 'id' => 'codigo', 'placeholder' => 'Ingrese el código')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion', 'placeholder' => 'Ingrese la descripción')) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('preciocompra', 'Precio Compra:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('preciocompra', null, array('class' => 'form-control input-xs', 'id' => 'dni', 'placeholder' => 'Ingrese el precio de compra', 'step'=>'0.0001')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('precioventa', 'Precio Venta:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('precioventa', null, array('class' => 'form-control input-xs', 'id' => 'dni', 'placeholder' => 'Ingrese el precio de venta', 'step'=>'0.0001')) !!}
			</div>
		</div>
	</div>
	</div>
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('400');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
}); 
</script>
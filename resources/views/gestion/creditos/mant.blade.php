<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($creditos, $formData) !!}
{!! Form::hidden('listar', $listar, ['id' => 'listar']) !!}
<div class="row">
    <div class="form-group col-sm">
        {!! Form::label('fecha', 'Fecha de Pago:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::date('fecha', $fecha, ['class' => 'form-control input-xs', 'id' => 'fecha', 'placeholder' => 'Ingrese el nombre']) !!}
        </div>
    </div>
    <div class="form-group col-sm">
        {!! Form::label('banco', 'Banco:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::select('banco', $cboBanco, null, array('class' => 'form-control input-xs', 'id' => 'banco')) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::hidden('total', null, ['class' => 'form-control input-xs', 'id' => 'total', 'placeholder' => '']) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm form-group">
        {!! Form::label('monto', 'Monto a cancelar:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('monto', null, ['class' => 'form-control input-xs', 'id' => 'monto', 'placeholder' => 'Ingrese monto', 'step' => '0.0001']) !!}
        </div>
    </div>
    <div class="col-sm form-group">
        {!! Form::label('comision', 'Comisión:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('comision', null, ['class' => 'form-control input-xs', 'id' => 'comision', 'placeholder' => 'Ingrese comision', 'step' => '0.0001']) !!}
        </div>
    </div>
    <div class="col-sm form-group">
        {!! Form::label('pendiente', 'Pendiente:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('pendiente', $creditos->total, ['class' => 'form-control input-xs', 'id' => 'pendiente', 'placeholder' => '', 'step' => '0.0001', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('comentario', 'Comentario:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::text('comentario', null, ['class' => 'form-control input-xs', 'id' => 'comentario', 'placeholder' => '']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
        {!! Form::button('<i class="fa fa-check fa-lg"></i> ' . $boton, ['class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\'' . $entidad . '\', this)']) !!}
        {!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', ['class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar' . $entidad, 'onclick' => 'cerrarModal();']) !!}
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('800');
        init(IDFORMMANTENIMIENTO + '{!! $entidad !!}', 'M', '{!! $entidad !!}');

        var total = document.getElementById('total').value;
        var pendiente = 0;

        $('#monto').keyup(function() {
            var monto = parseFloat($('#monto').val());
            if (monto > total) {
                monto = total;
                $('#monto').val(monto);
            }
            pendiente = total - monto;
            $('#pendiente').val(pendiente);
        });

    });
</script>

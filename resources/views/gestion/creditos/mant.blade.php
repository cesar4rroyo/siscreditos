<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($creditos, $formData) !!}
{!! Form::hidden('listar', $listar, ['id' => 'listar']) !!}
{!! Form::hidden('idsucursal', $creditos->idsucursal, ['id' => 'listar']) !!}
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
            {!! Form::number('monto', 0, ['class' => 'form-control input-xs', 'id' => 'monto', 'placeholder' => 'Ingrese monto', 'step' => '0.0001']) !!}
        </div>
    </div>
    @if ($creditos->movimiento->mesa->idsalon==9 || $creditos->movimiento->mesa->idsalon==10)
        <div class="col-sm form-group">
            {!! Form::label('comision', 'Comisión:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('comision', 0, ['class' => 'form-control input-xs', 'id' => 'comision', 'placeholder' => 'Ingrese comision', 'step' => '0.0001']) !!}
            </div>
        </div>
    @else
       {!! Form::hidden('comision', 0, ['class' => 'form-control input-xs', 'id' => 'comision', 'placeholder' => 'Ingrese comision', 'step' => '0.0001', 'readonly' => 'readonly']) !!}
    @endif
    {{-- <div class="col-sm form-group">
        {!! Form::label('comision', 'Comisión:', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('comision', null, ['class' => 'form-control input-xs', 'id' => 'comision', 'placeholder' => 'Ingrese comision', 'step' => '0.0001']) !!}
        </div>
    </div> --}}
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

        
        var pendiente = 0;

        document.addEventListener('keyup', function(e) {
            var total = document.getElementById('total').value;
            var monto = document.getElementById('monto').value;
            var comision = document.getElementById('comision').value;
            total = isNaN(total) || total == '' ? 0 : parseFloat(total);
            monto = isNaN(monto) || monto == '' ? 0 : parseFloat(monto);
            comision = isNaN(comision) || comision == '' ? 0 : parseFloat(comision);

            if(monto + comision > total){
                monto = total;
                comision = 0;
                document.getElementById('monto').value = monto;
                document.getElementById('comision').value = comision;
            }
            pendiente = total - (monto + comision);
            document.getElementById('pendiente').value = pendiente;
        });

    });
</script>

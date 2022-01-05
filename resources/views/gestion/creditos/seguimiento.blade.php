<div id="divMensajeError{!! $entidad !!}"></div>
<div class="container">
    @if (count($creditos->pagos) != 0)
        <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Fecha de Pago</th>
                    <th>Monto</th>
                    <th>Banco</th>
                    <th>Comentario</th>
                    {{-- <th>Saldo</th>
                <th>Estado</th>
                <th>Acciones</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($creditos->pagos as $credito)
                    <tr>
                        <td>{{ $credito->id }}</td>
                        <td>{{ $credito->fechapago }}</td>
                        <td>{{ $credito->monto }}</td>
                        <td>{{ $credito->banco->nombre }}</td>
                        <td>{{ $credito->comentario }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class=" text-bold"> No se ha realizado ningún pago </p>
    @endif
</div>
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
        {!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cerrar', ['class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar' . $entidad, 'onclick' => 'cerrarModal();']) !!}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('800');
        init(IDFORMMANTENIMIENTO + '{!! $entidad !!}', 'M', '{!! $entidad !!}');
    });
</script>

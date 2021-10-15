@if (count($lista) == 0)
    <h3 class="text-warning">No se encontraron resultados.</h3>
@else
    {!! $paginacion !!}
    <table id="example1" class="table table-bordered table-striped table-condensed table-hover">

        <thead>
            <tr>
                @foreach ($cabecera as $key => $value)
                    <th @if ((int) $value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = $inicio + 1;
            ?>
            @foreach ($lista as $key => $value)
                <tr>
                    <td>{{ $contador }}</td>
                    <td>{{ date_format(date_create($value->movimientoventa->fecha), 'd-m-y') }}</td>
                    <td>{{ date_format(date_create($value->movimientoventa->fecha), 'H:i:s') }}</td>
                    <td>{{ $value->movimientoventa }}</td>
                    <td>{{ $value->producto->idimpresora ? $value->producto->impresora->nombre : 'NO DEFINIDO' }}
                    </td>
                    <td>{{ $value->producto->descripcion }}</td>
                    {{--  --}}
                    <td>{{ $value->sucursal->razonsocial }}</td>
                    {{-- <td>{{ $value->plazo }}</td>
                    <td>{{ 'S/. ' . $value->total }}</td>
                    @php
                        if ($value->estado == 'N') {
                            $estado = 'Pendiente';
                            $class = 'danger';
                        } else {
                            $estado = 'Pagado';
                            $class = 'success';
                        }
                    @endphp
                    <td>
                        <span class=" badge badge-{{ "$class" }}">
                            {{ $estado }}
                        </span>
                    </td>
                    <td>{{ $value->sucursal->razonsocial }}</td> --}}
                    {{-- <td>{{ $value->precioventa }}</td> --}}

                    {{-- <td>{!! Form::button('<div class="fas fa-route"></div>', ['onclick' => 'modal (\'' . URL::route($ruta['delete'], [$value->idventacredito, 'SI']) . '\', \'' . 'Historial de Pagos' . '\', this);', 'class' => 'btn btn-sm btn-primary']) !!}</td> --}}
                </tr>
                <?php
                $contador = $contador + 1;
                ?>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                @foreach ($cabecera as $key => $value)
                    <th @if ((int) $value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
                @endforeach
            </tr>
        </tfoot>
    </table>
    {!! $paginacion !!}
@endif

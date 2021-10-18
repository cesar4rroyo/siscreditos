@php
setlocale(LC_ALL, 'es_ES');
\Carbon\Carbon::setLocale('es');
@endphp
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
                    <td>{{ $value->idmovimiento }}</td>
                    <td>{{ date_format(date_create($value->fecha), 'd/m/y') }}</td>
                    <td>{{ date_format(date_create($value->fecha), 'H:i:s') }}</td>
                    <td>
                        <span class=" badge badge-danger">
                            {{ $value->numero }}
                        </span>
                    </td>
                    <td>
                        @if ($idsucursal != '')
                            {{-- {{ $value->detallemovimientopedido->where('idsucursal', $idsucursal)->first()->movimientoventa->numero }} --}}
                            {{-- {{ $value->detallemovimientopedido->where('idsucursal', $idsucursal) }} --}}
                            @foreach ($value->detallemovimientopedido->where('idsucursal', $idsucursal) as $item)
                                <span>
                                    {{ $item->movimientoventa }}
                                </span><br>
                            @endforeach
                        @else
                            {{ $value->detallemovimientopedido->first() }}
                        @endif
                    </td>
                    <td>
                        @if ($idsucursal != '')
                            {{ $value->detallemovimientopedido->where('idsucursal', $idsucursal)->first()->movimientoventa->documentocaja->where('idsucursal', $idsucursal)->first()->numerooperacion }}
                        @else
                            {{ $value->detallemovimientopedido->first()->movimientoventa->documentocaja->first()->numerooperacion }}
                        @endif
                    </td>

                    <td>
                        @foreach ($value->detallemovimientopedido as $item)
                            @php
                                $producto = $item->detallemovimientoalmacen->producto;
                                if ($producto->impresora) {
                                    $impresora = $producto->impresora->nombre;
                                } else {
                                    $impresora = '';
                                }
                            @endphp
                            <span class=" badge badge-pill">{{ $producto->descripcion }}
                            </span>
                            <span class=" badge badge-success">
                                {{ ' x ' . (int) $item->detallemovimientoalmacen->cantidad . ' ' . $producto->unidad->descripcion }}
                            </span>
                            <span class=" badge badge-primary">{{ $impresora }}</span><br>
                        @endforeach
                        {{-- {{ $value->detallemovimientoalmacen }} --}}
                        {{-- @foreach ($value->detallemovimientoalmacen as $item)
                            @switch($area)
                                @case('CO')
                                    @if ($item->producto->impresora)
                                        @if ($item->producto->idimpresora == 1)
                                            <span class=" badge badge-pill">
                                                {{ $item->producto->descripcion }}
                                            </span>
                                            <span
                                                class=" badge badge-success">{{ 'x ' . (int) $item->cantidad . '  ' . $item->producto->unidad->descripcion }}</span>
                                            @php
                                                if ($item->producto->impresora) {
                                                    $impresora = $item->producto->impresora->nombre;
                                                } else {
                                                    $impresora = '';
                                                }
                                                
                                            @endphp
                                            <span class=" badge badge-primary">{{ $impresora }}</span><br>
                                        @endif
                                    @endif
                                @break
                                @case('BA')
                                    @if ($item->producto->impresora)
                                        @if ($item->producto->impresora->nombre == 'BAR')
                                            <span class=" badge badge-pill">
                                                {{ $item->producto->descripcion }}
                                            </span>
                                            <span
                                                class=" badge badge-success">{{ 'x ' . (int) $item->cantidad . '  ' . $item->producto->unidad->descripcion }}</span>
                                            @php
                                                if ($item->producto->impresora) {
                                                    $impresora = $item->producto->impresora->nombre;
                                                } else {
                                                    $impresora = '';
                                                }
                                                
                                            @endphp
                                            <span class=" badge badge-primary">{{ $impresora }}</span><br>
                                        @endif
                                    @endif
                                @break
                                @case('CA')
                                    @if ($item->producto->impresora)
                                        @if ($item->producto->impresora->nombre == 'CAJA')
                                            <span class=" badge badge-pill">
                                                {{ $item->producto->descripcion }}
                                            </span>
                                            <span
                                                class=" badge badge-success">{{ 'x ' . (int) $item->cantidad . '  ' . $item->producto->unidad->descripcion }}</span>
                                            @php
                                                if ($item->producto->impresora) {
                                                    $impresora = $item->producto->impresora->nombre;
                                                } else {
                                                    $impresora = '';
                                                }
                                                
                                            @endphp
                                            <span class=" badge badge-primary">{{ $impresora }}</span><br>
                                        @endif
                                    @endif
                                @break
                                @default
                                    <span class=" badge badge-pill">
                                        {{ $item->producto->descripcion }}
                                    </span>
                                    <span
                                        class=" badge badge-success">{{ 'x ' . (int) $item->cantidad . '  ' . $item->producto->unidad->descripcion }}</span>
                                    @php
                                        if ($item->producto->impresora) {
                                            $impresora = $item->producto->impresora->nombre;
                                        } else {
                                            $impresora = '';
                                        }
                                        
                                    @endphp
                                    <span class=" badge badge-primary">{{ $impresora }}</span><br>
                            @endswitch
                        @endforeach --}}
                    </td>
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

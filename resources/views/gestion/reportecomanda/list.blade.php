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
                    <td>{{ $value->idmovimiento }}</td>
                    {{-- <td>{{ $value->idmovimiento }}</td> --}}
                    <td>{{ date_format(date_create($value->fecha), 'd/m/y') }}</td>
                    <td>{{ date_format(date_create($value->fecha), 'H:i:s') }}</td>
                    <td>
                        <span class=" badge badge-warning">
                            {{ $value->comentario }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-success">
                            {{ $value->numero }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-pill">
                            {{ $value->total }}
                        </span>
                    </td>
                    <td>
                        {{-- {{dd($value->comandas)}} --}}
                        @foreach ($value->detallemovimientoalmacen as $item)
                            {{-- <span class=" badge badge-primary">{{$item->comandas}}</span> --}}
                            <span class=" badge badge-primary">{{$item->cantidad}}</span>
                            <span class=" badge badge-pill">{{$item->producto->descripcion}}</span>
                            <br>
                        @endforeach
                    </td>
                    
                    <td>{{ $value->sucursal->razonsocial }}</td>
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

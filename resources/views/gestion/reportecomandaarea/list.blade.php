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
                    <td>
                        <span class=" badge badge-pill">
                        {{ date_format(date_create($value->movimiento->fecha), 'd-m-y') }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-pill">
                        {{ date_format(date_create($value->movimiento->fecha), 'H:i:s') }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-success">
                            {{ $value->numero}}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-pill">
                            {{ $value->productos }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-pill">
                            {{ $value->cantidad }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-info">
                            {{ $value->impresora->nombre }}
                        </span>
                    </td>
                    <td>
                        <span class=" badge badge-pill">
                        {{ $value->sucursal->razonsocial }}
                        </span>
                    </td> 
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

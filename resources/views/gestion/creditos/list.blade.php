@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">

	<thead>
		<tr>
			@foreach($cabecera as $key => $value)
				<th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
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
			<td>{{ date('d-m-Y', strtotime($value->fecha_consumo)) }}</td>
			<td>{{ $value->cliente->personamaestro->fullname}}</td>
			<td>{{ $value->plazo }}</td>
			<td>{{ 'S/. ' . $value->total }}</td>
			@php
				if($value->estado=='N'){
					$estado = 'No Pagado';
					$class = "danger";
				}else{
					$estado = 'Pagado';
					$class = "success";
				}
			@endphp
			<td>
				<span class=" badge badge-{{"$class"}}">
					{{ $estado }}
				</span>
			</td>
			<td>{{ $value->sucursal->razonsocial }}</td>
			{{-- <td>{{ $value->precioventa }}</td> --}}
			@if ($estado=='No Pagado')
	            <td>{!! Form::button('<div class="fas fa-money-bill"></div>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->idventacredito, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}</td>
			@endif
            <td>{!! Form::button('<div class="fas fa-route"></div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->idventacredito, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-primary')) !!}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			@foreach($cabecera as $key => $value)
				<th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</tfoot>
</table>
{!! $paginacion!!}
@endif
<!-- Content Header (Page header) -->


@extends("theme.$theme.layout")

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Persoal</div>
                
                <div class="card-body">
                    <div class="row">
                        {!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'w-100 d-md-flex d-lg-flex d-sm-inline-block mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                        {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                        {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
						<div class="row w-100 d-flex">
                        <div class="col-lg-4 col-md-4  form-group">
                            {!! Form::label('nombres', 'Nombres:') !!}
                            {!! Form::text('nombres', '', array('class' => 'form-control ', 'id' => 'nombres')) !!}
                        </div>
						<div class="col-lg-4 col-md-4  form-group">
							{!! Form::label('dni', 'DNI:') !!}
							{!! Form::text('dni', '', array('class' => 'form-control input-xs', 'id' => 'dni')) !!}
						</div>											
                        <div class="col-lg-2 col-md-2  form-group" style="min-width: 150px;">
                            {!! Form::label('nombre', 'Filas a mostrar') !!}
                            {!! Form::selectRange('filas', 1, 30, 10, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                        </div>
                        {!! Form::close() !!}
                      </div>
					</div>
                   
                      <div class="row mt-2" >
						<div class="col-md-12">
						  <div class="card">
							<div class="card-header">
							  <div class="card-tools">
								{!! Form::button(' <i class="fa fa-plus fa-fw"></i> Agregar', array('class' => 'btn  btn-outline-primary', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
							</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body table-responsive px-3">
								<div id="listado{{ $entidad }}">
								</div>
							</div>
							<!-- /.card-body -->
						  </div>
						  <!-- /.card -->
						</div>
					  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
		buscar('{{ $entidad }}');
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="nombres"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="dni"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});			
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="roles"]').change(function (e) {
			buscar('{{ $entidad }}');
		});
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="cargo"]').change(function (e) {
			buscar('{{ $entidad }}');
		});
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="area"]').change(function (e) {
			buscar('{{ $entidad }}');
		});
	});
</script>
{{--  --}}
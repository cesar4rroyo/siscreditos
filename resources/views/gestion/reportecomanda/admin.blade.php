<!-- Content Header (Page header) -->


@extends("theme.$theme.layout")

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Reporte Resumen de Comandas </div>
                    <div class="card-body">
                        {!! Form::open(['route' => $ruta['search'], 'method' => 'POST', 'onsubmit' => 'return false;', 'class' => 'w-100 d-md-flex d-lg-flex d-sm-inline-block mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda' . $entidad]) !!}
                        {!! Form::hidden('page', 1, ['id' => 'page']) !!}
                        {!! Form::hidden('accion', 'listar', ['id' => 'accion']) !!}
                        <div class="row">
                            <div class="col-sm form-group">
                                {!! Form::label('fechainicio', 'Fecha inicio') !!}
                                {!! Form::input('dateTime-local', 'fechainicio', date('Y-m-d\TH:i'), ['class' => 'form-control input-xs', 'id' => 'fechainicio', 'onchange' => 'buscar(\'' . $entidad . '\')']) !!}
                            </div>
                            <div class="col-sm form-group">
                                {!! Form::label('fechafin', 'Fecha fin') !!}
                                {!! Form::input('dateTime-local', 'fechafin', '', ['class' => 'form-control input-xs', 'id' => 'fechafin', 'onchange' => 'buscar(\'' . $entidad . '\')']) !!}
                            </div>
                            {{-- <div class="col-sm form-group">
                                {!! Form::label('descripcionSearch', 'Nombre') !!}
                                {!! Form::text('descripcionSearch', '', ['class' => 'form-control ', 'id' => 'descripcionSearch']) !!}
                            </div> --}}
                            <div class="col-sm form-group">
                                {!! Form::label('sucursal', 'Sucursal') !!}
                                {!! Form::select('sucursal', $cboSucursales, 16, ['class' => 'form-control form-control input-xs', 'id' => 'sucursal', 'onchange' => 'buscar(\'' . $entidad . '\')']) !!}
                            </div>
                            <div class="col-sm form-group">
                                {!! Form::label('area', 'Área') !!}
                                {!! Form::select('area', $cboAreas, '', ['class' => 'form-control form-control input-xs', 'id' => 'area', 'onchange' => 'buscar(\'' . $entidad . '\')']) !!}
                            </div>
                            <div class="col-lg-2 col-md-2  form-group" style="min-width: 150px;">
                                {!! Form::label('nombre', 'Filas a mostrar') !!}
                                {!! Form::selectRange('filas', 1, 30, 10, ['class' => 'form-control input-xs', 'onchange' => 'buscar(\'' . $entidad . '\')']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-tools">
                                            {{-- {!! Form::button(' <i class="fa fa-plus fa-fw"></i> Agregar', ['class' => 'btn  btn-outline-primary', 'id' => 'btnNuevo', 'onclick' => 'modal (\'' . URL::route($ruta['create'], ['listar' => 'SI']) . '\', \'' . $titulo_registrar . '\', this);']) !!} --}}
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
        init(IDFORMBUSQUEDA + '{{ $entidad }}', 'B', '{{ $entidad }}');
        $(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="descripcionSearch"]').keyup(function(e) {
            var key = window.event ? e.keyCode : e.which;
            if (key == '13') {
                buscar('{{ $entidad }}');
            }
        });
    });
</script>
{{--  --}}

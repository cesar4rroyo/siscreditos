<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Librerias\Libreria;
use App\Models\Banco;
use App\Models\Gestion\Creditos;
use App\Models\Gestion\Pagos;
use App\Models\Gestion\Sucursal;
use Carbon\Carbon;
use Validator;

class CreditosController extends Controller
{
    protected $folderview      = 'gestion.creditos';
    protected $tituloAdmin     = 'Créditos';
    protected $tituloRegistrar = 'Registrar Credito';
    protected $tituloModificar = 'Realizar Pago';
    protected $tituloEliminar  = 'Eliminar Cuota';
    protected $rutas           = array(
        'create' => 'creditos.create',
        'edit'   => 'creditos.edit',
        'delete' => 'creditos.eliminar',
        // 'listar' => 'creditos.eliminar',
        'search' => 'creditos.buscar',
        'index'  => 'creditos.index',
    );
    /**
     * Mostrar el resultado de búsquedas
     * 
     * @return Response 
     */
    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'creditos';
        $nombre           = Libreria::getParam(strtoupper($request->input('descripcionSearch')));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $idsucursal       = Libreria::getParam($request->input('sucursal'));
        $estado           = Libreria::getParam($request->input('estado'));
        $pedidosYa        = Libreria::getParam($request->input('pedidosya'));
        $resultado        = Creditos::with('cliente.personamaestro', 'sucursal', 'movimiento')->listar($fecinicio, $fecfin, $nombre, $idsucursal, $estado, $pedidosYa);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha Consumo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Comprobante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cliente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Plazo (Días)', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Deuda', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Sucursal', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Precio Compra', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');

        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview . '.list')->with(compact('lista', 'entidad'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'creditos';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboSucursales = ['' => 'Seleccione una sucursal'] + Sucursal::pluck('razonsocial', 'idsucursal')->all();
        $cboestados = ['' => 'Seleccione un estado', 'N' => 'Pendientes', 'C' => 'Pagados'];
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboSucursales', 'cboestados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tipousuario = session()->all()['tipousuario_id'];
        $permiso = Libreria::verificarPermiso($tipousuario);
        if ($permiso !== true) {
            return $permiso;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'creditos';
        $creditos = null;

        $formData = array('creditos.store');
        $cboSucursales = ['' => 'Seleccione una sucursal'] + Sucursal::pluck('razonsocial', 'idsucursal')->all();
        $cboBanco = ['' => 'Seleccione un banco'] + Banco::pluck('nombre', 'id')->all();
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview . '.mant')->with(compact('creditos', 'formData', 'entidad', 'boton', 'listar', 'cboSucursales', 'cboBanco'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $listar     = Libreria::getParam($request->input('listar'), 'NO');
        // $reglas     = array(
        //     'descripcion'   => 'required',
        //     'preciocompra'  => 'required',
        //     'precioventa'   => 'required',
        //     'codigo'        => 'required',
        // );
        // $mensajes = array(
        //     'nombre.required'         => 'Debe ingresar un nombre',
        //     'codigo.required'         => 'Debe ingresar un codigo',
        //     'preciocompra.required'   => 'Debe ingresar el precio de compra',
        //     'precioventa.required'    => 'Debe ingresar el precio de venta',
        // );

        // $validacion = Validator::make($request->all(), $reglas, $mensajes);
        // if ($validacion->fails()) {
        //     return $validacion->messages()->toJson();
        // }
        // $error = DB::transaction(function () use ($request) {
        //     $creditos = creditos::create([
        //         'nombre'        =>  strtoupper($request->nombre),
        //         'codigo'        =>  strtoupper($request->codigo),
        //         'preciocompra'  =>  $request->preciocompra,
        //         'precioventa'   =>  $request->precioventa,
        //         'descripcion'   =>  Libreria::getParam($request->descripcion),
        //     ]);
        // });

        // return is_null($error) ? "OK" : $error;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $idsucursal   = Libreria::getParam($request->input('idsucursal'));
        $creditos   = Creditos::with('movimiento.mesa')->where('idsucursal', $idsucursal)->where('idventacredito', $id)->first();
        $fecha = Carbon::now()->toDateString();
        $entidad  = 'creditos';
        $formData = array('creditos.update', $id);
        $cboBanco = ['' => 'Seleccione un banco'] + Banco::pluck('nombre', 'id')->all();
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Realizar Pago';
        return view($this->folderview . '.mant')->with(compact('creditos', 'formData', 'entidad', 'boton', 'listar', 'fecha', 'cboBanco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reglas     = array(
            'monto'   => 'required',
            'banco'   => 'required',
            
        );
        $mensajes = array(
            'monto.required'         => 'Debe ingresar el monto',
            'banco.required'         => 'Debe ingresar el banco',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $error = DB::transaction(function () use ($request, $id) {
            $monto = $request->input('monto');
            $fechapago = $request->input('fecha');
            $comision = $request->input('comision');
            $idbanco = $request->input('banco');
            $idsucursal = $request->input('idsucursal');
            $comentario = Libreria::getParam($request->input('comentario'));
            $creditos = Creditos::where('idventacredito', $id)->where('idsucursal', $idsucursal)->first();
            if ($creditos->total > $monto) {
                $creditos->total = $creditos->total - $monto;
                $creditos->save();
                $pagos = Pagos::create([
                    'idventacredito' => $id,
                    'monto' => $monto,
                    'comision' => $comision,
                    'fechapago' => $fechapago,
                    'comentario' => $comentario,
                    'idsucursal' => $idsucursal,
                    'idbanco' => $idbanco,
                ]);
            } else {
                $creditos->estado = 'C';
                $creditos->fecha_pago = $fechapago;
                $creditos->total = 0.00;
                $creditos->save();
                $pagos = Pagos::create([
                    'idventacredito' => $id,
                    'monto' => $monto,
                    'fechapago' => $fechapago,
                    'comentario' => $comentario,
                    'comision' => $comision,
                    'idsucursal' => $idsucursal,
                    'idbanco' => $idbanco,
                ]);
            }
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipousuario = session()->all()['tipousuario_id'];
        $permiso = Libreria::verificarPermiso($tipousuario);
        if ($permiso !== true) {
            return $permiso;
        }
        $existe = Libreria::verificarExistencia($id, 'creditos');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $creditos = creditos::find($id);
            $creditos->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $sucursal, $listarLuego)
    {
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Creditos::with('pagos.banco')->where('idventacredito',$id)->where('idsucursal', $sucursal)->first();
        $creditos = Creditos::with('pagos.banco')->where('idventacredito',$id)->where('idsucursal', $sucursal)->first();
        $entidad  = 'creditos';
        $formData = array('route' => array('creditos.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view($this->folderview . '.seguimiento')->with(compact('modelo', 'entidad', 'boton', 'listar', 'formData', 'creditos'));
    }
}

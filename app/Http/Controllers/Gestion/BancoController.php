<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Librerias\Libreria;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;

class BancoController extends Controller
{
    protected $folderview      = 'gestion.banco';
    protected $tituloAdmin     = 'banco';
    protected $tituloRegistrar = 'Registrar Banco';
    protected $tituloModificar = 'Modificar Banco';
    protected $tituloEliminar  = 'Eliminar Banco';
    protected $rutas           = array(
        'create' => 'banco.create',
        'edit'   => 'banco.edit',
        'delete' => 'banco.eliminar',
        'search' => 'banco.buscar',
        'index'  => 'banco.index',
    );
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
     /**
     * Mostrar el resultado de búsquedas
     * 
     * @return Response 
     */
    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'banco';
        $nombres          = Libreria::getParam($request->input('descripcion'));
        $resultado        = Banco::listar($nombres);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. Cuenta', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Moneda', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Dirección', 'numero' => '1');
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
        $entidad          = 'banco';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'banco';
        $banco = null;
        $formData = array('banco.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $cboMoneda = array('' => 'Seleccione una opción', 'Soles' => 'Soles', 'Dolares' => 'Dolares');
        $boton    = 'Registrar';
        return view($this->folderview . '.mant')->with(compact('banco', 'formData', 'entidad', 'boton', 'listar', 'cboMoneda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'nombre' => 'required',
            'cuenta' => 'required',
            'moneda' => 'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'cuenta.required'         => 'Debe ingresar el Nro de cuenta',
            'moneda.required'         => 'Debe ingresar el tipo de moneda',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function () use ($request) {
            $banco = Banco::create([
                'nombre' => strtoupper($request->input('nombre')),     
                'direccion' => strtoupper($request->input('direccion')),
                'telefono' => strtoupper($request->input('telefono')),
                'cuenta' => strtoupper($request->input('cuenta')),
                'moneda' => strtoupper($request->input('moneda')),
            ]);
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'banco');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $banco = Banco::find($id);
        $entidad  = 'banco';
        $cboMoneda = array('' => 'Seleccione una opción', 'Soles' => 'Soles', 'Dolares' => 'Dolares');
        $formData = array('banco.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview . '.mant')->with(compact('banco', 'formData', 'entidad', 'boton', 'listar', 'cboMoneda'));
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
        $existe = Libreria::verificarExistencia($id, 'banco');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'nombre' => 'required',
            'cuenta' => 'required',
            'moneda' => 'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'cuenta.required'         => 'Debe ingresar el Nro de cuenta',
            'moneda.required'         => 'Debe ingresar el tipo de moneda',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function () use ($request, $id) {
            $banco = banco::find($id);
            $banco->update([
                'nombre' => strtoupper($request->input('nombre')),     
                'direccion' => strtoupper($request->input('direccion')),
                'telefono' => strtoupper($request->input('telefono')),
                'cuenta' => strtoupper($request->input('cuenta')),
                'moneda' => strtoupper($request->input('moneda')),
            ]);
            
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
        $existe = Libreria::verificarExistencia($id, 'banco');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $banco = Banco::find($id);
            $banco->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'banco');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Banco::find($id);
        $entidad  = 'banco';
        $formData = array('route' => array('banco.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}

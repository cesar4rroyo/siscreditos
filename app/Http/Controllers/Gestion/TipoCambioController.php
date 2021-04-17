<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Librerias\Libreria;
use Validator;

class TipoCambioController extends Controller
{
    protected $folderview      = 'gestion.moneda';
    protected $tituloAdmin     = 'Tipo de Cambio';
    protected $tituloRegistrar = 'Registrar Tipo de Cambio';
    protected $tituloModificar = 'Modificar Tipo de Cambio';
    protected $tituloEliminar  = 'Eliminar Tipo de Cambio';
    protected $rutas           = array('create' => 'moneda.create', 
            'edit'   => 'moneda.edit', 
            'delete' => 'moneda.eliminar',
            'search' => 'moneda.buscar',
            'index'  => 'moneda.index',
        );


     /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * API RESPONSE, return all values,or specific
     * 
     * @return JSON 
     */

     public function getTipoCambios($id=null){
        if(!is_null($id)){
            $moneda = Moneda::find($id);
        }else{
            $moneda = Moneda::all();
        }

        if(!$moneda){
            return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentraron datos.'])],404);
        }
        $data = [];
        if(!is_null($id) && $moneda){
            $data=[
                'moneda'=>$moneda->nombre,
                'codigo'=>$moneda->codigo,
                'descripcion'=>$moneda->descripcion,
                'tc_venta'=>$moneda->precioventa,
                'tc_compra'=>$moneda->precioventa,
            ]; 
        }else{
        foreach($moneda as $item){
            $data[]=[
                'moneda'=>$item->nombre,
                'codigo'=>$item->codigo,
                'descripcion'=>$item->descripcion,
                'tc_venta'=>$item->precioventa,
                'tc_compra'=>$item->precioventa,
            ];
            
        }}
        return response()->json(['status'=>'ok','data'=>$data],200);
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
        $entidad          = 'moneda';
        $nombre           = Libreria::getParam($request->input('descripcionSearch'));
        $resultado        = Moneda::where('nombre', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('created_at', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Precio Venta', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Precio Compra', 'numero' => '1');
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'moneda';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'moneda';
        $moneda = null;
        
        $formData = array('moneda.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('moneda', 'formData', 'entidad', 'boton', 'listar'));
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
            'descripcion'   => 'required',
            'preciocompra'  => 'required',
            'precioventa'   => 'required',
            'codigo'   => 'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'codigo.required'         => 'Debe ingresar un codigo',
            'preciocompra.required'   => 'Debe ingresar el precio de compra',
            'precioventa.required'    => 'Debe ingresar el precio de venta',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $moneda = Moneda::create([
                'nombre'=> strtoupper($request->nombre),
                'codigo'=> strtoupper($request->codigo),
                'preciocompra'=>$request->preciocompra,
                'precioventa'=>$request->precioventa,
                'descripcion'=> Libreria::getParam($request->descripcion),
            ]);
        });

        return is_null($error) ? "OK" : $error;
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
        $existe = Libreria::verificarExistencia($id, 'moneda');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $moneda = Moneda::find($id);
        $entidad  = 'moneda';
        $formData = array('moneda.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('moneda', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'moneda');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'codigo'   => 'required',
            'descripcion'   => 'required',
            'preciocompra'  => 'required',
            'precioventa'   => 'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'codigo.required'         => 'Debe ingresar un codigo',
            'preciocompra.required'   => 'Debe ingresar el precio de compra',
            'precioventa.required'    => 'Debe ingresar el precio de venta',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $moneda = Moneda::find($id);
            $moneda->update([
                'nombre'=> strtoupper($request->nombre),
                'codigo'=> strtoupper($request->codigo),
                'preciocompra'=>$request->preciocompra,
                'precioventa'=>$request->precioventa,
                'descripcion'=> Libreria::getParam($request->descripcion),
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
        $existe = Libreria::verificarExistencia($id, 'moneda');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $moneda = Moneda::find($id);
            $moneda->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'moneda');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Moneda::find($id);
        $entidad  = 'moneda';
        $formData = array('route' => array('moneda.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}

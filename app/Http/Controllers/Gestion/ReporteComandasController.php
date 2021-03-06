<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\Comanda;
use App\Models\Gestion\DetalleMovimiento;
use App\Models\Gestion\DetalleMovimientoAlmacen;
use App\Models\Gestion\Movimiento;
use App\Models\Gestion\Sucursal;

class ReporteComandasController extends Controller
{
    protected $folderview      = 'gestion.reportecomanda';
    protected $tituloAdmin     = 'Comandas';
    protected $tituloRegistrar = 'Registrar Comanda';
    protected $tituloModificar = 'Realizar Comanda';
    protected $tituloEliminar  = 'Eliminar Comanda';
    protected $rutas           = array(
        'create' => 'reportecomanda.create',
        'edit'   => 'reportecomanda.edit',
        'delete' => 'reportecomanda.eliminar',
        // 'listar' => 'movimiento.eliminar',
        'search' => 'reportecomanda.buscar',
        'index'  => 'reportecomanda.index',
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
        $entidad          = 'movimiento';
        // $nombre           = Libreria::getParam(strtoupper($request->input('descripcionSearch')));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $idsucursal       = Libreria::getParam($request->input('sucursal'));
        $estado           = null;
        $area             = Libreria::getParam($request->input('area')) ?? '';
        $resultado        = Movimiento::with('comandas','detallemovimientoalmacen.comandas', 'detallemovimientoalmacen.producto')->listar($fecinicio, $fecfin,2, $idsucursal);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado de Cuenta', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Comprobante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Total', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Productos', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Sucursal', 'numero' => '1');

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
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'area', 'idsucursal'));
        }
        return view($this->folderview . '.list')->with(compact('lista', 'entidad', 'area', 'idsucursal'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'movimiento';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboSucursales =  Sucursal::pluck('razonsocial', 'idsucursal')->all();
        $cboAreas = ['' => 'TODAS', 'CO' => 'Cocina', 'BA' => 'Bar', 'CA' => 'Caja'];
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboSucursales', 'cboAreas'));
    }
}

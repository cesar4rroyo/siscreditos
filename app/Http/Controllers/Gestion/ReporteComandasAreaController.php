<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Models\Comanda;
use App\Models\Gestion\DetalleMovimientoAlmacen;
use App\Models\Gestion\Movimiento;
use App\Models\Gestion\Sucursal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReporteComandasAreaController extends Controller
{
    protected $folderview      = 'gestion.reportecomandaarea';
    protected $tituloAdmin     = 'Comandas';
    protected $tituloRegistrar = 'Registrar Comanda';
    protected $tituloModificar = 'Realizar Comanda';
    protected $tituloEliminar  = 'Eliminar Comanda';
    protected $rutas           = array(
        'create' => 'reportecomandaarea.create',
        'edit'   => 'reportecomandaarea.edit',
        'delete' => 'reportecomandaarea.eliminar',
        // 'listar' => 'movimiento.eliminar',
        'search' => 'reportecomandaarea.buscar',
        'index'  => 'reportecomandaarea.index',
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
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $idsucursal       = Libreria::getParam($request->input('sucursal'));
        $estado           = null;
        $area             = Libreria::getParam($request->input('area'));
        $resultado        = Comanda::with('movimiento', 'impresora')->listar($fecinicio, $fecfin, $idsucursal, $area);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Comanda', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Producto', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cantidad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Área', 'numero' => '1');
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
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'idsucursal', 'area'));
        }
        return view($this->folderview . '.list')->with(compact('lista', 'entidad', 'idsucursal', 'area'));
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
        $cboSucursales = Sucursal::pluck('razonsocial', 'idsucursal')->all();
        $cboAreas = ['' => 'TODAS', '1' => 'Cocina', '4' => 'Bar'];
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboSucursales', 'cboAreas'));
    }
}

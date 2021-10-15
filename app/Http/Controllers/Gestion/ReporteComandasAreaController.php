<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
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
        $resultado        = DetalleMovimientoAlmacen::with('producto.impresora', 'movimientoventa.detallemovimientopedido')
            ->listar(Carbon::parseFromLocale($fecinicio, 'es')->format('Y-m-d H:i:s'), Carbon::parseFromLocale($fecfin, 'es')->format('Y-m-d H:i:s'), $idsucursal, null);
        // $sql = Str::replaceArray('?', $resultado->getBindings(), $resultado->toSql());
        // dd($sql);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número Comanda', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Área', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Producto', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cantidad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Unidad', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Area', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Sucursal', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Plazo (Días)', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Deuda', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Sucursal', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Precio Compra', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');

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
        $entidad          = 'movimiento';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboSucursales = ['' => 'Seleccione una sucursal'] + Sucursal::pluck('razonsocial', 'idsucursal')->all();
        $cboAreas = ['' => 'TODAS', 'C' => 'Cocina', 'B' => 'Bar'];
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboSucursales', 'cboAreas'));
    }
}

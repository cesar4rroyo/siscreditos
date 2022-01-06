<?php

namespace App\Models;

use App\Models\Gestion\Impresora;
use App\Models\Gestion\Movimiento;
use App\Models\Gestion\Producto;
use App\Models\Gestion\Sucursal;
use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    public $connection = 'pgsql';
    protected $dates = ['deleted_at'];
    protected $table = 'comanda';
    protected $primaryKey = 'idcomanda';

    use \Awobaz\Compoships\Compoships;

    public function movimientoref()
    {
        return $this->belongsTo(Movimiento::class, ['idmovimiento', 'idsucursal'], ['idmovimiento', 'idsucursal']);
    }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, ['idmovimiento', 'idsucursal'], ['idmovimiento', 'idsucursal']);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
    public function impresora()
    {
        return $this->belongsTo(Impresora::class, 'idimpresora');
    }
    public function detallemovalmacen()
    {
        return $this->belongsTo(DetalleMovimientoAlmacen::class, ['iddetallemovalmacen', 'idsucursal'], ['iddetallemovalmacen', 'idsucursal']);
    }

    public function scopelistar($query, $fecinicio, $fecfin, $sucursal, $area)
    {
        return $query
            ->where(function ($subquery) use ($fecinicio) {
                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                    $subquery->whereHas('movimientoref', function ($q2) use ($fecinicio) {
                        $q2->where('fecha', '>=', date_format(date_create($fecinicio),  'Y-m-d H:i:s'));
                    });
                }
            })
            ->where(function ($subquery) use ($fecfin) {
                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                    $subquery->whereHas('movimientoref', function ($q2) use ($fecfin) {
                        $q2->where('fecha', '<=', date_format(date_create($fecfin),  'Y-m-d H:i:s'));
                    });
                }
            })
            ->where(function ($subquery) use ($sucursal) {
                if (!is_null($sucursal) && strlen($sucursal) > 0) {
                    $subquery->where('idsucursal',  $sucursal);
                }
            })
            ->where(function ($subquery) use ($area) {
                if (!is_null($area) && strlen($area) > 0) {
                    $subquery->where('idimpresora',  $area);
                }
            })
            ->whereNotNull('idmovimientoref')
            ->orderBy('idcomanda', 'DESC');
    }

}

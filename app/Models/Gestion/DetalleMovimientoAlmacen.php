<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class DetalleMovimientoAlmacen extends Model
{
    public $connection = 'pgsql';
    protected $table = 'detallemovalmacen';
    protected $primaryKey = 'iddetallemovalmacen';

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
    public function movimientoventa()
    {
        return $this->belongsTo(Movimiento::class, 'idmovimiento');
    }

    public function scopelistar($query, $fecinicio, $fecfin, $sucursal, $area)
    {
        return $query
            ->where(function ($subquery) use ($fecinicio) {
                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                    $subquery->whereHas('movimientoventa', function ($q2) use ($fecinicio) {
                        $q2->where('fecha', '>=', date_format(date_create($fecinicio),  'Y-m-d H:i:s'));
                    });
                }
            })
            ->where(function ($subquery) use ($fecfin) {
                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                    $subquery->whereHas('movimientoventa', function ($q2) use ($fecfin) {
                        $q2->where('fecha', '<=', date_format(date_create($fecfin),  'Y-m-d H:i:s'));
                    });
                }
            })
            ->where(function ($subquery) use ($sucursal) {
                if (!is_null($sucursal) && strlen($sucursal) > 0) {
                    $subquery->where('idsucursal',  $sucursal)
                        ->whereHas('movimientoventa', function ($q2) use ($sucursal) {
                            return $q2->where('idsucursal', $sucursal)
                                ->whereHas('detallemovimientoventa', function ($q3) use ($sucursal) {
                                    $q3->where('idsucursal', $sucursal);
                                });
                        });
                }
            })
            // ->where(function ($subquery) use ($sucursal) {
            //     if (!is_null($sucursal) && strlen($sucursal) > 0) {
            //         $subquery->where('idsucursal',  $sucursal);
            //     }
            // })
            ->where(function ($subquery) use ($area) {
                if (!is_null($area) && strlen($area) > 0) {
                    $subquery->whereHas('producto',  function ($q2) use ($area) {
                        $q2->where('idimpresora',  $area);
                    });
                }
            })
            ->orderBy('idmovimiento', 'DESC');
    }
}

<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    public $connection = 'pgsql';
    protected $table = 'movimiento';
    protected $primaryKey = 'idmovimiento';

    public function conceptopago()
    {
        return $this->belongsTo(ConceptoPago::class, 'idconceptopago');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function tipomovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'idtipomovimiento');
    }
    public function tipodocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'idtipodocumento');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idpersona');
    }
    public function detallemovimientoventa()
    {
        return $this->hasMany(DetalleMovimiento::class, 'idmovimiento');
    }
    public function detallemovimientopedido()
    {
        return $this->hasMany(DetalleMovimiento::class, 'idmovimientoref');
    }
    public function detallemovimientoalmacen()
    {
        return $this->hasMany(DetalleMovimientoAlmacen::class, 'idmovimiento');
    }
    public function documentocaja()
    {
        return $this->hasMany(Movimiento::class, 'idmovimientoref');
    }
    public function scopelistar($query, $fecinicio, $fecfin, $tipomovimiento, $sucursal, $area, $estado)
    {
        return $query
            ->where('estado', 'N')
            ->where(function ($subquery) use ($fecinicio) {
                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                    $subquery->where('fecha', '>=', date_format(date_create($fecinicio),  'Y-m-d H:i:s'));
                }
            })
            ->where(function ($subquery) use ($fecfin) {
                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                    $subquery->where('fecha', '<=', date_format(date_create($fecfin),  'Y-m-d H:i:s'));
                }
            })
            ->where(function ($subquery) use ($sucursal) {
                if (!is_null($sucursal) && strlen($sucursal) > 0) {
                    $subquery->where('idsucursal',  $sucursal);
                }
            })
            ->where(function ($subquery) use ($tipomovimiento) {
                if (!is_null($tipomovimiento) && strlen($tipomovimiento) > 0) {
                    $subquery->where('idtipomovimiento',  $tipomovimiento);
                }
            })
            ->where(function ($subquery) use ($estado) {
                if (!is_null($estado) && strlen($estado) > 0) {
                    $subquery->where('estado',  $estado);
                }
            })
            // ->where(function ($subquery) use ($area) {
            //     if (!is_null($area) && strlen($area) > 0) {
            //         $subquery->whereHas('detallemovimientoalmacen',  function ($q2) use ($area) {
            //             $q2->whereHas('producto',  function ($q3) use ($area) {
            //                 $q3->where('idimpresora',  $area);
            //             });
            //         });
            //     }
            // })
            ->orderBy('fecha', 'DESC');
    }
}

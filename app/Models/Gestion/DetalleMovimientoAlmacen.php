<?php

namespace App\Models\Gestion;

use App\Models\Comanda;
use Illuminate\Database\Eloquent\Model;

class DetalleMovimientoAlmacen extends Model
{
    public $connection = 'pgsql';
    protected $table = 'detallemovalmacen';
    protected $primaryKey = 'iddetallemovalmacen';

    use \Awobaz\Compoships\Compoships;


    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class,['idproducto', 'idsucursal'], ['idproducto', 'idsucursal']);
    }
    // public function producto2()
    // {
    //     return $this->belongsTo(Producto::class, 'idproducto');
    // }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, ['idmovimiento', 'idsucursal'], ['idmovimiento', 'idsucursal']);
    }
    public function comandas(){
        return $this->hasMany(Comanda::class, ['idcomanda', 'idsucursal'], ['idcomanda', 'idsucursal']);
    }

    // public function scopelistar($query, $fecinicio, $fecfin, $sucursal, $area=null)
    // {
    //     return $query
    //         ->where(function ($subquery) use ($fecinicio) {
    //             if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
    //                 $subquery->whereHas('comandas', function ($q2) use ($fecinicio) {
    //                     $q2->whereHas('movimientoref', function ($q3) use ($fecinicio) {
    //                         $q3->where('fecha', '>=', date_format(date_create($fecinicio),  'Y-m-d H:i:s'));
    //                     });
    //                 });
    //             }
    //         })
    //         ->where(function ($subquery) use ($fecfin) {
    //             if (!is_null($fecfin) && strlen($fecfin) > 0) {
    //                 $subquery->whereHas('comandas', function ($q2) use ($fecfin) {
    //                     $q2->whereHas('movimientoref', function ($q3) use ($fecfin) {
    //                         $q3->where('fecha', '<=', date_format(date_create($fecfin),  'Y-m-d H:i:s'));
    //                     });
    //                 });
    //             }
    //         })
    //         ->where(function ($subquery) use ($sucursal) {
    //             if (!is_null($sucursal) && strlen($sucursal) > 0) {
    //                 $subquery->whereHas('comandas', function ($q2) use ($sucursal) {
    //                     $q2->where('idsucursal',  $sucursal);
    //                 });
    //             }
    //         })
    //         ->orderBy('iddetallemovalmacen', 'DESC');
    // }
}

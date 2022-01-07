<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    public $connection = 'pgsql';
    protected $table = 'detallemovimiento';
    protected $primaryKey = 'iddetallemovimiento';

    //DETALLE MOV HAS 4 FOREIGN KEYS
    // IDMOVIMIENTO ----> REFERENCES B/F/T   => idtipomovimiento = 2 "venta"
    // IDMOVIMIENTOREF -----> REFERNCES PEDIDO  => idtipomovimiento = 5 "pedido"

    // public function movimiento()
    // {
    //     return $this->belongsTo(Movimiento::class, 'idmovimiento');
    // }
    use \Awobaz\Compoships\Compoships;

    public function detallemovimientoalmacen()
    {
        return $this->belongsTo(DetalleMovimientoAlmacen::class, 'iddetallemovalmacen');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function movimientoventa()
    {
        return $this->belongsTo(Movimiento::class, ['idmovimiento', 'idsucursal'], ['idmovimiento', 'idsucursal']);
    }

    public function movimientopedido()
    {
        return $this->belongsTo(Movimiento::class, 'idmovimientoref');
    }
}

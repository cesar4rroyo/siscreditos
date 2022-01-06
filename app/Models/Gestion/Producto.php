<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $connection = 'pgsql';
    protected $table = 'producto';
    protected $primaryKey = 'idproducto';

    use \Awobaz\Compoships\Compoships;


    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'idunidadbase');
    }
    public function impresora()
    {
        return $this->belongsTo(Impresora::class, 'idimpresora');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }

    public function detallemovalmacen()
    {
        return $this->hasMany(DetalleMovimientoAlmacen::class, ['idproducto', 'idsucursal'], ['idproducto', 'idsucursal']);
    }
}

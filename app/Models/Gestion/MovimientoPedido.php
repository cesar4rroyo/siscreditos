<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class MovimientoPedido extends Model
{
    public $connection = 'pgsql';
    protected $table = 'detallemovimiento';
    protected $primaryKey = 'idmovimientoref';
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'idmovimientoref');
    }
}

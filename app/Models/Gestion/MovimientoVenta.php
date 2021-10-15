<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class MovimientoVenta extends Model
{
    public $connection = 'pgsql';
    protected $table = 'detallemovimiento';
    protected $primaryKey = 'idmovimiento';
}
